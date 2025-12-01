<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4 border-bottom pb-2">Tin tức mới nhất</h2>

            <?php if(empty($newsList)): ?>
                <div class="alert alert-info">Chưa có bài viết nào.</div>
            <?php else: ?>
                <?php foreach ($newsList as $news): ?>
                <div class="card mb-4 shadow-sm border-0">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="bg-light h-100 d-flex align-items-center justify-content-center overflow-hidden">
                                <img src="./assets/uploads/<?php echo $news['image'] ? $news['image'] : 'default_news.png'; ?>" 
                                     class="img-fluid rounded-start" 
                                     style="object-fit: cover; height: 100%; min-height: 200px; width: 100%;"
                                     alt="<?php echo $news['title']; ?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title fw-bold">
                                    <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo $news['title']; ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted mb-2">
                                    <small><i class="far fa-calendar-alt me-1"></i> <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></small>
                                </p>
                                <p class="card-text text-secondary">
                                    <?php echo substr(strip_tags($news['description']), 0, 150); ?>...
                                </p>
                                <div class="mt-auto text-end">
                                    <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-primary">Đọc tiếp &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php if(isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        
                        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post&page=<?php echo $currentPage - 1; ?>">Trước</a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post&page=<?php echo $currentPage + 1; ?>">Sau</a>
                        </li>

                    </ul>
                </nav>
                <?php endif; ?>
                <?php endif; ?>
        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>