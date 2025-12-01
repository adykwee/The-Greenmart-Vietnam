<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Tạo Tài Khoản</h2>
                        <p class="text-muted">Tham gia cộng đồng TechStore ngay hôm nay</p>
                    </div>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=register" method="POST" id="registerForm" onsubmit="return validateForm()">
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nguyễn Văn A" required>
                            <label for="fullname">Họ và tên</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Địa chỉ Email</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required minlength="6">
                            <label for="password">Mật khẩu (Tối thiểu 6 ký tự)</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                            <label for="confirm_password">Nhập lại mật khẩu</label>
                            <div id="passError" class="text-danger small mt-1" style="display:none;">Mật khẩu không khớp!</div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="agreeTerm" required>
                            <label class="form-check-label text-muted small" for="agreeTerm">
                                Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>.
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" type="submit">Đăng Ký Ngay</button>
                        </div>

                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Bạn đã có tài khoản? <a href="index.php?controller=auth&action=login" class="fw-bold text-primary text-decoration-none">Đăng nhập</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    var errorDiv = document.getElementById("passError");

    if (password != confirmPassword) {
        errorDiv.style.display = "block";
        document.getElementById("confirm_password").classList.add("is-invalid");
        return false; // Chặn không cho submit
    } else {
        errorDiv.style.display = "none";
        document.getElementById("confirm_password").classList.remove("is-invalid");
        return true; // Cho phép submit
    }
}
</script>

<?php include './views/layouts/footer_client.php'; ?>