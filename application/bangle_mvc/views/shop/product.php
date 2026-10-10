<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="py-4">
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <?php if (!empty($bangle['category_name'])): ?>
            <li class="breadcrumb-item">
                <a href="<?= base_url('shop/category/' . $bangle['category_slug']) ?>">
                    <?= htmlspecialchars($bangle['category_name']) ?>
                </a>
            </li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?= htmlspecialchars($bangle['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Image -->
        <div class="col-12 col-md-5">
            <?php if (!empty($bangle['image']) && file_exists(FCPATH . 'assets/uploads/bangles/' . $bangle['image'])): ?>
                <img src="<?= base_url('assets/uploads/bangles/' . $bangle['image']) ?>"
                     class="img-fluid rounded-4 w-100" style="max-height:400px;object-fit:cover;"
                     alt="<?= htmlspecialchars($bangle['name']) ?>">
            <?php else: ?>
                <div class="rounded-4 d-flex align-items-center justify-content-center bg-light"
                     style="height:320px;font-size:5rem;">💍</div>
            <?php endif; ?>
        </div>

        <!-- Details -->
        <div class="col-12 col-md-7">
            <?php if ($bangle['is_featured']): ?>
                <span class="badge badge-featured mb-2">✨ Featured</span>
            <?php endif; ?>

            <h1 class="h3 font-serif mb-1"><?= htmlspecialchars($bangle['name']) ?></h1>

            <?php if (!empty($bangle['category_name'])): ?>
                <p class="text-muted mb-3 small"><?= htmlspecialchars($bangle['category_name']) ?></p>
            <?php endif; ?>

            <div class="mb-3 d-flex align-items-baseline gap-2">
                <span class="price fs-3">₹<?= number_format($bangle['price'], 0) ?></span>
                <?php if (!empty($bangle['compare_price']) && $bangle['compare_price'] > $bangle['price']): ?>
                    <span class="compare-price fs-5">₹<?= number_format($bangle['compare_price'], 0) ?></span>
                    <?php
                    $disc = round((1 - $bangle['price']/$bangle['compare_price']) * 100);
                    echo "<span class='badge bg-success'>{$disc}% OFF</span>";
                    ?>
                <?php endif; ?>
            </div>

            <!-- Specs -->
            <ul class="list-group list-group-flush mb-3" style="font-size:.9rem;">
                <?php if (!empty($bangle['material'])): ?>
                    <li class="list-group-item px-0"><strong>Material:</strong> <?= htmlspecialchars($bangle['material']) ?></li>
                <?php endif; ?>
                <?php if (!empty($bangle['color'])): ?>
                    <li class="list-group-item px-0"><strong>Colour:</strong> <?= htmlspecialchars($bangle['color']) ?></li>
                <?php endif; ?>
                <?php if (!empty($bangle['size'])): ?>
                    <li class="list-group-item px-0"><strong>Size:</strong> <?= htmlspecialchars($bangle['size']) ?></li>
                <?php endif; ?>
                <li class="list-group-item px-0">
                    <strong>Availability:</strong>
                    <?php if ($bangle['stock'] > 0): ?>
                        <span class="text-success fw-bold">In Stock (<?= $bangle['stock'] ?> left)</span>
                    <?php else: ?>
                        <span class="text-danger fw-bold">Sold Out</span>
                    <?php endif; ?>
                </li>
            </ul>

            <?php if (!empty($bangle['description'])): ?>
                <p class="mb-4" style="font-size:.95rem;"><?= nl2br(htmlspecialchars($bangle['description'])) ?></p>
            <?php endif; ?>

            <?php if ($bangle['stock'] > 0): ?>
            <form action="<?= base_url('shop/add_to_cart') ?>" method="post" class="d-flex gap-2 align-items-center">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <input type="hidden" name="bangle_id" value="<?= $bangle['id'] ?>">
                <div style="max-width:100px;">
                    <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $bangle['stock'] ?>">
                </div>
                <button type="submit" class="btn btn-brand btn-lg flex-grow-1">
                    <i class="bi bi-bag-plus me-1"></i> Add to Cart
                </button>
            </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg w-100" disabled>Sold Out</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Related products -->
    <?php if (!empty($related)): ?>
    <hr class="my-5">
    <h2 class="section-title mb-4">You Might Also Like</h2>
    <div class="row row-cols-2 row-cols-md-4 g-3">
        <?php foreach ($related as $b):
            if ($b['id'] == $bangle['id']) continue; ?>
            <?php include(VIEWPATH . 'shop/_product_card.php'); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</section>
