<?php
require_once './models/ProductModel.php';
require_once './models/OrderModel.php'; // Chúng ta sẽ tạo file này ở Bước 3

class CartController extends BaseController {
    private $productModel;
    private $orderModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
    }

    // 1. Xem giỏ hàng
    public function index() {
        // Lấy giỏ hàng từ Session, nếu chưa có thì là mảng rỗng
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $this->view('client/cart', ['cart' => $cart]);
    }

    // 2. Thêm sản phẩm vào giỏ
    public function add() {
        $id = $_GET['id'];
        $product = $this->productModel->find('products', $id);

        if ($product) {
            // Nếu sản phẩm chưa có trong giỏ -> Thêm mới với số lượng 1
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'quantity' => 1
                ];
            } else {
                // Nếu đã có -> Tăng số lượng lên 1
                $_SESSION['cart'][$id]['quantity']++;
            }
        }
        // Chuyển hướng về trang giỏ hàng
        header("Location: index.php?controller=cart&action=index");
    }

    // 3. Xóa sản phẩm khỏi giỏ
    public function delete() {
        $id = $_GET['id'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: index.php?controller=cart&action=index");
    }

    // 4. Cập nhật số lượng (Dùng cho nút +/- trong giỏ)
    public function update() {
        $id = $_GET['id'];
        $type = $_GET['type']; // 'increase' hoặc 'decrease'

        if (isset($_SESSION['cart'][$id])) {
            if ($type == 'increase') {
                $_SESSION['cart'][$id]['quantity']++;
            } else {
                if ($_SESSION['cart'][$id]['quantity'] > 1) {
                    $_SESSION['cart'][$id]['quantity']--;
                } else {
                    unset($_SESSION['cart'][$id]); // Nếu giảm về 0 thì xóa luôn
                }
            }
        }
        header("Location: index.php?controller=cart&action=index");
    }

    // 5. Thanh toán (Checkout)
    public function checkout() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            // Lưu lại URL hiện tại để login xong quay lại (nâng cao)
            echo "<script>alert('Bạn cần đăng nhập để thanh toán!'); window.location.href='index.php?controller=auth&action=login';</script>";
            return;
        }

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (empty($cart)) {
            header("Location: index.php");
            return;
        }

        // Tính tổng tiền
        $total_money = 0;
        foreach ($cart as $item) {
            $total_money += $item['price'] * $item['quantity'];
        }

        // Gọi Model để lưu đơn hàng
        $user_id = $_SESSION['user']['id'];
        $order_id = $this->orderModel->createOrder($user_id, $total_money, $cart);

        if ($order_id) {
            unset($_SESSION['cart']); // Xóa giỏ hàng sau khi mua thành công
            echo "<script>alert('Đặt hàng thành công! Mã đơn: #$order_id'); window.location.href='index.php';</script>";
        } else {
            echo "Lỗi hệ thống, vui lòng thử lại.";
        }
    }
}
?>