<?php
class ContactController extends BaseController {
    public function index() {
        // Xử lý khi người dùng bấm nút Gửi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            
            // Lưu vào DB (Giả sử bạn đã có Model hoặc dùng BaseModel)
            $model = new BaseModel();
            $model->create('contacts', [
                'name' => $name, 
                'email' => $email, 
                'message' => $message,
                'status' => 'new' // Trạng thái chưa đọc
            ]);
            
            echo "<script>alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.'); window.location.href='index.php?controller=contact';</script>";
        }
        
        // Hiển thị view
        $this->view('client/contact', ['title' => 'Liên hệ với chúng tôi']);
    }
}
?>