<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Hồ sơ cá nhân</h5>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?controller=auth&action=updateProfile" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <img id="avatarPreview" 
                                     src="./assets/uploads/<?php echo $user['avatar']; ?>" 
                                     class="rounded-circle img-thumbnail mb-3" 
                                     style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #eee;">
                                
                                <label class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-camera me-1"></i> Chọn ảnh mới
                                    <input type="file" name="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </label>
                                <small class="text-muted d-block mt-2">Chỉ nhận file ảnh (JPG, PNG)</small>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email đăng nhập</label>
                                    <input type="text" class="form-control bg-light" value="<?php echo $user['email']; ?>" disabled>
                                    <small class="text-muted">Email không thể thay đổi.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Họ và tên</label>
                                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                </div>
                                <div class="text-end">
                                     <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Cập nhật hồ sơ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h5>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?controller=auth&action=changePassword" method="POST">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold">Mật khẩu hiện tại</label>
                            <div class="col-sm-8">
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold">Mật khẩu mới</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control" required minlength="6">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold">Nhập lại MK mới</label>
                            <div class="col-sm-8">
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">Xác nhận đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function previewImage(input) {
    // Kiểm tra xem người dùng đã chọn file chưa
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        // Khi file được đọc thành công
        reader.onload = function(e) {
            // Gán kết quả đọc được (dạng base64) vào thuộc tính src của thẻ img
            document.getElementById('avatarPreview').src = e.target.result;
        }

        // Bắt đầu đọc file ảnh dưới dạng Data URL
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include './views/layouts/footer_client.php'; ?>