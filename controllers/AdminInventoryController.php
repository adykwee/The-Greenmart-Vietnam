<?php
require_once './models/ProductModel.php';

class AdminInventoryController extends BaseController {
    private $productModel;

    public function __construct() {
        // Chỉ Admin mới được truy cập
        $this->checkAdmin();
        $this->productModel = new ProductModel();
    }

    // Trang tổng quan Quản lý tồn kho
    // URL: index.php?controller=adminInventory&action=index
    public function index() {
        $filter = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';
        $products = $this->productModel->getInventoryStatus($filter);
        $summary = $this->productModel->getInventorySummary();
        $history = $this->productModel->getImportHistory();
        
        $this->view('admin/inventory/index', [
            'products'       => $products,
            'summary'        => $summary,
            'history'        => $history,
            'current_filter' => $filter
        ]);
    }

    // Form tạo phiếu nhập hàng
    // URL: index.php?controller=adminInventory&action=import
    public function import() {
        $products = $this->productModel->getAllProducts();
        $selected_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
        $this->view('admin/inventory/import', [
            'products'    => $products,
            'selected_id' => $selected_id
        ]);
    }

    // Xử lý lưu phiếu nhập hàng
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id   = intval($_POST['product_id']);
            $quantity     = intval($_POST['quantity']);
            $import_price = intval($_POST['import_price']);
            $supplier     = trim($_POST['supplier']);
            $note         = trim($_POST['note']);
            $created_by   = $_SESSION['user']['id'] ?? 1;

            if ($product_id <= 0 || $quantity <= 0) {
                echo "<script>alert('Vui lòng chọn sản phẩm và nhập số lượng lớn hơn 0!'); window.history.back();</script>";
                return;
            }

            $success = $this->productModel->importStock(
                $product_id, 
                $quantity, 
                $import_price, 
                $supplier, 
                $note, 
                $created_by
            );

            if ($success) {
                echo "<script>alert('Nhập hàng thành công! Số lượng tồn kho đã được cập nhật.'); window.location.href='index.php?controller=adminInventory&action=index';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong quá trình nhập hàng!'); window.history.back();</script>";
            }
        }
    }
}
?>
