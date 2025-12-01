<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Thêm sản phẩm mới</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form action="index.php?controller=product&action=store" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" class="form-control" name="price" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" class="form-control" name="image" required>
                    <small class="form-hint">Chỉ chấp nhận file .jpg, .png</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả chi tiết</label>
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                    <a href="index.php?controller=product&action=index" class="btn btn-link">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>