<?php
require_once './models/ProductModel.php';

class AdminProductController extends BaseController {
    private $productModel;

    public function __construct() {
        // 1. CHỐNG HACK: Chỉ Admin mới được vào đây
        $this->checkAdmin(); 
        
        $this->productModel = new ProductModel();
    }

    // URL: index.php?controller=adminProduct&action=index
    // Trang quản lý danh sách (Bảng Admin)
    public function index() {
        $products = $this->productModel->getAllProducts();
        $this->view('admin/products/index', ['products' => $products]);
    }

    // URL: index.php?controller=adminProduct&action=create
    // Hiển thị form thêm mới
    public function create() {
        $this->view('admin/products/add');
    }

    // Xử lý lưu sản phẩm mới (Có upload ảnh)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $desc = $_POST['description'];
            $content = $_POST['content'];
            
            // Xử lý upload ảnh
            $imageName = $this->handleUpload($_FILES['image']);

            // Lưu vào DB
            $this->productModel->addProduct($name, $price, $desc, $content, $imageName);
            
            header("Location: index.php?controller=adminProduct&action=index");
        }
    }

    // URL: index.php?controller=adminProduct&action=edit&id=5
    // Hiển thị form sửa
    public function edit() {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);
        $this->view('admin/products/edit', ['product' => $product]);
    }

    // Xử lý cập nhật sản phẩm
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $desc = $_POST['description'];
            $content = $_POST['content'];
            
            // Lấy thông tin cũ để biết ảnh cũ là gì
            $oldProduct = $this->productModel->getProductById($id);
            $imageName = $oldProduct['image'];

            // Nếu người dùng có chọn ảnh mới thì upload và thay thế
            if (!empty($_FILES['image']['name'])) {
                // Upload ảnh mới
                $newImage = $this->handleUpload($_FILES['image']);
                if ($newImage) {
                    $imageName = $newImage;
                    // Xóa ảnh cũ đi cho đỡ rác server
                    if (file_exists("./assets/uploads/" . $oldProduct['image'])) {
                        unlink("./assets/uploads/" . $oldProduct['image']);
                    }
                }
            }

            // Update DB
            $this->productModel->updateProduct($id, $name, $price, $desc, $content, $imageName);
            
            header("Location: index.php?controller=adminProduct&action=index");
        }
    }

    // Xóa sản phẩm
    public function delete() {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);
        
        // Xóa file ảnh vật lý
        if ($product['image'] && file_exists("./assets/uploads/" . $product['image'])) {
            unlink("./assets/uploads/" . $product['image']);
        }

        // Xóa trong DB
        $this->productModel->deleteProduct($id);
        
        header("Location: index.php?controller=adminProduct&action=index");
    }

    // --- Hàm phụ trợ: Xử lý Upload file (Tái sử dụng) ---
    private function handleUpload($file) {
        if ($file['error'] == 0) {
            $targetDir = "assets/uploads/";
            // Tạo tên file ngẫu nhiên để tránh trùng
            $fileName = time() . "_" . basename($file["name"]);
            $targetFile = $targetDir . $fileName;
            
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileType, $allowed)) {
                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    return $fileName;
                }
            }
        }
        return null; // Trả về null nếu lỗi hoặc không có file
    }
}
?>