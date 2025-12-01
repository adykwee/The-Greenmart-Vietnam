<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Về Chúng Tôi</h5>
                <p>Chúng tôi cung cấp các sản phẩm công nghệ hàng đầu với giá cả cạnh tranh nhất thị trường.</p>
            </div>
            <div class="col-md-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php?controller=page&action=faq" class="text-white text-decoration-none">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Liên Hệ</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i> 
                    <?php echo $settings['contact_address'] ?? 'Đang cập nhật địa chỉ'; ?>
                </p>
                <p><i class="fas fa-phone me-2"></i> 
                    <?php echo $settings['contact_phone'] ?? 'Processing...'; ?>
                </p>
                <p><i class="fas fa-envelope me-2"></i> 
                    <?php echo $settings['contact_email'] ?? 'support@example.com'; ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <small>&copy; 2025 Tech Store. All rights reserved.</small>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>