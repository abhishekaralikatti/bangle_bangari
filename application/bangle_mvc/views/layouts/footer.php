
<!-- ── Footer ──────────────────────────────────────────────── -->
<footer class="mt-5 py-4">
    <div class="container">
        <div class="row gy-3">
            <div class="col-12 col-md-4">
                <div class="mb-2" style="font-family:'Playfair Display',serif; font-size:1.3rem; color:#fff;">
                    💍 Bangle Bangari
                </div>
                <p class="small mb-0" style="color:#c9a3b5;">
                    Handpicked bangles for every occasion — from everyday wear to bridal sets.
                    Started with love by a home artisan.
                </p>
            </div>
            <div class="col-6 col-md-2">
                <p class="fw-bold text-white mb-2">Shop</p>
                <ul class="list-unstyled small">
                    <li><a href="<?= base_url() ?>">All Bangles</a></li>
                    <li><a href="<?= base_url('shop/cart') ?>">My Cart</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <p class="fw-bold text-white mb-2">Contact</p>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-whatsapp me-1"></i> +91 98765 43210</li>
                    <li><i class="bi bi-envelope me-1"></i> hello@banglesandbeyond.in</li>
                </ul>
            </div>
            <div class="col-12 col-md-3">
                <p class="fw-bold text-white mb-2">We Accept</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-secondary">UPI</span>
                    <span class="badge bg-secondary">Cash on Delivery</span>
                    <span class="badge bg-secondary">Bank Transfer</span>
                </div>
            </div>
        </div>
        <hr style="border-color:#4a2040; margin:1.2rem 0 .8rem;">
        <p class="text-center small mb-0" style="color:#8a6070;">
            &copy; <?= date('Y') ?> Bangle Bangari. Made with ❤️ &nbsp;|&nbsp;
            <a href="<?= base_url('admin/login') ?>">Admin</a>
        </p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-dismiss flash alerts
    setTimeout(() => {
        document.querySelectorAll('.flash-wrapper .alert').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 4000);
</script>
</body>
</html>
