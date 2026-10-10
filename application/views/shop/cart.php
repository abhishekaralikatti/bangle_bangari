<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="py-4">
<div class="container" style="max-width:760px;">
    <h1 class="section-title mb-4">Your Cart <i class="bi bi-bag-heart"></i></h1>

    <?php if (empty($cart)): ?>
        <div class="text-center py-5">
            <i class="bi bi-bag-x" style="font-size:4rem; color:var(--brand-secondary);"></i>
            <p class="mt-3 text-muted">Your cart is empty.</p>
            <a href="<?= base_url() ?>" class="btn btn-brand">Start Shopping</a>
        </div>
    <?php else: ?>
    <form action="<?= base_url('shop/update_cart') ?>" method="post" id="cart-form">
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <?php $total = 0; ?>
        <?php foreach ($cart as $id => $item): ?>
        <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
        <div class="card border-0 shadow-sm mb-3 rounded-3">
            <div class="card-body p-3">
                <div class="d-flex gap-3 align-items-center">
                    <!-- Thumbnail -->
                    <a href="<?= base_url('shop/product/' . $item['slug']) ?>">
                    <?php if (!empty($item['image']) && file_exists(FCPATH . 'assets/uploads/bangles/' . $item['image'])): ?>
                        <img src="<?= base_url('assets/uploads/bangles/' . $item['image']) ?>"
                             style="width:72px;height:72px;object-fit:cover;border-radius:10px;">
                    <?php else: ?>
                        <div style="width:72px;height:72px;background:var(--brand-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:2rem;">💍</div>
                    <?php endif; ?>
                    </a>
                    <!-- Info -->
                    <div class="flex-grow-1">
                        <a href="<?= base_url('shop/product/' . $item['slug']) ?>"
                           class="fw-bold text-dark text-decoration-none" style="font-size:.95rem;">
                            <?= htmlspecialchars($item['name']) ?>
                        </a>
                        <div class="mt-1 d-flex align-items-center gap-2 flex-wrap">
                            <span class="text-muted small">₹<?= number_format($item['price'], 0) ?> each</span>
                            <input type="number" name="quantity[<?= $id ?>]" value="<?= $item['quantity'] ?>"
                                   min="0" max="50"
                                   class="form-control form-control-sm text-center"
                                   style="width:60px;">
                        </div>
                    </div>
                    <!-- Subtotal + remove -->
                    <div class="text-end">
                        <div class="price fw-bold">₹<?= number_format($subtotal, 0) ?></div>
                        <a href="<?= base_url('shop/remove_from_cart/' . $id) ?>"
                           class="btn btn-sm btn-link text-danger p-0 mt-1">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Totals -->
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="price">₹<?= number_format($total, 0) ?></span>
                </div>
                <p class="text-muted small mb-0 mt-1">Shipping calculated at checkout</p>
            </div>
        </div>

        <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
            <button type="submit" class="btn btn-outline-brand">
                <i class="bi bi-arrow-repeat me-1"></i> Update Cart
            </button>
            <a href="<?= base_url('shop/checkout') ?>" class="btn btn-brand btn-lg">
                <i class="bi bi-lock me-1"></i> Checkout
            </a>
        </div>
    </form>
    <?php endif; ?>
</div>
</section>
