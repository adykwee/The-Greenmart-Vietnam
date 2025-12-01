<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Hộp thư liên hệ</h2>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Nội dung tóm tắt</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($contacts)): ?>
                        <tr><td colspan="6" class="text-center">Hộp thư trống</td></tr>
                    <?php else: ?>
                        <?php foreach ($contacts as $c): ?>
                        <tr class="<?php echo ($c['status'] == 'new') ? 'bg-indigo-lt' : ''; ?>">
                            <td>#<?php echo $c['id']; ?></td>
                            <td>
                                <div class="font-weight-medium"><?php echo htmlspecialchars($c['name']); ?></div>
                                <div class="text-muted small"><?php echo htmlspecialchars($c['email']); ?></div>
                            </td>
                            <td class="text-muted">
                                <?php echo substr(htmlspecialchars($c['message']), 0, 50); ?>...
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?></td>
                            <td>
                                <?php 
                                    $statusMap = [
                                        'new' => ['Mới', 'success'],
                                        'read' => ['Đã xem', 'secondary'],
                                        'replied' => ['Đã trả lời', 'primary']
                                    ];
                                    $stt = $statusMap[$c['status']];
                                ?>
                                <span class="badge bg-<?php echo $stt[1]; ?>"><?php echo $stt[0]; ?></span>
                            </td>
                            <td>
                                <a href="index.php?controller=adminContact&action=detail&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary">Xem chi tiết</a>
                                <a href="index.php?controller=adminContact&action=delete&id=<?php echo $c['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Xóa tin nhắn này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>