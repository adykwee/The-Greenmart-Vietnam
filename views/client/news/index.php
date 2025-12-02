<?php include './views/layouts/header_client.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4 border-bottom pb-2">
                <?php echo ($keyword != '') ? "Kết quả tìm kiếm: \"$keyword\"" : "Tin tức mới nhất"; ?>
            </h2>

            <?php if(empty($newsList)): ?>
                <div class="alert alert-info">
                    Không tìm thấy bài viết nào với từ khóa "<strong><?php echo htmlspecialchars($keyword); ?></strong>".
                </div>
            <?php else: ?>
                
                <?php foreach ($newsList as $news): ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="./assets/uploads/<?php echo $news['image'] ? $news['image'] : 'default_news.png'; ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="text-decoration-none text-dark"><?php echo $news['title']; ?></a></h5>
                                    <p class="card-text text-muted"><?php echo substr(strip_tags($news['description']), 0, 150); ?>...</p>
                                    <a href="index.php?controller=post&action=detail&id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-primary">Đọc tiếp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if(isset($totalPages) && $totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        
                        <?php 
                            // Tạo chuỗi tham số keyword để tái sử dụng
                            $keyParam = ($keyword != '') ? "&keyword=" . urlencode($keyword) : ""; 
                        ?>

                        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $currentPage - 1; ?>">Trước</a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?controller=post<?php echo $keyParam; ?>&page=<?php echo $currentPage + 1; ?>">Sau</a>
                        </li>

                    </ul>
                </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">Tìm kiếm tin tức</div>
                <div class="card-body">
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="post">
                        <input type="hidden" name="action" value="index">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                   value="<?php echo htmlspecialchars($keyword); ?>" 
                                   placeholder="Nhập từ khóa...">
                            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            
            </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>