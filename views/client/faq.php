<?php include './views/layouts/header_client.php'; ?>

<section class="page-header-block text-center">
    <div class="container">
        <h1 class="fw-bold h3 mb-2">Câu Hỏi Thường Gặp</h1>
        <p class="text-muted">Giải đáp các thắc mắc về sản phẩm và dịch vụ của The Greenmart Vietnam</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <?php if(empty($faqs)): ?>
                <div class="alert alert-info text-center">Hiện chưa có câu hỏi nào.</div>
            <?php else: ?>
                <div class="accordion" id="accordionFAQ">
                    <?php foreach($faqs as $index => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $faq['id']; ?>">
                                <button class="accordion-button <?php echo ($index == 0) ? '' : 'collapsed'; ?>" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse<?php echo $faq['id']; ?>" 
                                        aria-expanded="<?php echo ($index == 0) ? 'true' : 'false'; ?>" 
                                        aria-controls="collapse<?php echo $faq['id']; ?>">
                                    <strong class="me-2">#<?php echo $index + 1; ?></strong> 
                                    <?php echo htmlspecialchars($faq['question']); ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $faq['id']; ?>" 
                                 class="accordion-collapse collapse <?php echo ($index == 0) ? 'show' : ''; ?>" 
                                 aria-labelledby="heading<?php echo $faq['id']; ?>" 
                                 data-bs-parent="#accordionFAQ">
                                <div class="accordion-body text-muted">
                                    <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mt-5 text-center">
                <p>Bạn không tìm thấy câu trả lời?</p>
                <a href="index.php?controller=contact" class="btn btn-outline-primary">Liên hệ trực tiếp với chúng tôi</a>
            </div>

        </div>
    </div>
</div>

<?php include './views/layouts/footer_client.php'; ?>