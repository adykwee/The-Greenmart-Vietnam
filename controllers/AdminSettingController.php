<?php
require_once './models/BaseModel.php';

class AdminSettingController extends BaseController {
    private $model;

    public function __construct() {
        // Bắt buộc phải là Admin
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    // Lấy data và xử lý update
    public function index() {
        // 1. Lấy tất cả cấu hình hiện tại (settingsRaw)
        $settingsRaw = $this->model->all('settings');
        // Chuyển đổi thành mảng dễ truy cập: [key => value]
        $settings = [];
        foreach($settingsRaw as $s) {
            $settings[$s['config_key']] = $s['config_value'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý LOGO/IMAGE (nếu có)
            $imageName = $settings['site_logo']; // Giữ tên cũ
            if (!empty($_FILES['site_logo']['name'])) {
                $newImage = $this->handleUpload($_FILES['site_logo']);
                if ($newImage) {
                    $imageName = $newImage;
                    // Xóa file cũ (nếu cần)
                }
            }

            // 2. Lặp qua các field text/value để update
            foreach ($_POST as $key => $value) {
                // Bỏ qua logo vì ta xử lý nó riêng
                if ($key == 'site_logo') continue;

                // Update trong Database
                $sql = "UPDATE settings SET config_value = :value WHERE config_key = :key";
                $this->model->query($sql, ['value' => trim($value), 'key' => $key]);
            }
            
            // Update logo sau cùng
            $sqlLogo = "UPDATE settings SET config_value = :value WHERE config_key = 'site_logo'";
            $this->model->query($sqlLogo, ['value' => $imageName]);
            
            // Redirect để cập nhật giao diện
            header("Location: index.php?controller=adminSetting&action=index");
        }

        // Truyền settings vào View
        $this->view('admin/settings/index', ['settings' => $settings]);
    }
    
    // Hàm upload ảnh (Dùng lại từ AdminProductController)
    private function handleUpload($file) {
        if ($file['error'] == 0) {
            $targetDir = "assets/uploads/";
            $fileName = time() . "_setting_" . basename($file["name"]);
            $targetFile = $targetDir . $fileName;
            
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    return $fileName;
                }
            }
        }
        return null;
    }
}
?>