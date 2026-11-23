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
        $this->showCatalog('index');
    }

    // URL: index.php?controller=product&action=detail&id=5
    // Xem chi tiết 1 sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $this->view('client/products/detail', [
                    'product' => $product,
                    // --- Dữ liệu SEO ---
                    'meta_title' => $product['name'],
                    'meta_desc' => $product['description'], // Lấy mô tả ngắn làm meta desc
                    'meta_image' => $product['image']
                ]);
            } else {
                echo "Sản phẩm không tồn tại!";
            }
        }
    }

    // URL: index.php?controller=product&action=search&keyword=iphone
    // Tìm kiếm sản phẩm
    public function search() {
        $this->showCatalog('search');
    }

    private function showCatalog($action) {
        $filters = [];
        $error = null;
        foreach (['keyword', 'min_price', 'max_price'] as $key) {
            $value = $_GET[$key] ?? '';
            $filters[$key] = is_string($value) ? trim($value) : '';
            if (!is_string($value)) {
                $error = 'Điều kiện tìm kiếm không hợp lệ.';
            }
        }

        $prices = [];
        foreach (['min_price', 'max_price'] as $key) {
            $value = $filters[$key];
            $prices[$key] = $value === '' ? null : filter_var($value, FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 0, 'max_range' => 2147483647]
            ]);
        }
        if (in_array(false, $prices, true)) {
            $error = 'Giá phải là số nguyên từ 0 đến 2.147.483.647 đồng.';
        } elseif ($prices['min_price'] !== null && $prices['max_price'] !== null
            && $prices['min_price'] > $prices['max_price']) {
            $error = 'Giá từ phải nhỏ hơn hoặc bằng giá đến.';
        }

        $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 1;
        $results = $error === null
            ? $this->productModel->searchProducts($filters['keyword'], $prices['min_price'], $prices['max_price'], $page)
            : ['data' => [], 'total_pages' => 0, 'current_page' => 1];
        $pageQuery = ['controller' => 'product', 'action' => $action];
        foreach ($filters as $key => $value) {
            if ($value !== '') {
                $pageQuery[$key] = $value;
            }
        }

        $this->view('client/products/list', [
            'products' => $results['data'],
            'totalPages' => $results['total_pages'],
            'currentPage' => $results['current_page'],
            'filters' => $filters,
            'filterError' => $error,
            'pageQuery' => $pageQuery,
            'title' => $action === 'search' ? 'Kết quả tìm kiếm' : 'Cửa Hàng'
        ]);
    }
}
?>
