<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ── Hero ──────────────────────────────────────────────── -->
<section class="hero text-center">
    <div class="container">
        <p class="text-uppercase fw-bold small ls-wide mb-1" style="color:var(--brand-gold); letter-spacing:.12em;">New Arrivals &amp; Bestsellers</p>
        <h1 class="mb-3">Beautiful Bangles,<br><span style="color:var(--brand-primary);">Crafted with Love</span></h1>
        <p class="lead mb-4" style="max-width:520px; margin:0 auto; opacity:.8;">
            From vibrant glass sets to elegant bridal collections — find the perfect bangles for every occasion.
        </p>
        <a href="#all-bangles" class="btn btn-brand btn-lg me-2">
            <i class="bi bi-bag-heart me-1"></i> Shop Now
        </a>
        <a href="#categories" class="btn btn-outline-brand btn-lg">Browse Categories</a>
    </div>
</section>

<!-- ── Categories ────────────────────────────────────────── -->
<section id="categories" class="py-4 bg-white">
    <div class="container">
        <div class="text-center mb-3">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= base_url('shop/category/' . $cat['slug']) ?>" class="cat-pill">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Featured Bangles ───────────────────────────────────── -->
<?php if (!empty($featured)): ?>
<section class="py-4" style="background:var(--brand-light);">
    <div class="container">
        <h2 class="section-title mb-4">Featured Picks ✨</h2>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            <?php foreach ($featured as $b): ?>
                <?php include(VIEWPATH . 'shop/_product_card.php'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── All Bangles ────────────────────────────────────────── -->
<section id="all-bangles" class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">All Bangles 💍</h2>
        <?php if (empty($all_bangles)): ?>
            <div class="text-center py-5">
                <i class="bi bi-gem" style="font-size:3rem; color:var(--brand-secondary);"></i>
                <p class="mt-3 text-muted">No bangles listed yet. Check back soon!</p>
            </div>
        <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            <?php foreach ($all_bangles as $b): ?>
                <?php include(VIEWPATH . 'shop/_product_card.php'); ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ── Why shop with us ───────────────────────────────────── -->
<section class="py-5" style="background:var(--brand-light);">
    <div class="container">
        <div class="row row-cols-2 row-cols-md-4 g-3 text-center">
            <?php
            $perks = [
                ['bi-gem',        'Handpicked Quality',   'Every piece personally selected'],
                ['bi-truck',      'Pan-India Shipping',   'Delivered to your doorstep'],
                ['bi-patch-check','Genuine Products',      '100% authentic materials'],
                ['bi-headset',    'Personal Support',     'WhatsApp us anytime'],
            ];
            foreach ($perks as [$icon, $title, $desc]):
            ?>
            <div class="col">
                <i class="bi bi-<?= $icon ?>" style="font-size:2rem; color:var(--brand-primary);"></i>
                <p class="fw-bold mb-1 mt-2 small"><?= $title ?></p>
                <p class="text-muted" style="font-size:.8rem;"><?= $desc ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
