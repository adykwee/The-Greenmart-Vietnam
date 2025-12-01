<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none mb-3">
        <h2>Quản lý bình luận</h2>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Người dùng</th>
                        <th>Bài viết</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $cmt): ?>
                    <tr>
                        <td><?php echo $cmt['full_name']; ?></td>
                        
                        <td class="text-muted">
                            <?php echo substr($cmt['news_title'], 0, 30) . '...'; ?>
                        </td>
                        
                        <td><?php echo htmlspecialchars($cmt['content']); ?></td>
                        
                        <td><?php echo $cmt['created_at']; ?></td>
                        
                        <td>
                            <?php if($cmt['status'] == 'visible'): ?>
                                <span class="badge bg-success">Hiển thị</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Đã ẩn</span>
                            <?php endif; ?>
                        </td>
                        
                        <td>
                            <a href="index.php?controller=adminPost&action=toggleComment&id=<?php echo $cmt['id']; ?>&status=<?php echo $cmt['status']; ?>" 
                               class="btn btn-sm btn-outline-warning">
                               <?php echo ($cmt['status'] == 'visible') ? 'Ẩn' : 'Hiện'; ?>
                            </a>

                            <a href="index.php?controller=adminPost&action=deleteComment&id=<?php echo $cmt['id']; ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Xóa vĩnh viễn bình luận này?');">
                               Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>