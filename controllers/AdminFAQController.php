<?php
class AdminFAQController extends BaseController {
    private $model;

    public function __construct() {
        $this->checkAdmin();
        $this->model = new BaseModel();
    }

    // Xem danh sách
    public function index() {
        // Sắp xếp theo thứ tự ưu tiên (order_number)
        $sql = "SELECT * FROM faqs ORDER BY order_number ASC";
        $faqs = $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $this->view('admin/faqs/index', ['faqs' => $faqs]);
    }

    // Hiển thị form thêm
    public function create() {
        $this->view('admin/faqs/add');
    }

    // Xử lý lưu
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'question' => $_POST['question'],
                'answer' => $_POST['answer'],
                'order_number' => $_POST['order_number'] // Số thứ tự hiển thị
            ];
            $this->model->create('faqs', $data);
            header("Location: index.php?controller=adminFAQ&action=index");
        }
    }

    // Hiển thị form sửa
    public function edit() {
        $id = $_GET['id'];
        $faq = $this->model->find('faqs', $id);
        $this->view('admin/faqs/edit', ['faq' => $faq]);
    }

    // Xử lý cập nhật
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'question' => $_POST['question'],
                'answer' => $_POST['answer'],
                'order_number' => $_POST['order_number']
            ];
            $this->model->update('faqs', $id, $data);
            header("Location: index.php?controller=adminFAQ&action=index");
        }
    }

    // Xóa
    public function delete() {
        $id = $_GET['id'];
        $this->model->delete('faqs', $id);
        header("Location: index.php?controller=adminFAQ&action=index");
    }
}
?>