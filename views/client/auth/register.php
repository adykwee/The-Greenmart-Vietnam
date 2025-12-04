<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg p-4" style="border-radius: 12px;">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold" style="color: var(--green);">Đăng Ký Thành Viên</h3>
                        <p class="text-muted small">Tạo tài khoản để nhận ưu đãi từ Greenmart</p>
                    </div>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center py-2 small" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=register" method="POST" id="registerForm" onsubmit="return validateForm()">
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên" required>
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
                            <div id="passError" class="text-danger small mt-1" style="display:none;">
                                <i class="fas fa-times-circle me-1"></i>Mật khẩu không khớp!
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="agreeTerm" required>
                            <label class="form-check-label text-muted small" for="agreeTerm">
                                Tôi đồng ý với <a href="#" class="text-decoration-none text-success fw-bold">Điều khoản & Chính sách</a>.
                            </label>
                        </div>

                        <button class="btn btn-green w-100 py-2 fs-5 mb-3" type="submit">Đăng Ký</button>

                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Bạn đã có tài khoản?</p>
                        <a href="index.php?controller=auth&action=login" class="text-success fw-bold text-decoration-none">Đăng nhập ngay</a>
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
    var confirmInput = document.getElementById("confirm_password");

    if (password != confirmPassword) {
        errorDiv.style.display = "block";
        confirmInput.classList.add("is-invalid");
        confirmInput.classList.remove("is-valid");
        return false;
    } else {
        errorDiv.style.display = "none";
        confirmInput.classList.remove("is-invalid");
        confirmInput.classList.add("is-valid");
        return true;
    }
}
</script>

<?php include './views/layouts/footer_client.php'; ?>