<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="py-4">
<div class="container">
    <h1 class="section-title mb-4">Checkout</h1>
    <div class="row g-4">
        <!-- Form -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Delivery Details</h5>

                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger"><?= validation_errors() ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('shop/checkout') ?>" method="post" novalidate>
                        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?= set_value('name', $customer['name'] ?? '') ?>"
                                   placeholder="Your name" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold">Email *</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= set_value('email', $customer['email'] ?? '') ?>"
                                       placeholder="you@email.com" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold">Phone *</label>
                                <input type="tel" name="phone" class="form-control"
                                       value="<?= set_value('phone', $customer['phone'] ?? '') ?>"
                                       placeholder="+91 98765 43210" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Street Address *</label>
                            <textarea name="address" class="form-control" rows="2"
                                      placeholder="House no, Street, Area" required><?= set_value('address') ?></textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">City *</label>
                                <input type="text" name="city" class="form-control"
                                       value="<?= set_value('city') ?>" placeholder="Mumbai" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">State *</label>
                                <input type="text" name="state" class="form-control"
                                       value="<?= set_value('state') ?>" placeholder="Maharashtra" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pincode *</label>
                            <input type="text" name="pincode" class="form-control"
                                   style="max-width:160px;" value="<?= set_value('pincode') ?>"
                                   placeholder="400001" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Order Notes <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Any special instructions"><?= set_value('notes') ?></textarea>
                        </div>

                        <div class="alert alert-info d-flex gap-2 align-items-start">
                            <i class="bi bi-info-circle-fill mt-1"></i>
                            <div class="small">
                                We accept <strong>Cash on Delivery</strong>, <strong>UPI</strong>, and
                                <strong>Bank Transfer</strong>. Our team will contact you to confirm payment.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-brand btn-lg">
                                <i class="bi bi-bag-check me-1"></i> Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order summary -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:80px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $item): ?>
                    <?php $sub = $item['price'] * $item['quantity']; $total += $sub; ?>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></span>
                        <span class="fw-bold">₹<?= number_format($sub, 0) ?></span>
                    </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span class="price fs-5">₹<?= number_format($total, 0) ?></span>
                    </div>
                    <p class="text-muted small mt-1">+ shipping (if applicable)</p>
                    <hr>
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <?php if ($this->session->userdata('customer_avatar')): ?>
                            <img src="<?= $this->session->userdata('customer_avatar') ?>"
                                 class="rounded-circle" width="24" height="24">
                        <?php else: ?>
                            <i class="bi bi-person-check-fill text-success"></i>
                        <?php endif; ?>
                        Ordering as <strong class="ms-1"><?= htmlspecialchars($this->session->userdata('customer_name')) ?></strong>
                        <a href="<?= base_url('auth/logout') ?>" class="ms-auto text-danger small">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
