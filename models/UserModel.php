<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel {
    private $table = 'users';

    // Đăng ký: Thêm user mới
    public function registerUser($name, $email, $password) {
        // Mã hóa mật khẩu trước khi lưu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $data = [
            'full_name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'role' => 'user' // Mặc định là user thường
        ];
        return $this->create($this->table, $data);
    }

    // Đăng nhập: Lấy thông tin user theo email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm vào trong class UserModel
    public function updateProfile($id, $fullname, $avatar) {
        $sql = "UPDATE users SET full_name = :fullname, avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'fullname' => $fullname,
            'avatar' => $avatar,
            'id' => $id
        ]);
    }

    // Thêm vào class AuthController

    public function changePassword() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user']['id'];
            $current_pass = $_POST['current_password'];
            $new_pass = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];

            // 2. Lấy thông tin user từ DB để lấy mật khẩu đã mã hóa
            $user = $this->userModel->getUserById($id);

            // 3. Kiểm tra mật khẩu cũ có khớp không
            if (!password_verify($current_pass, $user['password'])) {
                echo "<script>alert('Mật khẩu hiện tại không đúng!'); history.back();</script>";
                return;
            }

            // 4. Kiểm tra mật khẩu mới nhập lại có khớp không
            if ($new_pass !== $confirm_pass) {
                echo "<script>alert('Mật khẩu mới không khớp!'); history.back();</script>";
                return;
            }

            // 5. Kiểm tra độ dài mật khẩu (VD: > 6 ký tự)
            if (strlen($new_pass) < 6) {
                echo "<script>alert('Mật khẩu mới phải có ít nhất 6 ký tự!'); history.back();</script>";
                return;
            }

            // 6. Mã hóa mật khẩu mới và cập nhật
            $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $this->userModel->updatePassword($id, $new_pass_hash);

            echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='index.php?controller=auth&action=profile';</script>";
        }
    }
}
?>