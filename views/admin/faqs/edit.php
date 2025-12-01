<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Cập nhật câu hỏi</h3></div>
        <div class="card-body">
            
            <form action="index.php?controller=adminFAQ&action=update" method="POST">

                <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Câu hỏi</label>
                    <input type="text" name="question" class="form-control" required 
                           value="<?php echo htmlspecialchars($faq['question']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Câu trả lời</label>
                    <textarea name="answer" class="form-control" rows="5" required><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="order_number" class="form-control" 
                           value="<?php echo $faq['order_number']; ?>">
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="index.php?controller=adminFAQ&action=index" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>