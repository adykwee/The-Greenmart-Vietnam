<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Về chúng tôi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">Về chúng tôi</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <?php 
                $aboutImg = !empty($settings['page_about_image']) 
                            ? "./assets/uploads/" . $settings['page_about_image'] 
                            : "./assets/images/about.png";
            ?>
            <img src="<?php echo $aboutImg; ?>" class="img-fluid rounded-3 shadow" alt="Về chúng tôi">
        </div>

        <div class="col-md-6 ps-md-5">
            <h5 class="text-success fw-bold text-uppercase mb-2">Câu chuyện thương hiệu</h5>
            
            <h2 class="fw-bold mb-4" style="color: #042a1b;">
                <?php echo !empty($settings['page_about_title']) ? $settings['page_about_title'] : 'Chúng tôi mang công nghệ xanh đến cuộc sống'; ?>
            </h2>
            
            <div class="text-muted" style="line-height: 1.8;">
                <?php if(!empty($settings['page_about_content'])): ?>
                    <?php echo $settings['page_about_content']; ?>
                <?php else: ?>
                    <p>Chào mừng đến với Greenmart. Đây là nội dung mặc định. Vui lòng truy cập trang quản trị để cập nhật nội dung giới thiệu.</p>
                <?php endif; ?>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-4 border-end">
                    <h3 class="fw-bold text-success mb-0">5+</h3>
                    <small class="text-muted">Năm hoạt động</small>
                </div>
                <div class="col-4 border-end">
                    <h3 class="fw-bold text-success mb-0">10k+</h3>
                    <small class="text-muted">Khách hàng</small>
                </div>
                <div class="col-4">
                    <h3 class="fw-bold text-success mb-0">100%</h3>
                    <small class="text-muted">Chính hãng</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>