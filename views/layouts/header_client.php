<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($settings['site_name']) ? $settings['site_name'] : 'Website Bán Hàng'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card:hover { transform: translateY(-5px); transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .hero-banner { background: #f8f9fa; padding: 60px 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <?php if(isset($settings['site_logo']) && !empty($settings['site_logo'])): ?>
        <img src="./assets/uploads/<?php echo $settings['site_logo']; ?>" alt="Logo" height="40">
      <?php else: ?>
        <?php echo isset($settings['site_name']) ? $settings['site_name'] : 'TECH STORE'; ?>
      <?php endif; ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=product">Sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=post">Tin tức</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=page&action=about">Giới thiệu</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=contact">Liên hệ</a></li>
      </ul>
      
      <form class="d-flex me-3" action="index.php" method="GET">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="search">
        <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm sản phẩm..." required>
        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
      </form>

      <div class="d-flex align-items-center gap-3">
        <?php 
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        ?>
        <a href="index.php?controller=cart" class="btn btn-light position-relative">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $cartCount; ?>
            </span>
        </a>

        <?php if(isset($_SESSION['user'])): ?>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Hello, <?php echo $_SESSION['user']['name']; ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if($_SESSION['user']['role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="index.php?controller=admin&action=dashboard">Trang quản trị</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="index.php?controller=auth&action=profile">Hồ sơ cá nhân</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">Đăng xuất</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="index.php?controller=auth&action=login" class="btn btn-outline-light">Đăng nhập</a>
            <a href="index.php?controller=auth&action=register" class="btn btn-warning">Đăng ký</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>