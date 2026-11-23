// N2 | Demo Indexing trên Neo4j. Chọn database neo4j và chạy từng câu theo thứ tự.
// Nhãn N2IndexDemoProduct và hai tên schema object bên dưới dành riêng cho demo.

// 1. Bỏ chỉ mục giá từ lần demo trước, giữ hoặc tạo ràng buộc duy nhất cho id.
DROP INDEX n2_demo_price_idx IF EXISTS;

CREATE CONSTRAINT n2_index_demo_product_id IF NOT EXISTS
FOR (p:N2IndexDemoProduct) REQUIRE p.id IS UNIQUE;

UNWIND range(1, 10000) AS id
MERGE (p:N2IndexDemoProduct {id: id})
SET p.price = 1000 + ((id * 7919) % 10000) * 100;

MATCH (p:N2IndexDemoProduct) RETURN count(p) AS product_count;

// 2. Trước chỉ mục giá. Mở tab Plan ở kết quả PROFILE để xem toán tử.
PROFILE
MATCH (p:N2IndexDemoProduct)
WHERE p.price >= 100000 AND p.price <= 109999
RETURN p.id AS id;

PROFILE
MATCH (p:N2IndexDemoProduct)
WHERE p.price >= 100000 AND p.price <= 599999
RETURN p.id AS id;

// 3. Tạo chỉ mục, đợi ONLINE, rồi chạy lại đúng hai truy vấn.
CREATE RANGE INDEX n2_demo_price_idx IF NOT EXISTS
FOR (p:N2IndexDemoProduct) ON (p.price);

CALL db.awaitIndex('n2_demo_price_idx', 120);

PROFILE
MATCH (p:N2IndexDemoProduct)
WHERE p.price >= 100000 AND p.price <= 109999
RETURN p.id AS id;

PROFILE
MATCH (p:N2IndexDemoProduct)
WHERE p.price >= 100000 AND p.price <= 599999
RETURN p.id AS id;

// 4. Đối chiếu tập ID với khối 4 trong MySQL.
MATCH (p:N2IndexDemoProduct)
WHERE p.price >= 100000 AND p.price <= 109999
RETURN p.id AS id ORDER BY id;

// Tùy chọn dọn sau demo. Chỉ bỏ comment nếu muốn xóa dữ liệu demo.
// MATCH (p:N2IndexDemoProduct) DELETE p;
// DROP INDEX n2_demo_price_idx IF EXISTS;
// DROP CONSTRAINT n2_index_demo_product_id IF EXISTS;
