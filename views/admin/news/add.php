<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Viết bài mới</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form action="index.php?controller=adminPost&action=store" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài viết</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ảnh bìa</label>
                    <input type="file" class="form-control" name="image" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả ngắn (Sapo)</label>
                    <textarea class="form-control" name="description" rows="3" placeholder="Đoạn văn hiển thị bên ngoài danh sách"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung chi tiết (HTML)</label>
                    <textarea name="content" class="form-control" rows="15" placeholder="Nhập nội dung bài viết tại đây..."></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Đăng bài</button>
                    <a href="index.php?controller=adminPost&action=index" class="btn btn-link">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>