<?php include './views/layouts/header_client.php'; ?>

<div class="bg-primary text-white text-center py-5 mb-5">
    <div class="container">
        <h1 class="fw-bold">Liên Hệ Với Chúng Tôi</h1>
        <p class="lead">Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4">Gửi tin nhắn</h3>
                    <form action="index.php?controller=contact" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung tin nhắn</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Bạn cần hỗ trợ gì?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Gửi Liên Hệ</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="ps-md-4">
                <h3 class="mb-4">Thông tin liên lạc</h3>
        
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 btn-square bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1">Địa chỉ</h5>
                        <p class="text-muted">
                            <?php echo $settings['contact_address'] ?? 'Chưa cập nhật'; ?>
                        </p>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 btn-square bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1">Điện thoại</h5>
                        <p class="text-muted">
                            <?php echo $settings['contact_phone'] ?? 'Chưa cập nhật'; ?>
                        </p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 btn-square bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1">Email</h5>
                        <p class="text-muted">
                            <?php echo $settings['contact_email'] ?? 'Chưa cập nhật'; ?>
                        </p>
                    </div>
                </div>

                <div class="map-container rounded overflow-hidden shadow-sm">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.669726937899!2d106.66688831480069!3d10.759917092332712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f9023a3a85d%3A0x62a5d20063223028!2sHo%20Chi%20Minh%20City!5e0!3m2!1sen!2s!4v1634567890000!5m2!1sen!2s" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>