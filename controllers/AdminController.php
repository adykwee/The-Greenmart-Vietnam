<?php
require_once './models/OrderModel.php';

class AdminController extends BaseController {
    private $model;

    public function __construct() {
        $this->checkAdmin();
        $this->model = new OrderModel();
    }

    public function dashboard() {
        $fromDate = $_GET['from_date'] ?? '';
        $toDate = $_GET['to_date'] ?? '';
        $reportError = null;
        if (!$this->isValidReportDate($fromDate) || !$this->isValidReportDate($toDate)) {
            $reportError = 'Ngày báo cáo không hợp lệ.';
        } elseif ($fromDate !== '' && $toDate !== '' && $fromDate > $toDate) {
            $reportError = 'Từ ngày phải trước hoặc bằng đến ngày.';
        }
        $salesReport = $reportError === null ? $this->model->getSalesReport($fromDate, $toDate) : null;

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
            'salesReport' => $salesReport,
            'reportError' => $reportError,
            'fromDate' => is_string($fromDate) ? $fromDate : '',
            'toDate' => is_string($toDate) ? $toDate : '',
            'newOrders' => $newOrders,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers
        ]);
    }

    private function isValidReportDate($value) {
        return $value === '' || (is_string($value)
            && preg_match('/\A([1-9]\d{3})-(\d{2})-(\d{2})\z/', $value, $parts)
            && checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]));
    }
}
?>
