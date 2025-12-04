<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;"><?php echo $title ?? 'Cửa Hàng'; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">Cửa hàng</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 90px; border-radius: 12px;">
                <h5 class="fw-bold mb-3">Tìm kiếm</h5>
                <form action="index.php" method="GET" class="mb-4">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Tên sản phẩm..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                        <button class="btn btn-green" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <?php if(empty($products)): ?>
                <div class="alert alert-light text-center py-5 shadow-sm rounded-3">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($products as $p): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-custom h-100">
                            <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>">
                                <img src="./assets/uploads/<?php echo $p['image'] ? $p['image'] : 'default.jpg'; ?>" 
                                     class="card-img-top-custom" 
                                     alt="<?php echo $p['name']; ?>">
                            </a>
                            <div class="card-body-custom">
                                <h5 class="card-title text-truncate" style="font-size: 1rem;">
                                    <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo $p['name']; ?>
                                    </a>
                                </h5>
                                <p class="text-price mb-2"><?php echo number_format($p['price']); ?>₫</p>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="index.php?controller=cart&action=add&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-green flex-fill">Thêm vào giỏ</a>
                                    <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-secondary flex-fill">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if(isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link <?php echo ($i == $currentPage) ? 'bg-success border-success text-white' : 'text-success'; ?>" 
                               href="index.php?controller=product&page=<?php echo $i; ?>">
                               <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>