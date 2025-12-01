<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Cập nhật sản phẩm</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form action="index.php?controller=adminProduct&action=update" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại</label>
                    <div class="mb-2">
                        <?php if($product['image']): ?>
                            <img src="./assets/uploads/<?php echo $product['image']; ?>" width="100" class="rounded border">
                        <?php else: ?>
                            <span class="text-muted">Chưa có ảnh</span>
                        <?php endif; ?>
                    </div>
                    
                    <label class="form-label">Chọn ảnh mới (Nếu muốn thay đổi)</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung chi tiết (HTML)</label>
                    <textarea class="form-control" name="content" rows="6"><?php echo htmlspecialchars($product['content']); ?></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="index.php?controller=adminProduct&action=index" class="btn btn-link">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>