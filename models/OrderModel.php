<?php
require_once 'BaseModel.php';

class OrderModel extends BaseModel {
    
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