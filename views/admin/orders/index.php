<?php include './views/layouts/header_admin.php'; ?>
<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Quản lý Đơn hàng</h2>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td>
                            <div><?php echo $order['full_name']; ?></div>
                            <div class="text-muted small"><?php echo $order['email']; ?></div>
                        </td>
                        <td><?php echo $order['created_at']; ?></td>
                        <td><?php echo number_format($order['total_money']); ?> đ</td>
                        <td>
                            <?php 
                                $colors = [
                                    'pending' => 'warning',
                                    'processing' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $stt = $order['status'];
                            ?>
                            <span class="badge bg-<?php echo $colors[$stt]; ?>"><?php echo ucfirst($stt); ?></span>
                        </td>
                        <td>
                            <a href="index.php?controller=adminOrder&action=detail&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">Chi tiết</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include './views/layouts/footer_admin.php'; ?>