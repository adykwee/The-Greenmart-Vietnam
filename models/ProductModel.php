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

    public function searchProducts($keyword, $minPrice, $maxPrice, $page) {
        $conditions = [];
        $params = [];
        if ($keyword !== '') {
            $conditions[] = "name LIKE :keyword ESCAPE '!'";
            $params['keyword'] = '%' . strtr($keyword, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
        }
        if ($minPrice !== null) {
            $conditions[] = 'price >= :min_price';
            $params['min_price'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $conditions[] = 'price <= :max_price';
            $params['max_price'] = $maxPrice;
        }

        $where = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';
        $limit = 8;
        $total = (int) $this->query("SELECT COUNT(*) FROM products$where", $params)->fetchColumn();
        $totalPages = (int) ceil($total / $limit);
        $currentPage = min($page, max(1, $totalPages));
        $offset = ($currentPage - 1) * $limit;
        $products = $this->query(
            "SELECT * FROM products$where ORDER BY id LIMIT $limit OFFSET $offset",
            $params
        )->fetchAll(PDO::FETCH_ASSOC);

        return ['data' => $products, 'total_pages' => $totalPages, 'current_page' => $currentPage];
    }
}
?>
