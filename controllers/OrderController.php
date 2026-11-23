<?php
require_once './models/OrderModel.php';

class OrderController extends BaseController {
    private $orderModel;

    public function __construct() {
        if (!isset($_SESSION['user']['id'])) {
            $this->redirect('index.php?controller=auth&action=login');
        }
        $this->orderModel = new OrderModel();
    }

    public function index() {
        $this->view('client/orders/history', [
            'orders' => $this->orderModel->getCustomerOrders($_SESSION['user']['id']),
            'statusLabels' => OrderModel::STATUS_LABELS
        ]);
    }

    public function detail() {
        $orderId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $userId = $_SESSION['user']['id'];
        $order = $orderId === false ? false : $this->orderModel->getCustomerOrder($userId, $orderId);
        if (!$order) {
            http_response_code(404);
        }

        $this->view('client/orders/detail', [
            'order' => $order,
            'items' => $order ? $this->orderModel->getCustomerOrderItems($userId, $orderId) : [],
            'statusLabels' => OrderModel::STATUS_LABELS
        ]);
    }
}
