<?php include './views/layouts/header_admin.php'; ?>

<div class="container-xl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Quản lý Kho & Tồn kho</h2>
            <p class="text-muted mb-0">Theo dõi số lượng hàng tồn, cảnh báo hết hàng và quản lý nhập kho.</p>
        </div>
        <a href="index.php?controller=adminInventory&action=import" class="btn btn-success shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            + Tạo phiếu nhập hàng
        </a>
    </div>

    <!-- 4 THẺ THỐNG KÊ NHANH (CARDS) -->
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Tổng mặt hàng</div>
                            <div class="text-muted"><strong><?php echo $summary['total_products']; ?></strong> mã SP (<?php echo number_format($summary['total_stock']); ?> cái)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Còn hàng an toàn</div>
                            <div class="text-muted"><strong><?php echo $summary['in_stock']; ?></strong> sản phẩm (&ge; 10)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M12 17h.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Cảnh báo sắp hết</div>
                            <div class="text-muted"><strong><?php echo $summary['low_stock']; ?></strong> sản phẩm (&lt; 10)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-danger text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Đã hết hàng</div>
                            <div class="text-muted"><strong><?php echo $summary['out_of_stock']; ?></strong> sản phẩm (= 0)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DANH SÁCH TỒN KHO CÓ BỘ LỌC TRẠNG THÁI -->
    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-2">
            <h3 class="card-title mb-2 mb-md-0">Danh sách tồn kho (Sắp xếp theo ID cố định)</h3>
            
            <!-- Nút bấm lọc nhanh trạng thái -->
            <div class="btn-group" role="group">
                <a href="index.php?controller=adminInventory&action=index&filter=all" 
                   class="btn btn-sm <?php echo ($current_filter === 'all') ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                    Tất cả (<?php echo $summary['total_products']; ?>)
                </a>
                <a href="index.php?controller=adminInventory&action=index&filter=in_stock" 
                   class="btn btn-sm <?php echo ($current_filter === 'in_stock') ? 'btn-success' : 'btn-outline-success'; ?>">
                    Còn an toàn (<?php echo $summary['in_stock']; ?>)
                </a>
                <a href="index.php?controller=adminInventory&action=index&filter=low_stock" 
                   class="btn btn-sm <?php echo ($current_filter === 'low_stock') ? 'btn-warning' : 'btn-outline-warning'; ?>">
                    Sắp hết (&lt;10) (<?php echo $summary['low_stock']; ?>)
                </a>
                <a href="index.php?controller=adminInventory&action=index&filter=out_of_stock" 
                   class="btn btn-sm <?php echo ($current_filter === 'out_of_stock') ? 'btn-danger' : 'btn-outline-danger'; ?>">
                    Hết hàng (=0) (<?php echo $summary['out_of_stock']; ?>)
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter card-table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 80px;">Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá bán</th>
                        <th>Số lượng tồn</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Không có sản phẩm nào thuộc bộ lọc này.</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td><strong>#<?php echo $p['id']; ?></strong></td>
                            <td>
                                <?php if(!empty($p['image'])): ?>
                                    <img src="./assets/uploads/<?php echo $p['image']; ?>" 
                                         alt="Ảnh SP" width="55" height="55" style="object-fit: cover; border-radius: 6px">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
                            <td><?php echo number_format($p['price']); ?> đ</td>
                            <td>
                                <span class="badge px-2 py-1 <?php echo ($p['status_code'] === 'out_of_stock') ? 'bg-danger' : (($p['status_code'] === 'low_stock') ? 'bg-warning' : 'bg-success'); ?>" style="font-size: 0.95rem;">
                                    <?php echo $p['stock_quantity']; ?> cái
                                </span>
                            </td>
                            <td>
                                <?php if ($p['status_code'] === 'out_of_stock'): ?>
                                    <span class="text-danger fw-bold">&bull; Hết hàng</span>
                                <?php elseif ($p['status_code'] === 'low_stock'): ?>
                                    <span class="text-warning fw-bold">&bull; Cần nhập thêm</span>
                                <?php else: ?>
                                    <span class="text-success fw-bold">&bull; Ổn định</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="index.php?controller=adminInventory&action=import&product_id=<?php echo $p['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    + Nhập hàng
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- LỊCH SỬ PHIẾU NHẬP HÀNG -->
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Lịch sử phiếu nhập hàng (Chứng từ nhập kho)</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Mã phiếu</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng nhập</th>
                        <th>Giá nhập (đ)</th>
                        <th>Nhà cung cấp</th>
                        <th>Ghi chú</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($history)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-3">Chưa có lịch sử nhập hàng nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($history as $h): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border">#PN-<?php echo str_pad($h['id'], 4, '0', STR_PAD_LEFT); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($h['product_name']); ?></strong></td>
                            <td><span class="badge bg-blue text-white">+<?php echo $h['quantity']; ?></span></td>
                            <td><?php echo number_format($h['import_price']); ?> đ</td>
                            <td><?php echo htmlspecialchars($h['supplier']); ?></td>
                            <td class="text-muted"><?php echo htmlspecialchars($h['note'] ?? '-'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($h['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_admin.php'; ?>
