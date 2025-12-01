<?php include './views/layouts/header_admin.php'; ?>
<div class="container-xl">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Thêm câu hỏi mới</h3></div>
        <div class="card-body">
            <form action="index.php?controller=adminFAQ&action=store" method="POST">
                <div class="mb-3">
                    <label class="form-label">Câu hỏi</label>
                    <input type="text" name="question" class="form-control" required placeholder="VD: Phí vận chuyển là bao nhiêu?">
                </div>
                <div class="mb-3">
                    <label class="form-label">Câu trả lời</label>
                    <textarea name="answer" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="order_number" class="form-control" value="0">
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
</div>
<?php include './views/layouts/footer_admin.php'; ?>