<?php include './views/layouts/header_client.php'; ?>

<section class="hero position-relative mb-5">
    <div style="width: 100%; height: 100%; overflow: hidden; background: #eee;">
        <?php 
            // Kiểm tra xem Admin có up ảnh chưa, nếu chưa thì dùng ảnh mặc định online
            $bannerSrc = !empty($settings['page_home_banner']) 
                        ? "./assets/uploads/" . $settings['page_home_banner'] 
                        : "./assets/images/banner.png";
        ?>
        <img src="<?php echo $bannerSrc; ?>" 
            alt="Banner" 
            style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div class="position-absolute bottom-0 start-50 translate-middle text-center text-white bg-dark bg-opacity-25 p-4 rounded-3 d-none d-md-block">
        <h1 class="fw-bold display-5">Sống Xanh Cùng Greenmart</h1>
        <p class="lead">Sản phẩm thân thiện môi trường cho cuộc sống bền vững</p>
        <a href="index.php?controller=product" class="btn btn-green btn-lg mt-3 shadow">Mua Sắm Ngay</a>
    </div>
</section>

<div class="container mb-5">
    <div class="text-center mb-5">
        <h2 class="h4 fw-bold">SẢN PHẨM MỚI NHẤT</h2>
        <div class="mx-auto bg-success" style="width: 60px; height: 3px;"></div>
    </div>

    <div class="row g-4">
        <?php foreach(array_slice($products, 0, 4) as $p): ?>
        <div class="col-md-3 col-sm-6">
            <div class="card card-custom h-100">
                <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>">
                    <img src="./assets/uploads/<?php echo $p['image']; ?>" 
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
    
    <div class="text-center mt-4">
        <a href="index.php?controller=product" class="btn btn-outline-green px-4 rounded-pill">Xem tất cả sản phẩm</a>
    </div>
</div>

<div class="bg-white py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h4 fw-bold">TIN TỨC</h2>
            <div class="mx-auto bg-success" style="width: 60px; height: 3px;"></div>
        </div>
        <div class="row g-4">
            <?php foreach(array_slice($newsList, 0, 3) as $n): ?>
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="./assets/uploads/<?php echo $n['image']; ?>" class="card-img-top-custom" style="aspect-ratio: 16/9;" alt="<?php echo $n['title']; ?>">
                    <div class="card-body-custom">
                        <h5 class="card-title fw-bold" style="font-size: 1.1rem;"><?php echo $n['title']; ?></h5>
                        <p class="text-muted small flex-grow-1">
                            <?php echo substr(strip_tags($n['description']), 0, 90); ?>...
                        </p>
                        <a href="index.php?controller=post&action=detail&id=<?php echo $n['id']; ?>" class="btn btn-sm btn-outline-green align-self-start">Đọc tiếp</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>