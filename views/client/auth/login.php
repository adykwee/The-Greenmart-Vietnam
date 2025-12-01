<?php include './views/layouts/header_client.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center">Đăng Nhập</h3>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="index.php?controller=auth&action=login" method="POST">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
            </form>
            <p class="mt-3 text-center">
                Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>