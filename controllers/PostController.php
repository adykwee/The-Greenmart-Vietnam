<?php
require_once './models/NewsModel.php';

class PostController extends BaseController {
    private $newsModel;

    public function __construct() {
        $this->newsModel = new NewsModel();
    }

    // 1. Danh sách tin tức
    public function index() {
        // Lấy trang hiện tại, mặc định là 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Lấy dữ liệu phân trang (5 bài mỗi trang)
        $pagingData = $this->newsModel->getNewsPaging($page, 5);
        
        // Truyền dữ liệu sang View
        $this->view('client/news/index', [
            'newsList' => $pagingData['data'],
            'totalPages' => $pagingData['total_pages'],
            'currentPage' => $pagingData['current_page']
        ]);
    }

    // 2. Chi tiết tin tức + Bình luận
    public function detail() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id) {
            $post = $this->newsModel->getNewsById($id);
            // Lấy danh sách bình luận của bài này
            $comments = $this->newsModel->getCommentsByNewsId($id);
            
            $this->view('client/news/detail', [
                'post' => $post,
                'comments' => $comments
            ]);
        } else {
            echo "Bài viết không tồn tại";
        }
    }

    // 3. Xử lý gửi bình luận
    public function comment() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            echo "<script>alert('Vui lòng đăng nhập để bình luận!'); history.back();</script>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = trim($_POST['content']);
            $news_id = $_POST['news_id'];
            $user_id = $_SESSION['user']['id'];

            if (!empty($content)) {
                $this->newsModel->addComment($user_id, $news_id, $content);
            }
            
            // Quay lại trang chi tiết bài viết
            header("Location: index.php?controller=post&action=detail&id=$news_id");
        }
    }
}
?>