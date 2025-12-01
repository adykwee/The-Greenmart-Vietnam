<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="page-title">Quản lý Tin tức</h2>
        <a href="index.php?controller=adminPost&action=create" class="btn btn-primary">
            + Viết bài mới
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($newsList)): ?>
                        <tr><td colspan="5" class="text-center">Chưa có bài viết nào</td></tr>
                    <?php else: ?>
                        <?php foreach ($newsList as $post): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td>
                                <?php if($post['image']): ?>
                                    <img src="./assets/uploads/<?php echo $post['image']; ?>" class="rounded" width="60" height="40" style="object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">No Img</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="font-weight-medium"><?php echo $post['title']; ?></div>
                                <div class="text-muted small"><?php echo substr(strip_tags($post['description']), 0, 50); ?>...</div>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></td>
                            <td>
                                <a href="index.php?controller=adminPost&action=edit&id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="index.php?controller=adminPost&action=delete&id=<?php echo $post['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?');">
                                   Xóa
                                </a>
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