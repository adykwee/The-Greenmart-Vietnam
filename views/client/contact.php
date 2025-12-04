<?php include './views/layouts/header_client.php'; ?>

<style>
    .card-contact {
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(15, 40, 25, 0.06);
        border: 0;
        background: #fff;
    }
    .form-floating textarea {
        height: 140px;
    }
    .map-wrap {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .btn-submit-contact {
        background-color: var(--green);
        color: white;
        border: none;
        padding: 10px 24px;
        font-weight: 500;
    }
    .btn-submit-contact:hover {
        background-color: #24753e;
        color: white;
    }
</style>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Liên hệ với chúng tôi</h1>
        <p class="text-muted mb-0">
            Bạn có câu hỏi? Gửi tin nhắn cho <?php echo $settings['site_name'] ?? 'The Greenmart'; ?> — chúng tôi phản hồi nhanh chóng.
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</section>

<main class="container mb-5">
    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="card card-contact p-4 h-100">
                <h5 class="mb-4 fw-bold text-dark">Gửi tin nhắn</h5>
                
                <form action="index.php?controller=contact" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên" required>
                                <label for="name">Họ và tên *</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email">Email *</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Nội dung" id="message" name="message" required style="height: 150px"></textarea>
                                <label for="message">Nội dung câu hỏi hoặc góp ý *</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-submit-contact">Gửi đi</button>
                            <button type="reset" class="btn btn-outline-secondary">Xóa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <aside class="col-lg-5">
            <div class="card card-contact p-4 mb-4">
                <h6 class="fw-bold mb-3">Thông tin liên hệ</h6>
                
                <div class="d-flex mb-3">
                    <i class="fas fa-phone-alt mt-1 me-3 text-success"></i>
                    <div>
                        <strong>Hotline:</strong><br>
                        <a href="tel:<?php echo $settings['contact_phone'] ?? ''; ?>" class="text-decoration-none text-muted">
                            <?php echo $settings['contact_phone'] ?? 'Đang cập nhật'; ?>
                        </a>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <i class="fas fa-envelope mt-1 me-3 text-success"></i>
                    <div>
                        <strong>Email:</strong><br>
                        <a href="mailto:<?php echo $settings['contact_email'] ?? ''; ?>" class="text-decoration-none text-muted">
                            <?php echo $settings['contact_email'] ?? 'info@website.com'; ?>
                        </a>
                    </div>
                </div>

                <div class="d-flex">
                    <i class="fas fa-map-marker-alt mt-1 me-3 text-success"></i>
                    <div>
                        <strong>Địa chỉ:</strong><br>
                        <span class="text-muted"><?php echo $settings['contact_address'] ?? 'Đang cập nhật địa chỉ'; ?></span>
                    </div>
                </div>
            </div>

            <div class="card card-contact p-2">
                <div class="ratio ratio-16x9 map-wrap">
                    <?php if(!empty($settings['contact_map_iframe'])): ?>
                        <?php echo $settings['contact_map_iframe']; ?>
                    <?php else: ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.5727052384!2d106.78422099999999!3d10.8439755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175279cdbce40d9%3A0x1d6b26c7ea43e076!2sThe%20Greenmart%20Vietnam!5e0!3m2!1svi!2s!4v1764778152784!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

    </div>
</main>

<?php include './views/layouts/footer_client.php'; ?>