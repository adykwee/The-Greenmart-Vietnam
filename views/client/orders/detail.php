<?php include './views/layouts/header_client.php'; ?>

<section class="container my-4">
    <a class="d-inline-block mb-3" href="index.php?controller=order">Quay lại đơn hàng của tôi</a>
    <?php if (!$order): ?>
        <h1 class="h3">Không tìm thấy đơn hàng</h1>
    <?php else: ?>
        <h1 class="h3">Đơn hàng #<?= (int) $order['id'] ?></h1>
        <p>Ngày đặt: <?= htmlspecialchars($order['created_at']) ?> · Trạng thái: <?= htmlspecialchars($statusLabels[$order['status']] ?? 'Chưa xác định') ?></p>
        <?php if (!$items): ?>
            <p>Đơn hàng này không còn chi tiết sản phẩm.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>Sản phẩm</th><th class="text-end">Giá lúc mua</th><th class="text-end">Số lượng</th><th class="text-end">Thành tiền</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name'] ?? 'Sản phẩm không còn trong danh mục') ?></td>
                            <td class="text-end"><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                            <td class="text-end"><?= (int) $item['quantity'] ?></td>
                            <td class="text-end"><?= number_format((int) $item['price'] * (int) $item['quantity'], 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <p class="text-end fw-bold">Tổng tiền đơn hàng: <?= number_format($order['total_money'], 0, ',', '.') ?> đ</p>
    <?php endif; ?>
</section>

<?php include './views/layouts/footer_client.php'; ?>
