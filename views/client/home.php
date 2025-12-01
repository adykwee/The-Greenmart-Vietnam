<?php include './views/layouts/header_client.php'; ?>

<section class="hero-banner text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Chào mừng đến với Tech Store</h1>
        <p class="lead">Nơi cung cấp các thiết bị công nghệ hiện đại nhất</p>
        <a href="index.php?controller=product" class="btn btn-primary btn-lg mt-3">Mua sắm ngay</a>
    </div>
</section>

<div class="container mt-5">
    <h2 class="text-center mb-4">Sản Phẩm Mới Nhất</h2>
    <div class="row">
        <?php foreach(array_slice($products, 0, 4) as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card product-card h-100">
                <img src="./assets/uploads/<?php echo $p['image']; ?>" class="card-img-top" alt="<?php echo $p['name']; ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $p['name']; ?></h5>
                    <p class="card-text text-danger fw-bold"><?php echo number_format($p['price']); ?> đ</p>
                    <div class="mt-auto">
                        <a href="index.php?controller=product&action=detail&id=<?php echo $p['id']; ?>" class="btn btn-outline-primary w-100">Xem chi tiết</a>
                        <a href="index.php?controller=cart&action=add&id=<?php echo $p['id']; ?>" class="btn btn-primary w-100 mt-2">Thêm vào giỏ</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
        <a href="index.php?controller=product" class="btn btn-outline-dark">Xem tất cả sản phẩm</a>
    </div>
</div>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Tin Tức Công Nghệ</h2>
    <div class="row">
         <?php foreach(array_slice($newsList, 0, 3) as $news): ?>
         <div class="col-md-4">
             <div class="card mb-3">
                 <div class="card-body">
                     <h5 class="card-title"><?php echo $news['title']; ?></h5>
                     <p class="card-text text-muted"><?php echo substr($news['description'], 0, 100); ?>...</p>
                     <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="card-link">Đọc tiếp</a>
                 </div>
             </div>
         </div>
         <?php endforeach; ?>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>