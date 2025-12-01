<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="page-title">Quản lý Hỏi/Đáp (FAQ)</h2>
        <a href="index.php?controller=adminFAQ&action=create" class="btn btn-primary">+ Thêm câu hỏi</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Câu hỏi</th>
                        <th>Câu trả lời</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $f): ?>
                    <tr>
                        <td><?php echo $f['order_number']; ?></td>
                        <td><?php echo htmlspecialchars($f['question']); ?></td>
                        <td class="text-muted"><?php echo substr(htmlspecialchars($f['answer']), 0, 50); ?>...</td>
                        <td>
                            <a href="index.php?controller=adminFAQ&action=edit&id=<?php echo $f['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="index.php?controller=adminFAQ&action=delete&id=<?php echo $f['id']; ?>" 
                               class="btn btn-sm btn-danger" onclick="return confirm('Xóa câu hỏi này?');">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>