<?php // Partial: _product_card.php   — expects $b (bangle row array) ?>
<div class="col">
    <div class="card product-card h-100">
        <a href="<?= base_url('shop/product/' . $b['slug']) ?>" class="text-decoration-none">
            <?php if (!empty($b['image']) && file_exists(FCPATH . 'assets/uploads/bangles/' . $b['image'])): ?>
                <img src="<?= base_url('assets/uploads/bangles/' . $b['image']) ?>"
                     class="card-img-top" alt="<?= htmlspecialchars($b['name']) ?>">
            <?php else: ?>
                <div class="img-placeholder">💍</div>
            <?php endif; ?>
        </a>
        <div class="card-body d-flex flex-column p-3">
            <?php if ($b['is_featured']): ?>
                <span class="badge badge-featured mb-1 align-self-start">✨ Featured</span>
            <?php endif; ?>
            <a href="<?= base_url('shop/product/' . $b['slug']) ?>" class="text-decoration-none text-dark">
                <h6 class="card-title mb-1 fw-bold" style="font-size:.92rem; line-height:1.3;">
                    <?= htmlspecialchars($b['name']) ?>
                </h6>
            </a>
            <?php if (!empty($b['color'])): ?>
                <small class="text-muted mb-2"><?= htmlspecialchars($b['color']) ?></small>
            <?php endif; ?>
            <div class="mt-auto d-flex align-items-center justify-content-between gap-1 flex-wrap">
                <div>
                    <span class="price">₹<?= number_format($b['price'], 0) ?></span>
                    <?php if (!empty($b['compare_price']) && $b['compare_price'] > $b['price']): ?>
                        <span class="compare-price ms-1">₹<?= number_format($b['compare_price'], 0) ?></span>
                    <?php endif; ?>
                </div>
                <?php if ($b['stock'] > 0): ?>
                    <form action="<?= base_url('shop/add_to_cart') ?>" method="post" class="d-inline">
                        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                        <input type="hidden" name="bangle_id" value="<?= $b['id'] ?>">
                        <input type="hidden" name="quantity"  value="1">
                        <button type="submit" class="btn btn-brand btn-sm" title="Add to cart">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <span class="badge bg-danger">Sold Out</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
