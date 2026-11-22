<?php
require_once 'BaseModel.php';

class ProductModel extends BaseModel {
    private $table = 'products';

    public function getAllProducts() {
        return $this->all($this->table);
    }

    public function getProductById($id) {
        return $this->find($this->table, $id);
    }

    public function addProduct($name, $price, $desc, $content, $image) {
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $desc,
            'content' => $content, // Trường nội dung dài (HTML)
            'image' => $image
        ];
        return $this->create($this->table, $data);
    }

    public function updateProduct($id, $name, $price, $desc, $content, $image) {
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $desc,
            'content' => $content,
            'image' => $image
        ];
        return $this->update($this->table, $id, $data);
    }

    public function deleteProduct($id) {
        return $this->delete($this->table, $id);
    }

    public function searchProduct($keyword) {
        $sql = "SELECT * FROM $this->table WHERE name LIKE :keyword";
        return $this->query($sql, ['keyword' => "%$keyword%"])->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- CÁC HÀM QUẢN LÝ TỒN KHO & NHẬP HÀNG (F11 - N5 HÙNG DŨNG) ---

    // 1. Thống kê tổng hợp số lượng tồn kho (Hàm tổng hợp Aggregate)
    public function getInventorySummary() {
        $sql = "SELECT 
                    COUNT(*) AS total_products,
                    COALESCE(SUM(stock_quantity), 0) AS total_stock,
                    COUNT(CASE WHEN stock_quantity <= 0 THEN 1 END) AS out_of_stock,
                    COUNT(CASE WHEN stock_quantity > 0 AND stock_quantity < 10 THEN 1 END) AS low_stock,
                    COUNT(CASE WHEN stock_quantity >= 10 THEN 1 END) AS in_stock
                FROM products";
        return $this->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Lấy danh sách sản phẩm kèm trạng thái tồn kho (có lọc theo trạng thái, sắp xếp theo ID)
    public function getInventoryStatus($filter = 'all') {
        $whereClause = "";
        if ($filter === 'low_stock') {
            $whereClause = "WHERE stock_quantity > 0 AND stock_quantity < 10";
        } elseif ($filter === 'out_of_stock') {
            $whereClause = "WHERE stock_quantity <= 0";
        } elseif ($filter === 'in_stock') {
            $whereClause = "WHERE stock_quantity >= 10";
        }

        $sql = "SELECT id, name, price, stock_quantity, image, 
                       CASE 
                           WHEN stock_quantity <= 0 THEN 'out_of_stock'
                           WHEN stock_quantity < 10 THEN 'low_stock'
                           ELSE 'in_stock'
                       END AS status_code
                FROM products 
                $whereClause
                ORDER BY id ASC";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Lấy lịch sử các lần nhập hàng
    public function getImportHistory() {
        $sql = "SELECT r.*, p.name AS product_name, p.image AS product_image
                FROM inventory_receipts r
                JOIN products p ON r.product_id = p.id
                ORDER BY r.created_at DESC";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Thực hiện nhập hàng: Cập nhật tồn kho và lưu lịch sử bằng Transaction
    public function importStock($product_id, $quantity, $import_price, $supplier, $note, $created_by = 1) {
        try {
            $this->conn->beginTransaction();

            // Lưu phiếu nhập
            $sqlReceipt = "INSERT INTO inventory_receipts (product_id, quantity, import_price, supplier, note, created_by)
                           VALUES (:product_id, :quantity, :import_price, :supplier, :note, :created_by)";
            $stmtReceipt = $this->conn->prepare($sqlReceipt);
            $stmtReceipt->execute([
                'product_id'   => $product_id,
                'quantity'     => $quantity,
                'import_price' => $import_price,
                'supplier'     => $supplier,
                'note'         => $note,
                'created_by'   => $created_by
            ]);

            // Cộng thêm số lượng tồn kho
            $sqlUpdate = "UPDATE products SET stock_quantity = stock_quantity + :quantity WHERE id = :product_id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                'quantity'   => $quantity,
                'product_id' => $product_id
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>