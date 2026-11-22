<?php
/**
 * ============================================================================
 * S05: CONCURRENCY CONTROL (ĐIỀU KHIỂN ĐỒNG THỜI)
 * HỆ QUẢN TRỊ CSDL: Neo4j 5.x (Đồ thị - NoSQL)
 * BÀI THỬ NGHIỆM 04: KHÓA ĐỈNH ĐỘC QUYỀN (NODE-LEVEL LOCK - CHUẨN ACID)
 * 
 * [LỆNH CHẠY TERMINAL]:
 * Từ thư mục The-Greenmart-Vietnam:
 *   C:\xampp\php\php.exe concurrency_tests/04_neo4j_node_lock.php
 * 
 * [KẾT QUẢ MONG ĐỢI]:
 * Đúng 10 người mua được, 10 người bị chặn an toàn, tồn kho về chuẩn 0.
 * ============================================================================
 */

function executeCypher($statement, $parameters = []) {
    $url = "http://127.0.0.1:7474/db/neo4j/tx/commit";
    $auth = base64_encode("neo4j:dung2075");
    $payload = json_encode([
        'statements' => [
            [
                'statement' => $statement,
                'parameters' => (object)$parameters
            ]
        ]
    ]);

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n" .
                         "Authorization: Basic $auth\r\n" .
                         "Accept: application/json\r\n",
            'content' => $payload,
            'timeout' => 10,
            'ignore_errors' => true
        ]
    ];
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        return ['errors' => [['message' => 'Lỗi kết nối Neo4j']]];
    }
    return json_decode($result, true);
}

// --- CHẾ ĐỘ TIẾN TRÌNH CON (WORKER) ---
if (isset($argv[1]) && $argv[1] === '--worker') {
    $workerId = $argv[2];

    // Truy vấn có khóa: SET p._lock = true khóa Node p ngay lập tức
    $cypherBuy = "
        MATCH (p:Product {name: 'Flash Sale Test Concurrency'})
        SET p._lock = true
        WITH p
        WHERE p.stock_quantity > 0
        SET p.stock_quantity = p.stock_quantity - 1
        CREATE (o:Order {client_id: $workerId, note: 'Test Ca 2 Neo4j', created_at: datetime()})
        RETURN p.stock_quantity AS remaining
    ";

    $res = executeCypher($cypherBuy);
    $data = $res['results'][0]['data'] ?? [];
    if (!empty($data)) {
        echo "OK\n";
    } else {
        echo "BLOCKED\n";
    }
    exit(0);
}

// --- CHẾ ĐỘ ĐIỀU PHỐI (RUNNER) ---
echo "============================================================\n";
echo " NEO4J - CA 2: CÓ KHÓA ĐỈNH (NODE-LEVEL LOCK - CHUẨN ACID)\n";
echo "============================================================\n";

// 1. Reset dữ liệu ban đầu trên Neo4j
executeCypher("MATCH (o:Order {note: 'Test Ca 2 Neo4j'}) DETACH DELETE o");
$resSetup = executeCypher("
    MERGE (p:Product {name: 'Flash Sale Test Concurrency'})
    SET p.stock_quantity = 10, p.price = 10000
    RETURN p.stock_quantity AS stock
");

if (empty($resSetup['results'])) {
    die("Lỗi: Không thể kết nối tới Neo4j (http://127.0.0.1:7474)!\n");
}

$initialStock = 10;
$totalClients = 20;

echo "• Tồn kho ban đầu : $initialStock sản phẩm (Node :Product)\n";
echo "• Yêu cầu gửi     : $totalClients khách hàng mua cùng lúc\n";
echo "• Cơ chế khóa     : Node-level Write Lock (Khóa độc quyền trên Đỉnh)\n";
echo "• Trạng thái      : Đang xử lý 20 giao dịch có khóa...\n";

$phpBinary = PHP_BINARY;
$scriptPath = __FILE__;
$processes = [];
$pipes = [];

$startTime = microtime(true);

for ($i = 1; $i <= $totalClients; $i++) {
    $cmd = "\"$phpBinary\" \"$scriptPath\" --worker $i";
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

// Kiểm tra kết quả thực tế trên Neo4j
$resStock = executeCypher("MATCH (p:Product {name: 'Flash Sale Test Concurrency'}) RETURN p.stock_quantity AS stock");
$finalStock = $resStock['results'][0]['data'][0]['row'][0] ?? 0;

$resOrders = executeCypher("MATCH (o:Order {note: 'Test Ca 2 Neo4j'}) RETURN count(o) AS total");
$ordersCreated = $resOrders['results'][0]['data'][0]['row'][0] ?? 0;

echo "\n------------------- KẾT QUẢ ĐO LƯỜNG -------------------\n";
echo "• Số đơn mua thành công : $ordersCreated đơn (Node :Order)\n";
echo "• Số đơn bị chặn hợp lệ : $blockedCount đơn (hết hàng)\n";
echo "• Tồn kho thực tế còn   : $finalStock sản phẩm\n";
echo "• Thời gian xử lý       : {$executionTime} ms\n";
echo "------------------------ ĐÁNH GIÁ ----------------------\n";

if ($finalStock == 0 && $ordersCreated == $initialStock) {
    echo "   THÀNH CÔNG: NEO4J BẢO ĐẢM TÍNH TOÀN VẸN DỮ LIỆU!\n";
    echo "   Đúng $initialStock người mua được, $blockedCount người bị chặn an toàn.\n";
    echo "   Tồn kho về đúng 0, ngăn chặn triệt để bán âm kho.\n";
    echo "   Cơ chế: Node-level Write Lock đã tuần tự hóa việc cập nhật\n";
    echo "   trên Đỉnh sản phẩm, bảo đảm tính Cô lập (Isolation).\n";
} else {
    echo "   Kết quả: Tồn kho = $finalStock, Đơn = $ordersCreated\n";
}

echo "============================================================\n";
