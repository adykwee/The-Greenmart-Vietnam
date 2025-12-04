<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg p-4" style="border-radius: 12px;">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4" style="color: var(--green);">Đăng Nhập</h3>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=login" method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Mật khẩu</label>
                        </div>
                        
                        <button type="submit" class="btn btn-green w-100 py-2 fs-5 mb-3">Đăng Nhập</button>
                        
                        <div class="text-center">
                            <p class="text-muted small mb-0">Chưa có tài khoản?</p>
                            <a href="index.php?controller=auth&action=register" class="text-success fw-bold text-decoration-none">Đăng ký ngay</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>