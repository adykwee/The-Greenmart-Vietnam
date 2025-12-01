<?php
class BaseModel {
    protected $conn; // Biến kết nối CSDL

    public function __construct() {
        // Tự động kết nối DB khi khởi tạo Model
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. Lấy tất cả dữ liệu từ bảng
    public function all($table) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng kết hợp
    }

    // 2. Lấy 1 dòng dữ liệu theo ID
    public function find($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm mới dữ liệu (Dynamic Insert)
    // $data là mảng: ['name' => 'iPhone', 'price' => 1000]
    public function create($table, $data) {
        $keys = array_keys($data);
        $fields = implode(", ", $keys); // name, price
        $placeholders = ":" . implode(", :", $keys); // :name, :price

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        
        // Tự động bind dữ liệu và execute
        return $stmt->execute($data);
    }

    // 4. Cập nhật dữ liệu
    public function update($table, $id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", "); // Xóa dấu phẩy thừa ở cuối

        $sql = "UPDATE $table SET $fields WHERE id = :id";
        
        // Thêm ID vào mảng data để bind param
        $data['id'] = $id;
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // 5. Xóa dữ liệu
    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    // 6. Hàm chạy câu SQL tự do (Dành cho các câu query phức tạp)
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Hàm lấy dữ liệu có phân trang
    // $page: Trang hiện tại (1, 2, 3...)
    // $limit: Số lượng record mỗi trang
    public function paginate($table, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        // 1. Lấy dữ liệu
        $sql = "SELECT * FROM $table LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Tính tổng số trang
        $sqlCount = "SELECT COUNT(*) as total FROM $table";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute();
        $totalRecord = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalRecord / $limit);

        return [
            'data' => $data,
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }
}
?>