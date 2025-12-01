<?php include './views/layouts/header_client.php'; ?>

<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
        </ol>
    </nav>
</div>

<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                 class="img-fluid rounded shadow" alt="Our Team">
        </div>
        <div class="col-md-6 mt-4 mt-md-0 ps-md-5">
            <h6 class="text-primary fw-bold text-uppercase">Câu chuyện của chúng tôi</h6>
            <h2 class="display-6 fw-bold mb-4">Chúng tôi mang công nghệ đến gần bạn hơn</h2>
            <p class="text-muted">
                Được thành lập vào năm 2024, TechStore bắt đầu với sứ mệnh đơn giản: cung cấp các sản phẩm công nghệ chính hãng với mức giá tốt nhất cho người tiêu dùng Việt Nam.
            </p>
            <p class="text-muted">
                Trải qua quá trình phát triển, chúng tôi tự hào là đối tác của các thương hiệu lớn như Apple, Samsung, Dell, Asus. Chúng tôi không chỉ bán sản phẩm, chúng tôi bán sự an tâm và trải nghiệm tuyệt vời.
            </p>
            <div class="mt-4">
                <div class="row text-center">
                    <div class="col-4">
                        <h3 class="fw-bold">5+</h3>
                        <small>Năm kinh nghiệm</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold">10k+</h3>
                        <small>Khách hàng</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold">100%</h3>
                        <small>Chính hãng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Tại Sao Chọn Tech Store?</h2>
            <p class="text-muted w-75 mx-auto">Chúng tôi cam kết mang lại những giá trị tốt nhất cho khách hàng thông qua chất lượng dịch vụ và sản phẩm.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="text-primary mb-3"><i class="fas fa-shipping-fast fa-3x"></i></div>
                    <h5>Giao Hàng Thần Tốc</h5>
                    <p class="text-muted">Giao hàng trong 2h nội thành và 2-3 ngày toàn quốc.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="text-primary mb-3"><i class="fas fa-shield-alt fa-3x"></i></div>
                    <h5>Bảo Hành Uy Tín</h5>
                    <p class="text-muted">Cam kết bảo hành chính hãng, đổi mới trong 30 ngày đầu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="text-primary mb-3"><i class="fas fa-headset fa-3x"></i></div>
                    <h5>Hỗ Trợ 24/7</h5>
                    <p class="text-muted">Đội ngũ kỹ thuật viên luôn sẵn sàng hỗ trợ bạn bất cứ lúc nào.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Đội Ngũ Phát Triển</h2>
    </div>
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <img src="./assets/uploads/default.png" class="rounded-circle mb-3" width="100" height="100">
                    <h5 class="card-title">Nguyễn Văn A</h5>
                    <p class="text-muted small">Role 1: Contact & Settings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <img src="./assets/uploads/default.png" class="rounded-circle mb-3" width="100" height="100">
                    <h5 class="card-title">Trần Thị B</h5>
                    <p class="text-muted small">Role 2: About & FAQ</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <img src="./assets/uploads/default.png" class="rounded-circle mb-3" width="100" height="100">
                    <h5 class="card-title">Lê Văn C</h5>
                    <p class="text-muted small">Role 3: Product & Cart</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <img src="./assets/uploads/default.png" class="rounded-circle mb-3" width="100" height="100">
                    <h5 class="card-title">Phạm Thị D</h5>
                    <p class="text-muted small">Role 4: News & Comments</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>