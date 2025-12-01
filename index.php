<?php
session_start();

// 1. Load các file cấu hình và core
require_once './config/database.php';
require_once './controllers/BaseController.php';
require_once './models/BaseModel.php';

// 2. Lấy thông tin Controller và Action từ URL
// Mặc định là 'home' và 'index'
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'HomeController';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// 3. Đường dẫn file Controller
$controllerPath = "./controllers/$controllerName.php";

// 4. Kiểm tra và khởi tạo Controller
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    
    // Kiểm tra class có tồn tại không
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        // Kiểm tra method (action) có tồn tại trong class không
        if (method_exists($controller, $actionName)) {
            // Gọi hàm action tương ứng
            $controller->$actionName();
        } else {
            echo "Method $actionName không tồn tại trong $controllerName";
        }
    } else {
        echo "Class $controllerName không tìm thấy";
    }
} else {
    // Xử lý 404 Not Found
    echo "Trang không tồn tại (Controller $controllerName not found)";
}
?>