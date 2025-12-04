<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo isset($meta_title) ? $meta_title : ($settings['site_name'] ?? 'The Greenmart Vietnam'); ?></title>
    <meta name="description" content="<?php echo isset($meta_desc) ? substr(strip_tags($meta_desc), 0, 160) : 'Chuyên cung cấp sản phẩm xanh, thân thiện môi trường...'; ?>">
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : 'sản phẩm xanh, bảo vệ môi trường, greenmart'; ?>">
    
    <meta property="og:title" content="<?php echo isset($meta_title) ? $meta_title : 'The Greenmart'; ?>">
    <meta property="og:image" content="<?php echo isset($meta_image) ? './assets/uploads/'.$meta_image : './assets/images/logo-default.png'; ?>">
    
    <link rel="canonical" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- MÀU SẮC GREENMART --- */
        :root {
            --green: #2f8f4e; /* Màu xanh chủ đạo */
            --dark-green: #07350dff;
        }

        /* --- HEADER CHUNG --- */
        body {
            background-color: #f7f8fa; /* Nền web xám nhẹ cho nổi header trắng */
        }
        
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); /* Đổ bóng nhẹ */
            padding-top: 15px;
            padding-bottom: 15px;
        }

        /* Logo / Tên thương hiệu */
        .navbar-brand {
            color: var(--green) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* --- MENU LINKS (Hiệu ứng gạch chân xanh) --- */
        .nav-link {
            color: #1f2d27 !important; /* Màu chữ đen xám */
            font-weight: 600;
            margin-right: 15px;
            position: relative;
            transition: color 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--green) !important;
        }

        /* Tạo đường kẻ xanh chạy ra khi hover */
        .nav-link::after {
            content: "";
            height: 2px;
            background: var(--green);
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0px;
            transform: scaleX(0); /* Mặc định ẩn */
            transform-origin: left center;
            transition: transform 0.25s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1); /* Hiện ra khi hover */
        }

        /* --- NÚT BẤM & SEARCH --- */
        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 0.25rem rgba(47, 143, 78, 0.25);
        }

        .btn-search {
            color: var(--green);
            border-color: var(--green);
        }
        .btn-search:hover {
            background-color: var(--green);
            color: white;
        }

        .btn-action {
            border-color: #eef2f1;
            color: #1f2d27;
        }
        .btn-action:hover {
            background-color: #eef2f1;
            color: var(--green);
        }

        .btn-auth-login {
            color: var(--green);
            border: 1px solid var(--green);
        }
        .btn-auth-login:hover {
            background-color: var(--green);
            color: white;
        }

        .btn-auth-register {
            background-color: var(--green);
            color: white;
            border: 1px solid var(--green);
        }
        .btn-auth-register:hover {
            background-color: var(--dark-green);
            color: white;
        }

        /* --- DROPDOWN USER --- */
        .dropdown-item:active {
            background-color: var(--green);
        }

        /* --- CARD STYLE (Dùng chung cho Product & News) --- */
        .card-custom {
            border: 0;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            background: #fff;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
            overflow: hidden;
        }
        .card-custom:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(46, 61, 73, 0.12);
        }
        .card-img-top-custom {
            width: 100%;
            aspect-ratio: 1/1; /* Ảnh vuông */
            object-fit: cover;
            display: block;
        }
        .card-body-custom {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .text-price {
            color: var(--green);
            font-weight: 700;
            font-size: 1.1rem;
        }
        .btn-green {
            background-color: var(--green);
            color: #fff;
            border: none;
            font-weight: 500;
        }
        .btn-green:hover {
            background-color: #24753e;
            color: #fff;
        }
        .btn-outline-green {
            color: var(--green);
            border: 1px solid var(--green);
            background: transparent;
        }
        .btn-outline-green:hover {
            background: var(--green);
            color: #fff;
        }

        /* --- PAGE TITLE --- */
        .page-header-block {
            background: linear-gradient(180deg, rgba(47, 143, 78, 0.08), rgba(0, 0, 0, 0.02));
            padding: 40px 0;
            margin-bottom: 40px;
        }

        /* --- FORM & SEARCH --- */
        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 0.25rem rgba(47, 143, 78, 0.25);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <?php if(isset($settings['site_logo']) && !empty($settings['site_logo'])): ?>
        <img src="./assets/uploads/<?php echo $settings['site_logo']; ?>" alt="Logo" height="40">
      <?php else: ?>
        <i class="fas fa-leaf me-2"></i><?php echo isset($settings['site_name']) ? $settings['site_name'] : 'The Greenmart Vietnam'; ?>
      <?php endif; ?>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=product">Cửa hàng</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=post">Tin tức</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=page&action=about">Về chúng tôi</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?controller=contact">Liên hệ</a></li>
      </ul>
      
      <form class="d-flex me-lg-3 mb-3 mb-lg-0" action="index.php" method="GET">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="search">
        <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm sản phẩm..." required>
        <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
      </form>

      <div class="d-flex align-items-center gap-3">
        <?php 
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        ?>
        <a href="index.php?controller=cart" class="btn btn-action position-relative">
            <i class="fas fa-shopping-bag fa-lg"></i>
            <?php if($cartCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                <?php echo $cartCount; ?>
            </span>
            <?php endif; ?>
        </a>

        <?php if(isset($_SESSION['user'])): ?>
            <div class="dropdown">
                <a class="btn btn-action dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="./assets/uploads/<?php echo $_SESSION['user']['avatar']; ?>" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                    <span class="d-none d-lg-inline fw-bold small"><?php echo $_SESSION['user']['name']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <?php if($_SESSION['user']['role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="index.php?controller=admin&action=dashboard"><i class="fas fa-tachometer-alt me-2 text-muted"></i>Trang quản trị</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="index.php?controller=auth&action=profile"><i class="fas fa-user-circle me-2 text-muted"></i>Hồ sơ cá nhân</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="index.php?controller=auth&action=login" class="btn btn-auth-login btn-sm fw-bold">Đăng nhập</a>
            <a href="index.php?controller=auth&action=register" class="btn btn-auth-register btn-sm fw-bold">Đăng ký</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>