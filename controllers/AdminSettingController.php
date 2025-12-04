<?php
require_once './models/BaseModel.php';

class AdminSettingController extends BaseController {
    private $model;

    public function __construct() {
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    public function index() {
        // 1. Lấy settings hiện tại
        $settingsRaw = $this->model->all('settings');
        $settings = [];
        foreach($settingsRaw as $s) {
            $settings[$s['config_key']] = $s['config_value'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // --- XỬ LÝ UPLOAD ẢNH LOGO ---
            $logoName = $settings['site_logo'] ?? '';
            if (!empty($_FILES['site_logo']['name'])) {
                $newLogo = $this->handleUpload($_FILES['site_logo'], 'logo');
                if ($newLogo) $logoName = $newLogo;
            }

            // --- XỬ LÝ UPLOAD ẢNH GIỚI THIỆU (MỚI THÊM) ---
            $aboutImageName = $settings['page_about_image'] ?? '';
            if (!empty($_FILES['page_about_image']['name'])) {
                $newAboutImg = $this->handleUpload($_FILES['page_about_image'], 'about');
                if ($newAboutImg) $aboutImageName = $newAboutImg;
            }

            // --- 3. Xử lý BANNER TRANG CHỦ (MỚI THÊM) ---
            $bannerName = $settings['page_home_banner'] ?? '';
            if (!empty($_FILES['page_home_banner']['name'])) {
                $newBanner = $this->handleUpload($_FILES['page_home_banner'], 'banner');
                if ($newBanner) $bannerName = $newBanner;
            }

            // --- LƯU DỮ LIỆU ---
            // Lưu các field text
            foreach ($_POST as $key => $value) {
                if (in_array($key, ['site_logo', 'page_about_image', 'page_home_banner'])) continue; 

                $sql = "INSERT INTO settings (config_key, config_value) VALUES (:key, :value) 
                        ON DUPLICATE KEY UPDATE config_value = :value";
                $this->model->query($sql, ['value' => trim($value), 'key' => $key]);
            }
            
            // Lưu tên file ảnh vào DB
            $this->model->query("INSERT INTO settings (config_key, config_value) VALUES ('site_logo', :val) ON DUPLICATE KEY UPDATE config_value = :val", ['val' => $logoName]);
            $this->model->query("INSERT INTO settings (config_key, config_value) VALUES ('page_about_image', :val) ON DUPLICATE KEY UPDATE config_value = :val", ['val' => $aboutImageName]);
            
            // Lưu Banner mới
            $this->model->query("INSERT INTO settings (config_key, config_value) VALUES ('page_home_banner', :val) ON DUPLICATE KEY UPDATE config_value = :val", ['val' => $bannerName]);
            
            header("Location: index.php?controller=adminSetting&action=index");
        }

        $this->view('admin/settings/index', ['settings' => $settings]);
    }
    
    // Hàm upload (đã chỉnh sửa để nhận prefix tên file)
    private function handleUpload($file, $prefix = 'file') {
        if ($file['error'] == 0) {
            $targetDir = "assets/uploads/";
            $fileName = time() . "_" . $prefix . "_" . basename($file["name"]);
            $targetFile = $targetDir . $fileName;
            
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    return $fileName;
                }
            }
        }
        return null;
    }
}
?>