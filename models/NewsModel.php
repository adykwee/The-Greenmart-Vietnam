<?php
require_once 'BaseModel.php';

class NewsModel extends BaseModel {
    private $table = 'news';
    private $table_comments = 'comments';

    // Lấy tất cả tin tức (Sắp xếp mới nhất trước)
    public function getAllNews() {
        $sql = "SELECT * FROM $this->table ORDER BY created_at DESC";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 bài viết
    public function getNewsById($id) {
        return $this->find($this->table, $id);
    }

    // --- PHẦN BÌNH LUẬN ---

    // Lấy bình luận của một bài viết (Kèm tên người bình luận)
    public function getCommentsByNewsId($news_id) {
        // JOIN bảng comments với bảng users để lấy tên người đăng
        $sql = "SELECT c.*, u.full_name, u.avatar 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.news_id = :news_id AND c.status = 'visible' 
                ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['news_id' => $news_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm bình luận mới
    public function addComment($user_id, $news_id, $content) {
        $data = [
            'user_id' => $user_id,
            'news_id' => $news_id,
            'content' => $content,
            'status' => 'visible'
        ];
        return $this->create($this->table_comments, $data);
    }

    // --- CÁC HÀM MỚI CHO ADMIN ---

    // 1. Thêm tin tức
    public function addNews($title, $desc, $content, $image) {
        $data = [
            'title' => $title,
            'description' => $desc,
            'content' => $content,
            'image' => $image
        ];
        return $this->create($this->table, $data);
    }

    // 2. Cập nhật tin tức
    public function updateNews($id, $title, $desc, $content, $image) {
        $data = [
            'title' => $title,
            'description' => $desc,
            'content' => $content,
            'image' => $image
        ];
        return $this->update($this->table, $id, $data);
    }

    // 3. Xóa tin tức
    public function deleteNews($id) {
        return $this->delete($this->table, $id);
    }

    // 4. Lấy TẤT CẢ bình luận (kèm tên bài viết và tên người dùng)
    public function getAllCommentsForAdmin() {
        $sql = "SELECT c.*, u.full_name, n.title as news_title 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                JOIN news n ON c.news_id = n.id
                ORDER BY c.created_at DESC";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Cập nhật trạng thái bình luận (Ẩn/Hiện)
    public function updateCommentStatus($id, $status) {
        $sql = "UPDATE comments SET status = :status WHERE id = :id";
        return $this->query($sql, ['status' => $status, 'id' => $id]);
    }

    // 6. Xóa bình luận
    public function deleteComment($id) {
        return $this->delete($this->table_comments, $id);
    }

    // Thêm vào trong class NewsModel
    public function getNewsPaging($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        
        // 1. Lấy dữ liệu tin tức (Sắp xếp mới nhất trước)
        $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Tính tổng số trang
        $sqlCount = "SELECT COUNT(*) as total FROM news";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute();
        $totalRecord = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalRecord / $limit);

        return [
            'data' => $data,
            'total_pages' => $totalPages,
            'current_page' => $page
        ];
    }
}
?>