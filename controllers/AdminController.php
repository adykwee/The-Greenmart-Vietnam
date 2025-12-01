<?php
class AdminController extends BaseController {
    private $model;

    public function __construct() {
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    public function dashboard() {
        // 1. Tổng doanh thu (Chỉ tính đơn đã hoàn thành)
        $sqlRevenue = "SELECT SUM(total_money) as total FROM orders WHERE status = 'completed'";
        $revenue = $this->model->query($sqlRevenue)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 2. Tổng đơn hàng mới (Pending)
        $sqlNewOrders = "SELECT COUNT(*) as total FROM orders WHERE status = 'pending'";
        $newOrders = $this->model->query($sqlNewOrders)->fetch(PDO::FETCH_ASSOC)['total'];

        // 3. Tổng sản phẩm
        $sqlProducts = "SELECT COUNT(*) as total FROM products";
        $totalProducts = $this->model->query($sqlProducts)->fetch(PDO::FETCH_ASSOC)['total'];

        // 4. Tổng thành viên
        $sqlUsers = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
        $totalUsers = $this->model->query($sqlUsers)->fetch(PDO::FETCH_ASSOC)['total'];

        // Truyền qua View
        $this->view('admin/dashboard', [
            'revenue' => $revenue,
            'newOrders' => $newOrders,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers
        ]);
    }
}
?>