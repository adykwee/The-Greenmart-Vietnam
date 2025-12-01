<?php
class AdminOrderController extends BaseController {
    private $model;

    public function __construct() {
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    // Danh sách đơn hàng
    public function index() {
        // Lấy đơn hàng kèm tên người mua (JOIN bảng users)
        $sql = "SELECT orders.*, users.full_name, users.email 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                ORDER BY orders.created_at DESC";
        $orders = $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        $this->view('admin/orders/index', ['orders' => $orders]);
    }

    // Xem chi tiết đơn hàng
    public function detail() {
        $id = $_GET['id'];
        
        // 1. Lấy thông tin chung đơn hàng
        $sqlOrder = "SELECT orders.*, users.full_name, users.email, users.id as user_id
                     FROM orders 
                     JOIN users ON orders.user_id = users.id 
                     WHERE orders.id = :id";
        $order = $this->model->query($sqlOrder, ['id' => $id])->fetch(PDO::FETCH_ASSOC);

        // 2. Lấy chi tiết sản phẩm trong đơn (JOIN products)
        $sqlDetails = "SELECT od.*, p.name, p.image 
                       FROM order_details od 
                       JOIN products p ON od.product_id = p.id 
                       WHERE od.order_id = :id";
        $details = $this->model->query($sqlDetails, ['id' => $id])->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/orders/detail', ['order' => $order, 'details' => $details]);
    }

    // Cập nhật trạng thái (Pending -> Completed...)
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            
            $sql = "UPDATE orders SET status = :status WHERE id = :id";
            $this->model->query($sql, ['status' => $status, 'id' => $id]);
            
            header("Location: index.php?controller=adminOrder&action=detail&id=$id");
        }
    }
}
?>