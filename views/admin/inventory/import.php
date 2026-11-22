<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title text-white">Tạo phiếu nhập hàng mới</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=adminInventory&action=store" method="POST">
                        <div class="mb-3">
                            <label class="form-label required">Chọn sản phẩm cần nhập hàng:</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                <?php foreach ($products as $p): ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo ($selected_id == $p['id']) ? 'selected' : ''; ?>>
                                        #<?php echo $p['id']; ?> - <?php echo htmlspecialchars($p['name']); ?> (Hiện còn: <?php echo $p['stock_quantity'] ?? 0; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Số lượng nhập thêm:</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="20" required placeholder="VD: 50">
                                <small class="text-muted">Hệ thống sẽ cộng dồn số lượng này vào tồn kho hiện tại.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá nhập đơn vị (đ):</label>
                                <input type="number" name="import_price" class="form-control" min="0" value="0" placeholder="VD: 15000">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nhà cung cấp:</label>
                            <input type="text" name="supplier" class="form-control" value="Công ty TNHH Sản phẩm Xanh Việt Nam" placeholder="Tên nhà cung cấp">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi chú phiếu nhập:</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Nhập đợt hàng tháng 11, kiểm đếm đủ số lượng..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=adminInventory&action=index" class="btn btn-secondary">
                                &larr; Quay lại danh sách kho
                            </a>
                            <button type="submit" class="btn btn-success">
                                Xác nhận nhập kho & Cập nhật tồn kho
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>
