<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="py-4">
<div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($category['name']) ?></li>
        </ol>
    </nav>

    <h1 class="section-title mb-1"><?= htmlspecialchars($category['name']) ?></h1>
    <?php if (!empty($category['description'])): ?>
        <p class="text-muted mb-4"><?= htmlspecialchars($category['description']) ?></p>
    <?php endif; ?>

    <!-- Category pills -->
    <div class="mb-4">
        <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('shop/category/' . $cat['slug']) ?>"
               class="cat-pill <?= $cat['slug'] === $category['slug'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($bangles)): ?>
        <div class="text-center py-5">
            <i class="bi bi-gem" style="font-size:3rem; color:var(--brand-secondary);"></i>
            <p class="mt-3 text-muted">No bangles in this category yet.</p>
            <a href="<?= base_url() ?>" class="btn btn-outline-brand">Browse All</a>
        </div>
    <?php else: ?>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        <?php foreach ($bangles as $b): ?>
            <?php include(VIEWPATH . 'shop/_product_card.php'); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</section>
