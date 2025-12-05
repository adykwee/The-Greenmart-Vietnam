<?php include './views/layouts/header_client.php'; ?>

<div class="container mt-5">
    <h2>Giỏ hàng của bạn</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-warning">Giỏ hàng đang trống. <a href="index.php?controller=product">Mua sắm ngay</a></div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="./assets/uploads/<?php echo $item['image']; ?>" width="50"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo number_format($item['price']); ?> đ</td>
                    <td>
                        <a href="index.php?controller=cart&action=update&id=<?php echo $id; ?>&type=decrease" class="btn btn-sm btn-light">-</a>
                        
                        <span class="mx-2"><?php echo $item['quantity']; ?></span>
                        
                        <a href="index.php?controller=cart&action=update&id=<?php echo $id; ?>&type=increase" class="btn btn-sm btn-light">+</a>
                    </td>
                    <td><?php echo number_format($subtotal); ?> đ</td>
                    <td>
                        <a href="index.php?controller=cart&action=delete&id=<?php echo $id; ?>" class="text-danger" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                    <td colspan="2" class="fw-bold text-danger"><?php echo number_format($total); ?> đ</td>
                </tr>
            </tbody>
        </table>

        <div class="text-end">
            <a href="index.php?controller=product" class="btn btn-secondary">Tiếp tục mua sắm</a>
            <a href="index.php?controller=cart&action=checkout" class="btn btn-success btn-lg">Thanh Toán Ngay</a>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer_client.php'; ?>