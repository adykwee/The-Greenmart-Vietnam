<?php
require_once './models/ProductModel.php';
require_once './models/NewsModel.php';
class HomeController extends BaseController {
    public function index() {
        $this->productModel = new ProductModel();
        $this->newsModel = new NewsModel();
        $products = $this->productModel->getAllProducts();
        $newsList = $this->newsModel->getAllNews();
    
        // Truyền cả 2 biến vào View
        $this->view('client/home', [
            'products' => $products, 
            'newsList' => $newsList
        ]);
}
}
?>