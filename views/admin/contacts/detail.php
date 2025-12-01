<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Chi tiết liên hệ #<?php echo $contact['id']; ?></h2>
            </div>
            <div class="col-auto ms-auto">
                <a href="index.php?controller=adminContact&action=index" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nội dung tin nhắn</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Người gửi:</label>
                        <div class="form-control-plaintext fw-bold"><?php echo htmlspecialchars($contact['name']); ?></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Email:</label>
                        <div class="form-control-plaintext text-primary">
                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>">
                                <?php echo htmlspecialchars($contact['email']); ?>
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Thời gian:</label>
                        <div class="form-control-plaintext"><?php echo $contact['created_at']; ?></div>
                    </div>

                    <div class="hr-text">Nội dung</div>
                    
                    <div class="p-3 bg-light border rounded text-break">
                        <?php echo nl2br(htmlspecialchars($contact['message'])); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hành động</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=adminContact&action=updateStatus" method="POST">
                        <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Trạng thái hiện tại</label>
                            <select name="status" class="form-select">
                                <option value="read" <?php echo ($contact['status'] == 'read') ? 'selected' : ''; ?>>Đã xem</option>
                                <option value="replied" <?php echo ($contact['status'] == 'replied') ? 'selected' : ''; ?>>Đã phản hồi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                    </form>
                    
                    <hr>
                    
                    <div class="text-muted small">
                        * Lưu ý: Hệ thống chỉ ghi nhận trạng thái. Việc trả lời email phải được thực hiện qua Gmail/Outlook của bạn.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>