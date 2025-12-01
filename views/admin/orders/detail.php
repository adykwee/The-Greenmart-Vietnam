<?php include './views/layouts/header_admin.php'; ?>
<div class="container-xl">
    <div class="page-header d-print-none mb-3">
        <h2 class="page-title">Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Thông tin khách hàng</h3></div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> <?php echo $order['full_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                    <p><strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title">Cập nhật trạng thái</h3></div>
                <div class="card-body">
                    <form action="index.php?controller=adminOrder&action=updateStatus" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" class="form-select mb-3">
                            <option value="pending" <?php echo ($order['status']=='pending')?'selected':''; ?>>Chờ xử lý (Pending)</option>
                            <option value="processing" <?php echo ($order['status']=='processing')?'selected':''; ?>>Đang giao (Processing)</option>
                            <option value="completed" <?php echo ($order['status']=='completed')?'selected':''; ?>>Hoàn thành (Completed)</option>
                            <option value="cancelled" <?php echo ($order['status']=='cancelled')?'selected':''; ?>>Hủy bỏ (Cancelled)</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Sản phẩm đã mua</h3></div>
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="./assets/uploads/<?php echo $item['image']; ?>" width="40" class="me-2 rounded">
                                    <?php echo $item['name']; ?>
                                </div>
                            </td>
                            <td><?php echo number_format($item['price']); ?> đ</td>
                            <td>x <?php echo $item['quantity']; ?></td>
                            <td class="text-end"><?php echo number_format($item['price'] * $item['quantity']); ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="text-end fw-bold text-danger"><?php echo number_format($order['total_money']); ?> đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include './views/layouts/footer_admin.php'; ?>