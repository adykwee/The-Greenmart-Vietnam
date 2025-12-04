<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Tin Tức</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">Tin Tức</li>
            </ol>
        </nav>
    </div>
</section>

<main class="container mb-5">
    <div class="row g-4">
        
        <div class="col-lg-8">
            <h5 class="fw-bold mb-4 border-bottom pb-2">
                <?php echo ($keyword != '') ? "KẾT QUẢ TÌM KIẾM \"$keyword\"" : "BÀI VIẾT MỚI NHẤT"; ?>
            </h5>

            <?php if(empty($newsList)): ?>
                <div class="alert alert-light text-center py-5 shadow-sm rounded-3">
                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                    <p class="mb-0">Không tìm thấy bài viết nào phù hợp với từ khóa "<strong><?php echo htmlspecialchars($keyword); ?></strong>".</p>
                </div>
            <?php else: ?>
                
                <?php foreach ($newsList as $news): ?>
                    <div class="card card-contact mb-4 p-3 d-flex flex-row overflow-hidden shadow-sm">
                        <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" style="flex-shrink: 0; width: 35%; max-width: 250px;">
                            <img src="./assets/uploads/<?php echo $news['image'] ? $news['image'] : 'default_news.png'; ?>" 
                                 class="rounded img-fluid h-100" 
                                 style="object-fit: cover; aspect-ratio: 4/3;">
                        </a>
                        <div class="card-body ps-4 py-1 d-flex flex-column">
                            <small class="text-muted mb-1"><i class="far fa-clock me-1"></i> Ngày đăng: <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></small>
                            <h5 class="card-title fw-bold">
                                <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="text-decoration-none text-dark hover-green">
                                    <?php echo $news['title']; ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small flex-grow-1">
                                <?php echo substr(strip_tags($news['description']), 0, 180); ?>...
                            </p>
                            <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-success align-self-start mt-2">Đọc tiếp</a>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if(isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php 
                            $keyParam = ($keyword != '') ? "&keyword=" . urlencode($keyword) : ""; 
                        ?>
                        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $currentPage - 1; ?>"><i class="fas fa-angle-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link <?php echo ($i == $currentPage) ? 'bg-success border-success text-white' : 'text-success'; ?>" 
                               href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $i; ?>">
                               <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $currentPage + 1; ?>"><i class="fas fa-angle-right"></i></a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 90px;">
                <div class="card card-contact p-4 mb-4">
                    <h6 class="fw-bold mb-3">Tìm kiếm</h6>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="post">
                        <input type="hidden" name="action" value="index">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                   value="<?php echo htmlspecialchars($keyword); ?>" 
                                   placeholder="Nhập từ khóa...">
                            <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include './views/layouts/footer_client.php'; ?>