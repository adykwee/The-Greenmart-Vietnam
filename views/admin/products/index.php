<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý sản phẩm</h2>
        <a href="index.php?controller=adminProduct&action=create" class="btn btn-success">
            + Thêm mới
        </a>
    </div>

    <div class="card">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td>
                        <?php if($p['image']): ?>
                            <img src="./assets/uploads/<?php echo $p['image']; ?>" 
                                 alt="Ảnh SP" width="80" height="80" style="object-fit: cover; border-radius: 5px">
                        <?php else: ?>
                            <span>Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $p['name']; ?></td>
                    <td><?php echo number_format($p['price']); ?> đ</td>
                    <td>
                        <a href="index.php?controller=adminProduct&action=edit&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                        
                        <a href="index.php?controller=adminProduct&action=delete&id=<?php echo $p['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                           Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>