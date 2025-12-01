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
}
?>