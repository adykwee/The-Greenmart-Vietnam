<?php include './views/layouts/header_admin.php'; ?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Tổng quan hệ thống</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">
      
      <div class="col-sm-6 col-lg-3">
        <div class="card bg-primary text-primary-fg">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader text-white">Doanh thu thực tế</div>
            </div>
            <div class="h1 mb-3"><?php echo number_format($revenue); ?> đ</div>
          </div>
        </div>
      </div>
      
      <div class="col-sm-6 col-lg-3">
        <div class="card <?php echo ($newOrders > 0) ? 'bg-danger text-white' : ''; ?>">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader <?php echo ($newOrders > 0) ? 'text-white' : ''; ?>">Đơn hàng chờ xử lý</div>
            </div>
            <div class="h1 mb-3"><?php echo $newOrders; ?></div>
            <a href="index.php?controller=adminOrder&action=index" class="text-reset text-decoration-underline">Xem ngay</a>
          </div>
        </div>
      </div>

       <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Tổng sản phẩm</div>
            </div>
            <div class="h1 mb-3"><?php echo $totalProducts; ?></div>
          </div>
        </div>
      </div>

       <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Thành viên đăng ký</div>
            </div>
            <div class="h1 mb-3"><?php echo $totalUsers; ?></div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>