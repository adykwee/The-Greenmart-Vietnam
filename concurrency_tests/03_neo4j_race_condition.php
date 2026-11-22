<?php
/**
 * ============================================================================
 * S05: CONCURRENCY CONTROL (ĐIỀU KHIỂN ĐỒNG THỜI)
 * HỆ QUẢN TRỊ CSDL: Neo4j 5.x (Đồ thị - NoSQL)
 * BÀI THỬ NGHIỆM 03: TRANH CHẤP TÀI NGUYÊN TRÊN ĐỒ THỊ (RACE CONDITION)
 * 
 * [LỆNH CHẠY TERMINAL]:
 * Từ thư mục The-Greenmart-Vietnam:
 *   C:\xampp\php\php.exe concurrency_tests/03_neo4j_race_condition.php
 * 
 * [KẾT QUẢ MONG ĐỢI]:
 * Tồn kho ban đầu = 10, 20 khách mua đồng thời -> Bán được 20 đơn, kho bị ÂM (-10).
 * ============================================================================
 */

function executeCypher($statement, $parameters = []) {
    // Tự động đọc cấu hình từ .env nếu có
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                putenv(trim($parts[0]) . "=" . trim($parts[1]));
            }
        }
    }

    $neoHost = getenv('NEO4J_HOST') ?: '127.0.0.1';
    $neoPort = getenv('NEO4J_PORT') ?: '7474';
    $neoUser = getenv('NEO4J_USER') ?: 'neo4j';
    $neoPass = (getenv('NEO4J_PASS') !== false) ? getenv('NEO4J_PASS') : 'password123';

    $url = "http://$neoHost:$neoPort/db/neo4j/tx/commit";
    $auth = base64_encode("$neoUser:$neoPass");
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

    // Truy vấn không khóa trước khi đọc (Race Condition)
    $cypherBuy = "
        MATCH (p:Product {name: 'Flash Sale Test Concurrency'})
        WHERE p.stock_quantity > 0
        SET p.stock_quantity = p.stock_quantity - 1
        CREATE (o:Order {client_id: $workerId, note: 'Test Ca 1 Neo4j', created_at: datetime()})
        RETURN p.stock_quantity AS remaining
    ";

    $res = executeCypher($cypherBuy);
    $data = $res['results'][0]['data'] ?? [];
    if (!empty($data)) {
        echo "OK\n";
    } else {
        echo "FAIL\n";
    }
    exit(0);
}

// --- CHẾ ĐỘ ĐIỀU PHỐI (RUNNER) ---
echo "============================================================\n";
echo " NEO4J - CA 1: GIAO DỊCH KHÔNG KHÓA (RACE CONDITION)\n";
echo "============================================================\n";

// 1. Reset dữ liệu ban đầu trên Neo4j
executeCypher("MATCH (o:Order {note: 'Test Ca 1 Neo4j'}) DETACH DELETE o");
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
echo "• Trạng thái      : Đang xử lý 20 giao dịch không khóa...\n";

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
$failCount = 0;

for ($i = 1; $i <= $totalClients; $i++) {
    if (is_resource($processes[$i])) {
        $stdout = trim(stream_get_contents($pipes[$i][1]));
        fclose($pipes[$i][0]);
        fclose($pipes[$i][1]);
        fclose($pipes[$i][2]);
        proc_close($processes[$i]);

        if ($stdout === "OK") $successCount++;
        else $failCount++;
    }
}

$executionTime = round((microtime(true) - $startTime) * 1000, 2);

// Kiểm tra kết quả thực tế trên Neo4j
$resStock = executeCypher("MATCH (p:Product {name: 'Flash Sale Test Concurrency'}) RETURN p.stock_quantity AS stock");
$finalStock = $resStock['results'][0]['data'][0]['row'][0] ?? 0;

$resOrders = executeCypher("MATCH (o:Order {note: 'Test Ca 1 Neo4j'}) RETURN count(o) AS total");
$ordersCreated = $resOrders['results'][0]['data'][0]['row'][0] ?? 0;

echo "\n------------------- KẾT QUẢ ĐO LƯỜNG -------------------\n";
echo "• Số đơn mua thành công : $ordersCreated đơn\n";
echo "• Số đơn thất bại       : $failCount đơn\n";
echo "• Tồn kho thực tế còn   : $finalStock sản phẩm\n";
echo "• Thời gian xử lý       : {$executionTime} ms\n";
echo "------------------------ ĐÁNH GIÁ ----------------------\n";

if ($finalStock < 0) {
    echo "   PHÁT HIỆN LỖI: BÁN ÂM KHO (Overselling) TRÊN NEO4J!\n";
    echo "   Tồn kho chỉ có $initialStock nhưng bán được tận $ordersCreated đơn.\n";
    echo "   Nguyên nhân: Mức cô lập mặc định Read Committed không khóa Node\n";
    echo "   khi đọc, dẫn đến việc 20 luồng cùng thấy kho > 0 và cùng trừ tồn kho.\n";
} else {
    echo "   Không phát hiện bán âm kho.\n";
}

echo "============================================================\n";
