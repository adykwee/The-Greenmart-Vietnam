<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
  </head>
  <body class=" layout-fluid">
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">ADMIN PANEL</a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                <span class="avatar avatar-sm" style="background-image: url(./assets/uploads/<?php echo $_SESSION['user']['avatar']; ?>)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $_SESSION['user']['name']; ?></div>
                  <div class="mt-1 small text-muted">Admin</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li><a class="dropdown-item" href="index.php">Trang chủ</a></li>
                <li><a class="dropdown-item" href="index.php?controller=auth&action=profile">Hồ sơ cá nhân</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">Đăng xuất</a></li>
              </div>
            </div>
          </div>
        </div>
      </header>
      
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=admin&action=dashboard" >
                    <span class="nav-link-title">Dashboard</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminProduct&action=index" >
                    <span class="nav-link-title">Sản phẩm</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminOrder&action=index" >
                    <span class="nav-link-title">Đơn hàng</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminPost&action=index" >
                    <span class="nav-link-title">Tin tức</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminPost&action=comments" >
                    <span class="nav-link-title">Bình luận</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminFAQ&action=index">
                    <span class="nav-link-title">Quản lý FAQ</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminContact&action=index">
                    <span class="nav-link-title">Liên hệ khách hàng</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?controller=adminSetting&action=index" >
                    <span class="nav-link-title">Cấu hình</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <div class="page-wrapper">