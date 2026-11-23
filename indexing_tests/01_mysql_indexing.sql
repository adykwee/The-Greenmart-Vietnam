-- N2 | Demo Indexing trên MySQL. Chạy từng khối từ 1 đến 4.
-- Schema và bảng bên dưới dành riêng cho demo.

-- 1. Chuẩn bị 10.000 sản phẩm. Bảng mới chỉ có khóa chính id.
CREATE DATABASE IF NOT EXISTS greenmart_n2_index_demo;
USE greenmart_n2_index_demo;

-- Bảng này chỉ chứa dữ liệu giả lập. Xóa bảng demo cũ để chạy lại từ đầu.
DROP TABLE IF EXISTS n2_demo_products;
CREATE TABLE n2_demo_products (
    id INT NOT NULL PRIMARY KEY,
    price INT NOT NULL
) ENGINE = InnoDB;

INSERT INTO n2_demo_products (id, price)
WITH digits AS (
    SELECT 0 AS digit UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
    UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
),
product_ids AS (
    SELECT 1 + a.digit + 10 * b.digit + 100 * c.digit + 1000 * d.digit AS id
    FROM digits a CROSS JOIN digits b CROSS JOIN digits c CROSS JOIN digits d
)
SELECT id, 1000 + MOD(id * 7919, 10000) * 100
FROM product_ids;

SELECT COUNT(*) AS product_count FROM n2_demo_products;
SHOW INDEX FROM n2_demo_products;

-- 2. Trước chỉ mục giá. Khoảng hẹp trả 100 ID, khoảng rộng trả 5.000 ID.
EXPLAIN ANALYZE FORMAT=TREE
SELECT id FROM n2_demo_products WHERE price BETWEEN 100000 AND 109999;

EXPLAIN ANALYZE FORMAT=TREE
SELECT id FROM n2_demo_products WHERE price BETWEEN 100000 AND 599999;

-- 3. Tạo chỉ mục, rồi chạy lại đúng hai truy vấn.
CREATE INDEX n2_demo_price_idx ON n2_demo_products (price);
ANALYZE TABLE n2_demo_products;

EXPLAIN ANALYZE FORMAT=TREE
SELECT id FROM n2_demo_products WHERE price BETWEEN 100000 AND 109999;

EXPLAIN ANALYZE FORMAT=TREE
SELECT id FROM n2_demo_products WHERE price BETWEEN 100000 AND 599999;

-- 4. Đối chiếu tập ID với khối 4 trong Neo4j.
SELECT id FROM n2_demo_products WHERE price BETWEEN 100000 AND 109999 ORDER BY id;

-- Tùy chọn dọn sau demo. Chỉ bỏ comment nếu muốn xóa bảng demo.
-- DROP TABLE IF EXISTS greenmart_n2_index_demo.n2_demo_products;
