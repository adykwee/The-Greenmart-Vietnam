<?php
class PageController extends BaseController {
    public function about() {
        $this->view('client/about', ['title' => 'Về chúng tôi']);
    }

    // Thêm vào PageController
    public function faq() {
        $model = new BaseModel();
        // Lấy danh sách câu hỏi
        $sql = "SELECT * FROM faqs ORDER BY order_number ASC";
        $faqs = $model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        $this->view('client/faq', ['faqs' => $faqs]);
    }
}
?>