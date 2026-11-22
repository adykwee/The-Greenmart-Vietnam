<?php
/**
 * ============================================================================
 * S05: CONCURRENCY CONTROL (ĐIỀU KHIỂN ĐỒNG THỜI)
 * HỆ QUẢN TRỊ CSDL: MySQL 8.x (Quan hệ - SQL)
 * BÀI THỬ NGHIỆM 02: KHÓA BI QUAN MỨC DÒNG (SELECT ... FOR UPDATE - CHUẨN ACID)
 * 
 * [LỆNH CHẠY TERMINAL]:
 * Từ thư mục The-Greenmart-Vietnam:
 *   C:\xampp\php\php.exe concurrency_tests/02_mysql_pessimistic_lock.php
 * 
 * [KẾT QUẢ MONG ĐỢI]:
 * Đúng 10 người mua được, 10 người bị chặn an toàn, tồn kho về chuẩn 0.
 * ============================================================================
 */

require_once __DIR__ . '/../config/database.php';

// --- CHẾ ĐỘ TIẾN TRÌNH CON (WORKER) ---
if (isset($argv[1]) && $argv[1] === '--worker') {
    $workerId = $argv[2];
    $productId = intval($argv[3]);

    $db = new Database();
    $conn = $db->getConnection();
    if (!$conn) exit(1);

    try {
        $conn->beginTransaction();

        // KHÓA ĐỘC QUYỀN MỨC DÒNG (ROW-LEVEL EXCLUSIVE LOCK)
        $stmt = $conn->query("SELECT stock_quantity FROM products WHERE id = $productId FOR UPDATE");
        $currentStock = $stmt->fetch(PDO::FETCH_ASSOC)['stock_quantity'] ?? 0;

        usleep(20000); 

        if ($currentStock > 0) {
            $conn->exec("UPDATE products SET stock_quantity = stock_quantity - 1 WHERE id = $productId");
            $conn->exec("INSERT INTO orders (user_id, total_money, note, status) VALUES (1, 10000, 'Test Pessimistic Lock', 'completed')");
            $conn->commit();
            echo "OK\n";
        } else {
            $conn->rollBack();
            echo "BLOCKED\n";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo "BLOCKED\n";
    }
    exit(0);
}

// --- CHẾ ĐỘ ĐIỀU PHỐI (RUNNER) ---
$db = new Database();
$conn = $db->getConnection();
if (!$conn) die("Lỗi: Không thể kết nối MySQL!\n");

// Chuẩn bị sản phẩm test
$stmt = $conn->prepare("SELECT id FROM products WHERE name = 'Flash Sale Test Concurrency' LIMIT 1");
$stmt->execute();
$prod = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$prod) {
    $conn->exec("INSERT INTO products (name, price, stock_quantity, description) VALUES ('Flash Sale Test Concurrency', 10000, 10, 'Test')");
    $productId = $conn->lastInsertId();
} else {
    $productId = $prod['id'];
}

$initialStock = 10;
$conn->exec("UPDATE products SET stock_quantity = $initialStock WHERE id = $productId");
$conn->exec("DELETE FROM orders WHERE note = 'Test Pessimistic Lock'");

$totalClients = 20;
$phpBinary = PHP_BINARY;
$scriptPath = __FILE__;
$processes = [];
$pipes = [];

echo "============================================================\n";
echo " MYSQL - CA 2: CÓ KHÓA DÒNG (SELECT ... FOR UPDATE - ACID)\n";
echo "============================================================\n";
echo "• Tồn kho ban đầu : $initialStock sản phẩm\n";
echo "• Yêu cầu gửi     : $totalClients khách hàng mua cùng lúc\n";
echo "• Trạng thái      : Đang xử lý 20 giao dịch có khóa độc quyền...\n";

$startTime = microtime(true);

for ($i = 1; $i <= $totalClients; $i++) {
    $cmd = "\"$phpBinary\" \"$scriptPath\" --worker $i $productId";
    $descriptors = [0 => ["pipe", "r"], 1 => ["pipe", "w"], 2 => ["pipe", "w"]];
    $processes[$i] = proc_open($cmd, $descriptors, $pipes[$i]);
}

$successCount = 0;
$blockedCount = 0;

for ($i = 1; $i <= $totalClients; $i++) {
    if (is_resource($processes[$i])) {
        $stdout = trim(stream_get_contents($pipes[$i][1]));
        fclose($pipes[$i][0]);
        fclose($pipes[$i][1]);
        fclose($pipes[$i][2]);
        proc_close($processes[$i]);

        if ($stdout === "OK") $successCount++;
        else $blockedCount++;
    }
}

$executionTime = round((microtime(true) - $startTime) * 1000, 2);

$stmt = $conn->query("SELECT stock_quantity FROM products WHERE id = $productId");
$finalStock = $stmt->fetchColumn();

$stmtOrders = $conn->query("SELECT count(*) FROM orders WHERE note = 'Test Pessimistic Lock'");
$ordersCreated = $stmtOrders->fetchColumn();

echo "\n------------------- KẾT QUẢ ĐO LƯỜNG -------------------\n";
echo "• Số đơn mua thành công : $ordersCreated đơn\n";
echo "• Số đơn bị chặn hợp lệ : $blockedCount đơn (hết hàng)\n";
echo "• Tồn kho thực tế còn   : $finalStock sản phẩm\n";
echo "• Thời gian xử lý       : {$executionTime} ms\n";
echo "------------------------ ĐÁNH GIÁ ----------------------\n";

if ($finalStock == 0 && $ordersCreated == $initialStock) {
    echo "   THÀNH CÔNG: BẢO ĐẢM TOÀN VẸN DỮ LIỆU ACID!\n";
    echo "   Đúng $initialStock người mua được, $blockedCount người bị chặn an toàn.\n";
    echo "   Tồn kho về đúng 0, ngăn chặn triệt để bán âm kho.\n";
    echo "   Cơ chế: SELECT ... FOR UPDATE khóa hàng độc quyền, buộc các\n";
    echo "   giao dịch sau phải chờ giao dịch trước commit.\n";
} else {
    echo "   Kết quả: Tồn kho = $finalStock, Đơn = $ordersCreated.\n";
}

echo "============================================================\n";
