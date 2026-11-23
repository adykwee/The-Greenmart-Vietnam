<?php include './views/layouts/header_client.php'; ?>

<section class="container my-4">
    <h1 class="h3 mb-3">Đơn hàng của tôi</h1>
    <?php if (!$orders): ?>
        <p>Bạn chưa có đơn hàng.</p>
        <a class="btn btn-green" href="index.php?controller=product">Đến cửa hàng</a>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Trạng thái</th><th class="text-end">Tổng tiền</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><a href="index.php?controller=order&amp;action=detail&amp;id=<?= (int) $order['id'] ?>">#<?= (int) $order['id'] ?></a></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td><?= htmlspecialchars($statusLabels[$order['status']] ?? 'Chưa xác định') ?></td>
                        <td class="text-end"><?= number_format($order['total_money'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php include './views/layouts/footer_client.php'; ?>
