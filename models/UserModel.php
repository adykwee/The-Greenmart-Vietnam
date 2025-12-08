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

    public function updatePassword($id, $newPasswordHash) {
        // 1. Kiểm tra lại tên bảng và tên cột
        // Tên bảng phải là 'users'
        // Tên cột mật khẩu phải là 'password' (nếu bạn đặt là 'pass' hay 'pwd' thì phải sửa lại)
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        // Thêm try-catch để bắt lỗi SQL nếu có
        try {
            return $stmt->execute([
                'password' => $newPasswordHash,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            die();
        }
    }
}
?>