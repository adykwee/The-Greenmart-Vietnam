<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Tìm kiếm</div>
                <div class="card-body">
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="product">
                        <input type="hidden" name="action" value="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Nhập tên SP...">
                            <button class="btn btn-outline-primary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h2 class="mb-4 border-bottom pb-2"><?php echo isset($title) ? $title : 'Tất cả sản phẩm'; ?></h2>
            
            <?php if(empty($products)): ?>
                <div class="alert alert-warning">Không tìm thấy sản phẩm nào.</div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($products as $p): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm product-card">
                            <div class="position-relative overflow-hidden">
                                <img src="./assets/uploads/<?php echo $p['image'] ? $p['image'] : 'default.jpg'; ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $p['name']; ?>"
                                     style="height: 250px; object-fit: cover;">
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">
                                    <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo $p['name']; ?>
                                    </a>
                                </h5>
                                <p class="card-text text-danger fw-bold mb-3"><?php echo number_format($p['price']); ?> VNĐ</p>
                                
                                <div class="mt-auto d-grid gap-2">
                                    <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>" class="btn btn-outline-secondary">Xem chi tiết</a>
                                    <a href="index.php?controller=cart&action=add&id=<?php echo $p['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </a>
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
                            <a class="page-link" href="index.php?controller=product&page=<?php echo $i; ?>"><?php echo $i; ?></a>
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