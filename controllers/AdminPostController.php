<?php
require_once './models/NewsModel.php';

class AdminPostController extends BaseController {
    private $newsModel;

    public function __construct() {
        // 1. QUAN TRỌNG: Chặn truy cập nếu không phải Admin
        $this->checkAdmin();
        
        $this->newsModel = new NewsModel();
    }

    // --- PHẦN 1: QUẢN LÝ TIN TỨC ---

    // URL: index.php?controller=adminPost&action=index
    public function index() {
        $newsList = $this->newsModel->getAllNews();
        $this->view('admin/news/index', ['newsList' => $newsList]);
    }

    public function create() {
        $this->view('admin/news/add');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $desc = $_POST['description']; // Mô tả ngắn
            $content = $_POST['content'];   // Nội dung HTML từ editor
            
            // Xử lý upload ảnh bìa
            $imageName = $this->handleUpload($_FILES['image']);

            $this->newsModel->addNews($title, $desc, $content, $imageName);
            header("Location: index.php?controller=adminPost&action=index");
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $post = $this->newsModel->getNewsById($id);
        $this->view('admin/news/edit', ['post' => $post]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $desc = $_POST['description'];
            $content = $_POST['content'];
            
            // Lấy bài cũ để giữ ảnh cũ nếu không up ảnh mới
            $oldPost = $this->newsModel->getNewsById($id);
            $imageName = $oldPost['image'];

            if (!empty($_FILES['image']['name'])) {
                $newImage = $this->handleUpload($_FILES['image']);
                if ($newImage) {
                    $imageName = $newImage;
                    // Xóa ảnh cũ
                    if ($oldPost['image'] && file_exists("./assets/uploads/" . $oldPost['image'])) {
                        unlink("./assets/uploads/" . $oldPost['image']);
                    }
                }
            }

            $this->newsModel->updateNews($id, $title, $desc, $content, $imageName);
            header("Location: index.php?controller=adminPost&action=index");
        }
    }

    public function delete() {
        $id = $_GET['id'];
        $post = $this->newsModel->getNewsById($id);
        
        if ($post['image'] && file_exists("./assets/uploads/" . $post['image'])) {
            unlink("./assets/uploads/" . $post['image']);
        }

        $this->newsModel->deleteNews($id);
        header("Location: index.php?controller=adminPost&action=index");
    }

    // --- PHẦN 2: QUẢN LÝ BÌNH LUẬN ---

    // URL: index.php?controller=adminPost&action=comments
    // Xem danh sách TẤT CẢ bình luận
    public function comments() {
        $comments = $this->newsModel->getAllCommentsForAdmin();
        $this->view('admin/comments/index', ['comments' => $comments]);
    }

    // Ẩn/Hiện bình luận (Thay vì xóa hẳn)
    public function toggleComment() {
        $id = $_GET['id'];
        $currentStatus = $_GET['status']; // 'visible' hoặc 'hidden'
        
        $newStatus = ($currentStatus == 'visible') ? 'hidden' : 'visible';
        
        $this->newsModel->updateCommentStatus($id, $newStatus);
        header("Location: index.php?controller=adminPost&action=comments");
    }

    // Xóa vĩnh viễn bình luận spam
    public function deleteComment() {
        $id = $_GET['id'];
        $this->newsModel->deleteComment($id);
        header("Location: index.php?controller=adminPost&action=comments");
    }

    // Hàm upload ảnh (Copy từ ProductController hoặc viết vào Helper chung)
    private function handleUpload($file) {
        if ($file['error'] == 0) {
            $targetDir = "assets/uploads/";
            $fileName = time() . "_news_" . basename($file["name"]);
            $targetFile = $targetDir . $fileName;
            
            // Kiểm tra đuôi file
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    return $fileName;
                }
            }
        }
        return null;
    }
}
?>