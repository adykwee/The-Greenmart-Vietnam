<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Hồ sơ cá nhân</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">Tài khoản</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container mb-5">
    <div class="row justify-content-center g-4">
        
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 pb-2 border-bottom" style="color: var(--green);">
                        <i class="fas fa-user-edit me-2"></i>Thông tin tài khoản
                    </h5>

                    <form action="index.php?controller=auth&action=updateProfile" method="POST" enctype="multipart/form-data">
                        <div class="d-flex flex-column flex-sm-row gap-4 align-items-center mb-4">
                            
                            <div class="position-relative text-center">
                                <div class="rounded-circle overflow-hidden border border-2 border-success" style="width: 120px; height: 120px;">
                                    <img id="avatarPreview" 
                                         src="./assets/uploads/<?php echo $user['avatar']; ?>" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="Avatar">
                                </div>
                                <label class="btn btn-sm btn-green rounded-pill position-absolute bottom-0 start-50 translate-middle-x mb-n2 shadow-sm" style="white-space: nowrap;">
                                    <i class="fas fa-camera me-1"></i>Đổi ảnh
                                    <input type="file" name="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>

                            <div class="flex-grow-1 w-100">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">EMAIL ĐĂNG NHẬP</label>
                                    <input type="text" class="form-control bg-light" value="<?php echo $user['email']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">HỌ VÀ TÊN</label>
                                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-green px-4">
                                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 pb-2 border-bottom text-danger">
                        <i class="fas fa-shield-alt me-2"></i>Bảo mật
                    </h5>
                    
                    <form action="index.php?controller=auth&action=changePassword" method="POST">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="curr_pass" name="current_password" placeholder="Mật khẩu hiện tại" required>
                            <label for="curr_pass">Mật khẩu hiện tại</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="new_pass" name="new_password" placeholder="Mật khẩu mới" required minlength="6">
                            <label for="new_pass">Mật khẩu mới</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="conf_pass" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                            <label for="conf_pass">Nhập lại mật khẩu mới</label>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-key me-2"></i>Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include './views/layouts/footer_client.php'; ?>