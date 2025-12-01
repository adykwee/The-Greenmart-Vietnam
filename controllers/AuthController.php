<?php
require_once './models/UserModel.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // 1. Xử lý Đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $confirm_pass = $_POST['confirm_password']; // Lấy thêm trường này

            // 1. Kiểm tra mật khẩu nhập lại
            if ($pass != $confirm_pass) {
                $this->view('client/auth/register', ['error' => 'Mật khẩu nhập lại không khớp!']);
                return;
            }

            // 2. Kiểm tra email đã tồn tại chưa
            if ($this->userModel->getUserByEmail($email)) {
                $this->view('client/auth/register', ['error' => 'Email này đã được sử dụng!']);
                return;
            } 
            
            // 3. Tạo tài khoản thành công
            $this->userModel->registerUser($name, $email, $pass);
            
            // Thông báo và chuyển về trang đăng nhập
            echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.'); window.location.href='index.php?controller=auth&action=login';</script>";
            
        } else {
            // GET request: Hiển thị form
            $this->view('client/auth/register');
        }
    }

    // 2. Xử lý Đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Tìm user trong DB
            $user = $this->userModel->getUserByEmail($email);

            // Kiểm tra: Có user VÀ Mật khẩu khớp
            if ($user && password_verify($password, $user['password'])) {
                
                // Lưu thông tin vào SESSION
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['full_name'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar']
                ];

                // Phân quyền điều hướng
                if ($user['role'] == 'admin') {
                    header("Location: index.php?controller=admin&action=dashboard");
                } else {
                    header("Location: index.php"); // Về trang chủ
                }
                exit();
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
                $this->view('client/auth/login', ['error' => $error]);
            }
        } else {
            $this->view('client/auth/login');
        }
    }

    // 3. Đăng xuất
    public function logout() {
        session_destroy(); // Xóa sạch session
        header("Location: index.php");
        exit();
    }

    // Thêm vào trong class AuthController
    
    // 1. Hiển thị trang hồ sơ
    public function profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        
        // Lấy thông tin mới nhất từ DB (đề phòng Session bị cũ)
        $user = $this->userModel->find('users', $_SESSION['user']['id']);
        
        $this->view('client/auth/profile', ['user' => $user]);
    }

    // 2. Xử lý cập nhật
    public function updateProfile() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user']['id'];
            $fullname = $_POST['fullname'];
            
            // Lấy thông tin cũ để giữ lại avatar cũ nếu không upload mới
            $currentUser = $this->userModel->find('users', $id);
            $avatarName = $currentUser['avatar'];

            // --- XỬ LÝ UPLOAD AVATAR ---
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $targetDir = "assets/uploads/";
                $fileName = time() . "_avatar_" . basename($_FILES["avatar"]["name"]);
                $targetFile = $targetDir . $fileName;
                
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileType, $allowed)) {
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                        // Upload thành công -> Cập nhật tên file mới
                        $avatarName = $fileName;
                        
                        // (Tùy chọn) Xóa avatar cũ nếu không phải là default.png
                        if ($currentUser['avatar'] != 'default.png' && file_exists($targetDir . $currentUser['avatar'])) {
                            unlink($targetDir . $currentUser['avatar']);
                        }
                    }
                }
            }
            // --- KẾT THÚC UPLOAD ---

            // Cập nhật Database
            $this->userModel->updateProfile($id, $fullname, $avatarName);

            // QUAN TRỌNG: Cập nhật lại SESSION để hiển thị ngay lập tức trên Header
            $_SESSION['user']['name'] = $fullname;
            $_SESSION['user']['avatar'] = $avatarName;

            echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='index.php?controller=auth&action=profile';</script>";
        }
    }
}
?>