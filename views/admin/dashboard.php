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
    <section class="card mb-3" aria-labelledby="sales-report-title">
      <div class="card-body">
        <h3 class="card-title" id="sales-report-title">Báo cáo doanh thu</h3>
        <p class="text-muted">Tính theo ngày đặt hàng. Chỉ tính đơn đã hoàn thành.</p>
        <form method="get" action="index.php" class="row g-2 align-items-end">
          <input type="hidden" name="controller" value="admin">
          <input type="hidden" name="action" value="dashboard">
          <div class="col-sm-auto">
            <label class="form-label" for="from-date">Từ ngày</label>
            <input class="form-control" type="date" id="from-date" name="from_date" value="<?= htmlspecialchars($fromDate) ?>">
          </div>
          <div class="col-sm-auto">
            <label class="form-label" for="to-date">Đến ngày</label>
            <input class="form-control" type="date" id="to-date" name="to_date" value="<?= htmlspecialchars($toDate) ?>">
          </div>
          <div class="col-sm-auto">
            <button class="btn btn-primary" type="submit">Xem báo cáo</button>
            <a class="btn btn-outline-secondary" href="index.php?controller=admin&amp;action=dashboard">Toàn thời gian</a>
          </div>
        </form>
        <?php if ($reportError !== null): ?>
          <div class="alert alert-warning mt-3 mb-0" role="alert"><?= htmlspecialchars($reportError) ?></div>
        <?php endif; ?>
      </div>
    </section>
    <div class="row row-deck row-cards">
      
      <?php if ($salesReport !== null): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card bg-primary text-primary-fg">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader text-white">Doanh thu theo kỳ</div>
            </div>
            <div class="h1 mb-3"><?= number_format($salesReport['revenue'], 0, ',', '.') ?> đ</div>
            <div><?= number_format($salesReport['completed_orders'], 0, ',', '.') ?> đơn hoàn thành</div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
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
    <?php if ($salesReport !== null): ?>
    <section class="card mt-3" aria-labelledby="best-sellers-title">
      <div class="card-header"><h3 class="card-title" id="best-sellers-title">10 sản phẩm bán chạy trong kỳ</h3></div>
      <?php if (!$salesReport['best_sellers']): ?>
        <div class="card-body">Chưa có sản phẩm bán trong kỳ này.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table card-table table-vcenter">
            <thead><tr><th>Sản phẩm</th><th class="text-end">Số lượng bán</th><th class="text-end">Doanh thu sản phẩm</th></tr></thead>
            <tbody>
              <?php foreach ($salesReport['best_sellers'] as $product): ?>
              <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td class="text-end"><?= number_format($product['units_sold'], 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($product['revenue'], 0, ',', '.') ?> đ</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
    <?php endif; ?>
  </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>
