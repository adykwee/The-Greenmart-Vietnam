<footer class="site-footer mt-auto" style="background: var(--dark-green); color: #dbeee1; padding: 48px 0;">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="text-white fw-bold mb-3"><?php echo $settings['site_name'] ?? 'The Greenmart Vietnam'; ?></h5>
                <p class="small opacity-75">
                    Chúng tôi tin rằng thay đổi thói quen nhỏ hàng ngày có thể mang lại một tương lai bền vững. Sản phẩm được lựa chọn để giảm thiểu rác thải nhựa.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <h6 class="text-white mb-3">Liên kết nhanh</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="index.php" class="text-decoration-none text-light opacity-75">Trang chủ</a></li>
                    <li class="mb-2"><a href="index.php?controller=product" class="text-decoration-none text-light opacity-75">Cửa hàng</a></li>
                    <li class="mb-2"><a href="index.php?controller=post" class="text-decoration-none text-light opacity-75">Tin tức</a></li>
                    <li class="mb-2"><a href="index.php?controller=page&action=faq" class="text-decoration-none text-light opacity-75">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white mb-3">Liên hệ</h6>
                <ul class="list-unstyled small opacity-75">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> <?php echo $settings['contact_address'] ?? 'TP.HCM'; ?></li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> <?php echo $settings['contact_phone'] ?? '0123 456 789'; ?></li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo $settings['contact_email'] ?? 'info@greenmart.vn'; ?></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4 opacity-25">
        <div class="text-center small opacity-50">
            &copy; <span id="year"></span> The Greenmart Vietnam. All rights reserved.
        </div>
    </div>
</footer>

<script>document.getElementById('year').textContent = new Date().getFullYear();</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>