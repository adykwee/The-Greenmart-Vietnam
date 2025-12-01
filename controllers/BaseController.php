<?php
require_once './models/BaseModel.php'; 

class BaseController {
    
    // Hàm gọi view và truyền dữ liệu
    protected function view($path, $data = []) {
        // --- ĐOẠN CODE MỚI THÊM ---
        // 1. Tự động lấy cấu hình website mỗi khi gọi view
        $model = new BaseModel();
        $settingsRaw = $model->all('settings');
        
        $settings = [];
        foreach ($settingsRaw as $s) {
            $settings[$s['config_key']] = $s['config_value'];
        }
        
        // 2. Gộp settings vào mảng data để truyền xuống view
        $data['settings'] = $settings;
        // ---------------------------

        // Tách mảng data thành các biến (VD: $products, $settings...)
        extract($data); 

        $viewFile = "./views/" . $path . ".php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $viewFile không tồn tại");
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }

    protected function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}
?>