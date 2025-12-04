<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Cấu hình Website</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form action="index.php?controller=adminSetting&action=index" method="POST" enctype="multipart/form-data">
                
                <h3 class="card-title text-primary">Thông tin chung</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên Website</label>
                        <input type="text" name="site_name" class="form-control" value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="contact_phone" class="form-control" value="<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="contact_address" class="form-control" value="<?php echo htmlspecialchars($settings['contact_address'] ?? ''); ?>">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Logo Website</label>
                        <div class="d-flex align-items-center gap-3">
                            <?php if(!empty($settings['site_logo'])): ?>
                                <img src="./assets/uploads/<?php echo $settings['site_logo']; ?>" style="height: 50px;" class="border rounded p-1">
                            <?php endif; ?>
                            <input type="file" name="site_logo" class="form-control">
                        </div>
                    </div>
                </div>

                <hr>

                <h3 class="card-title text-primary">Trang Chủ</h3>
                
                <div class="mb-3">
                    <label class="form-label">Banner chính (Hero Image)</label>
                    <div class="d-flex align-items-center gap-3">
                        <?php if(!empty($settings['page_home_banner'])): ?>
                            <img src="./assets/uploads/<?php echo $settings['page_home_banner']; ?>" 
                                 style="height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                        <?php endif; ?>
                        
                        <div class="flex-grow-1">
                            <input type="file" name="page_home_banner" class="form-control">
                            <small class="text-muted">Kích thước khuyên dùng: 1920x600px hoặc lớn hơn.</small>
                        </div>
                    </div>
                </div>

                <hr>

                <h3 class="card-title text-primary">Trang Liên Hệ</h3>
                <div class="mb-3">
                    <label class="form-label">Mã nhúng Google Maps (Iframe)</label>
                    <textarea name="contact_map_iframe" class="form-control" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>'><?php echo $settings['contact_map_iframe'] ?? ''; ?></textarea>
                    <small class="text-muted">Vào Google Maps -> Chia sẻ -> Nhúng bản đồ -> Copy mã HTML dán vào đây.</small>
                </div>

                <hr>

                <h3 class="card-title text-primary">Trang Giới Thiệu</h3>
                
                <div class="mb-3">
                    <label class="form-label">Ảnh giới thiệu</label>
                    <div class="d-flex align-items-center gap-3">
                        <?php if(!empty($settings['page_about_image'])): ?>
                            <img src="./assets/uploads/<?php echo $settings['page_about_image']; ?>" style="height: 80px;" class="border rounded p-1">
                        <?php endif; ?>
                        <input type="file" name="page_about_image" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tiêu đề giới thiệu</label>
                    <input type="text" name="page_about_title" class="form-control" value="<?php echo htmlspecialchars($settings['page_about_title'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung giới thiệu (HTML)</label>
                    <textarea name="page_about_content" class="form-control" rows="10"><?php echo htmlspecialchars($settings['page_about_content'] ?? ''); ?></textarea>
                    <small class="text-muted">Bạn có thể nhập mã HTML (thẻ p, strong, ul, li...) để trang trí.</small>
                </div>

                <div class="form-footer text-end">
                    <button type="submit" class="btn btn-primary">Lưu Cấu Hình</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>