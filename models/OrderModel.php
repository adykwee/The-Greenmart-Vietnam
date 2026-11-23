<?php
require_once 'BaseModel.php';

class OrderModel extends BaseModel {
    public const STATUS_LABELS = [
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy'
    ];

    public function getCustomerOrders($userId) {
        return $this->query(
            'SELECT id, total_money, status, created_at
             FROM orders WHERE user_id = :user_id ORDER BY created_at DESC, id DESC',
            ['user_id' => $userId]
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerOrder($userId, $orderId) {
        return $this->query(
            'SELECT id, total_money, status, created_at
             FROM orders WHERE id = :order_id AND user_id = :user_id',
            ['order_id' => $orderId, 'user_id' => $userId]
        )->fetch(PDO::FETCH_ASSOC);
    }

    public function getCustomerOrderItems($userId, $orderId) {
        return $this->query(
            'SELECT p.name, d.price, d.quantity
             FROM orders o
             JOIN order_details d ON d.order_id = o.id
             LEFT JOIN products p ON p.id = d.product_id
             WHERE o.id = :order_id AND o.user_id = :user_id ORDER BY d.id',
            ['order_id' => $orderId, 'user_id' => $userId]
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalesReport($fromDate, $toDate) {
        $where = "o.status = 'completed'";
        $params = [];
        if ($fromDate !== '') {
            $where .= ' AND o.created_at >= :from_date';
            $params['from_date'] = $fromDate;
        }
        if ($toDate !== '') {
            $where .= ' AND o.created_at <= :to_date';
            $params['to_date'] = $toDate . ' 23:59:59';
        }

        $summary = $this->query(
            "SELECT COALESCE(SUM(o.total_money), 0) AS revenue, COUNT(*) AS completed_orders
             FROM orders o WHERE $where",
            $params
        )->fetch(PDO::FETCH_ASSOC);
        $summary['best_sellers'] = $this->query(
            "SELECT p.id, p.name, SUM(d.quantity) AS units_sold, SUM(d.price * d.quantity) AS revenue
             FROM orders o
             JOIN order_details d ON d.order_id = o.id
             JOIN products p ON p.id = d.product_id
             WHERE $where
             GROUP BY p.id, p.name
             ORDER BY units_sold DESC, p.id ASC LIMIT 10",
            $params
        )->fetchAll(PDO::FETCH_ASSOC);

        return $summary;
    }
    
    public function createOrder($user_id, $total_money, $cart_items) {
        try {
            // 1. Bắt đầu transaction (Khóa DB lại để xử lý)
            $this->conn->beginTransaction();

            // 2. Thêm vào bảng orders trước
            $sqlOrder = "INSERT INTO orders (user_id, total_money) VALUES (:user_id, :total_money)";
            $stmt = $this->conn->prepare($sqlOrder);
            $stmt->execute(['user_id' => $user_id, 'total_money' => $total_money]);
            
            // Lấy ID của đơn hàng vừa tạo
            $order_id = $this->conn->lastInsertId();

            // 3. Thêm từng sản phẩm vào bảng order_details
            $sqlDetail = "INSERT INTO order_details (order_id, product_id, price, quantity) 
                          VALUES (:order_id, :product_id, :price, :quantity)";
            $stmtDetail = $this->conn->prepare($sqlDetail);

            foreach ($cart_items as $item) {
                $stmtDetail->execute([
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ]);
            }

            // 4. Nếu mọi thứ OK -> Lưu chính thức (Commit)
            $this->conn->commit();
            return $order_id;

        } catch (Exception $e) {
            // 5. Nếu có lỗi -> Hủy toàn bộ (Rollback)
            $this->conn->rollBack();
            return false;
        }
    }
}
?>
