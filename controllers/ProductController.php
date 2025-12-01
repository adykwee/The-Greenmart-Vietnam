<?php
require_once './models/ProductModel.php';

class ProductController extends BaseController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // URL: index.php?controller=product&action=index
    // Xem danh sách sản phẩm (Trang cửa hàng)
    public function index() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
        // Lấy 8 sản phẩm mỗi trang
        $pagingData = $this->productModel->paginate('products', $page, 8);
    
        $this->view('client/products/list', [
            'products' => $pagingData['data'],
            'totalPages' => $pagingData['total_pages'],
            'currentPage' => $pagingData['current_page']
        ]);
    }

    // URL: index.php?controller=product&action=detail&id=5
    // Xem chi tiết 1 sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                // Có thể thêm logic lấy sản phẩm liên quan ở đây
                $this->view('client/products/detail', ['product' => $product]);
            } else {
                echo "Sản phẩm không tồn tại!";
            }
        }
    }

    // URL: index.php?controller=product&action=search&keyword=iphone
    // Tìm kiếm sản phẩm
    public function search() {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $products = $this->productModel->searchProduct($keyword);
        
        $this->view('client/products/list', [
            'products' => $products,
            'title' => "Kết quả tìm kiếm: $keyword"
        ]);
    }
}
?>