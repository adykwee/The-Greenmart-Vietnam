<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Chi tiết sản phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?controller=product" class="text-decoration-none text-muted">Cửa hàng</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page"><?php echo $product['name']; ?></li>
            </ol>
        </nav>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="./assets/uploads/<?php echo $product['image'] ? $product['image'] : 'default.jpg'; ?>" 
                     class="img-fluid rounded" 
                     alt="<?php echo $product['name']; ?>">
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold"><?php echo $product['name']; ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-success">Còn hàng</span>
                <span class="text-muted ms-2">Mã SP: #<?php echo $product['id']; ?></span>
            </div>

            <h2 class="text-danger fw-bold mb-4"><?php echo number_format($product['price']); ?> VNĐ</h2>

            <p class="lead"><?php echo $product['description']; ?></p>

            <hr>

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="index.php?controller=cart&action=add&id=<?php echo $product['id']; ?>" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
                </a>
                <a href="index.php?controller=contact" class="btn btn-outline-secondary btn-lg">
                   <i class="fas fa-phone"></i> Liên hệ tư vấn
                </a>
            </div>

            <div class="card bg-light border-0">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Giao hàng toàn quốc</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Đổi trả trong 7 ngày</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#desc">Chi tiết sản phẩm</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#review">Đánh giá</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0 bg-white">
                <div class="tab-pane fade show active" id="desc">
                    <?php echo nl2br($product['content']) ? nl2br($product['content']) : 'Chưa có thông tin chi tiết.'; ?>
                </div>
                <div class="tab-pane fade" id="review">
                    <p>Chức năng đánh giá đang được cập nhật...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>