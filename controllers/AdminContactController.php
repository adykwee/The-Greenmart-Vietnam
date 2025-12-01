<?php
class AdminContactController extends BaseController {
    private $model;

    public function __construct() {
        // Chỉ Admin mới được vào
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    // 1. Xem danh sách liên hệ (Mới nhất lên đầu)
    public function index() {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        $contacts = $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        $this->view('admin/contacts/index', ['contacts' => $contacts]);
    }

    // 2. Xem chi tiết nội dung liên hệ
    public function detail() {
        $id = $_GET['id'];
        $contact = $this->model->find('contacts', $id);
        
        // Nếu đang là trạng thái 'new' thì tự động chuyển sang 'read' (đã xem)
        if ($contact['status'] == 'new') {
            $this->model->query("UPDATE contacts SET status = 'read' WHERE id = :id", ['id' => $id]);
            $contact['status'] = 'read'; // Cập nhật lại biến để hiển thị
        }

        $this->view('admin/contacts/detail', ['contact' => $contact]);
    }

    // 3. Cập nhật trạng thái (Ví dụ: Đánh dấu đã trả lời)
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            
            $sql = "UPDATE contacts SET status = :status WHERE id = :id";
            $this->model->query($sql, ['status' => $status, 'id' => $id]);
            
            echo "<script>alert('Cập nhật trạng thái thành công!'); window.location.href='index.php?controller=adminContact&action=detail&id=$id';</script>";
        }
    }

    // 4. Xóa liên hệ
    public function delete() {
        $id = $_GET['id'];
        $this->model->delete('contacts', $id);
        header("Location: index.php?controller=adminContact&action=index");
    }
}
?>