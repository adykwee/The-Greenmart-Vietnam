<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block mb-4">
    <div class="container">
        <h1 class="fw-bold h3 mb-0" style="color: #042a1b;">Tin Tức</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?controller=post&action=index" class="text-decoration-none text-muted">Tin Tức</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page"><?php echo $post['title']; ?></li>
            </ol>
        </nav>
    </div>
</section>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <article>
                <h1 class="fw-bold"><?php echo $post['title']; ?></h1>
                <p class="text-muted"><i class="bi bi-clock"></i> <?php echo $post['created_at']; ?></p>
                
                <?php if($post['image']): ?>
                    <img src="./assets/uploads/<?php echo $post['image']; ?>" class="img-fluid rounded mb-3 w-100">
                <?php endif; ?>

                <div class="content">
                    <?php echo nl2br($post['content']); ?>
                </div>
            </article>

            <hr>

            <div class="comments-section mt-5">
                <h4>Bình luận (<?php echo count($comments); ?>)</h4>
                
                <?php if(isset($_SESSION['user'])): ?>
                    <form action="index.php?controller=post&action=comment" method="POST" class="mb-4">
                        <input type="hidden" name="news_id" value="<?php echo $post['id']; ?>">
                        <div class="d-flex">
                            <img src="./assets/uploads/default.png" class="rounded-circle me-3" width="50" height="50">
                            <div class="w-100">
                                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-secondary">
                        <a href="index.php?controller=auth&action=login">Đăng nhập</a> để tham gia bình luận.
                    </div>
                <?php endif; ?>

                <div class="comment-list">
                    <?php foreach($comments as $cmt): ?>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="./assets/uploads/default.png" class="rounded-circle" width="50" height="50">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold mb-0"><?php echo $cmt['full_name']; ?></h6>
                                <small class="text-muted"><?php echo $cmt['created_at']; ?></small>
                                
                                <p class="mt-1">
                                    <?php echo htmlspecialchars($cmt['content']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>