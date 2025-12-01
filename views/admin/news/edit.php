<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Chỉnh sửa bài viết</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form action="index.php?controller=adminPost&action=update" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài viết</label>
                    <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ảnh bìa hiện tại</label>
                    <div class="mb-2">
                        <?php if($post['image']): ?>
                            <img src="./assets/uploads/<?php echo $post['image']; ?>" width="150" class="rounded border">
                        <?php endif; ?>
                    </div>
                    <label class="form-label">Thay ảnh mới</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($post['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung chi tiết (HTML)</label>
                    <textarea name="content" class="form-control" rows="15"><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                    <a href="index.php?controller=adminPost&action=index" class="btn btn-link">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>