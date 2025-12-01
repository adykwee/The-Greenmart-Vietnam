<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Cấu hình Website</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="index.php?controller=adminSetting&action=index" method="POST" enctype="multipart/form-data">
                
                <h3 class="card-title">Thông tin chung</h3>
                
                <?php 
                $fields = [
                    'site_name' => 'Tên Website',
                    'contact_email' => 'Email Liên hệ',
                    'contact_phone' => 'Số điện thoại',
                    'contact_address' => 'Địa chỉ công ty',
                    // Có thể thêm các field khác như Google Maps, Facebook link...
                ];
                
                foreach ($fields as $key => $label): 
                ?>
                    <div class="mb-3">
                        <label class="form-label"><?php echo $label; ?></label>
                        <input type="text" 
                               name="<?php echo $key; ?>" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($settings[$key] ?? ''); ?>" 
                               required>
                    </div>
                <?php endforeach; ?>

                <hr>

                <h3 class="card-title">Logo & Hình ảnh</h3>

                <div class="mb-3">
                    <label class="form-label">Logo hiện tại</label>
                    <div class="mb-2">
                        <?php 
                        $logo = $settings['site_logo'] ?? 'default.png';
                        $logoPath = './assets/uploads/' . $logo;
                        ?>
                        <img src="<?php echo $logoPath; ?>" style="max-height: 80px; border: 1px solid #eee;">
                    </div>
                    
                    <label class="form-label">Tải lên Logo mới</label>
                    <input type="file" name="site_logo" class="form-control">
                    <small class="form-text text-muted">Chọn file để thay đổi logo.</small>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>