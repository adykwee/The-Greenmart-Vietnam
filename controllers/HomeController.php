<?php
require_once './models/ProductModel.php';
require_once './models/NewsModel.php';
class HomeController extends BaseController {
    public function index() {
        $productModel = new ProductModel();
        $newsModel = new NewsModel();
        $products = $productModel->getAllProducts();
        $newsList = $newsModel->getAllNews();
    
        // Truyền cả 2 biến vào View
        $this->view('client/home', [
            'products' => $products, 
            'newsList' => $newsList
        ]);
}
}
?>
