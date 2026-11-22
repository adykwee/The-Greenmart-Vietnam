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

            // Câu lệnh trừ tồn kho
            $sqlDeductStock = "UPDATE products SET stock_quantity = stock_quantity - :quantity 
                               WHERE id = :product_id AND stock_quantity >= :quantity";
            $stmtDeductStock = $this->conn->prepare($sqlDeductStock);

            foreach ($cart_items as $item) {
                // 3.1 Trừ số lượng tồn kho
                $stmtDeductStock->execute([
                    'quantity'   => $item['quantity'],
                    'product_id' => $item['id']
                ]);

                // Nếu số dòng bị ảnh hưởng = 0 nghĩa là tồn kho không đủ!
                if ($stmtDeductStock->rowCount() === 0) {
                    throw new Exception("Sản phẩm ID " . $item['id'] . " đã hết hàng hoặc không đủ tồn kho!");
                }

                // 3.2 Lưu chi tiết đơn hàng
                $stmtDetail->execute([
                    'order_id'   => $order_id,
                    'product_id' => $item['id'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity']
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