<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="py-5">
<div class="container text-center" style="max-width:520px;">
    <div style="font-size:5rem;">🎉</div>
    <h1 class="font-serif mt-3 mb-2" style="color:var(--brand-primary);">Order Placed!</h1>
    <p class="lead mb-1">Thank you, <strong><?= htmlspecialchars($order['customer_name']) ?></strong>!</p>
    <p class="text-muted mb-4">
        Your order <strong>#<?= htmlspecialchars($order['order_number']) ?></strong> has been received.
        We'll contact you at <strong><?= htmlspecialchars($order['customer_email']) ?></strong>
        to confirm payment and shipping.
    </p>

    <div class="card border-0 shadow-sm rounded-3 mb-4 text-start">
        <div class="card-body p-3">
            <p class="mb-1 small"><strong>Deliver to:</strong></p>
            <p class="mb-0 text-muted small">
                <?= htmlspecialchars($order['address']) ?>,
                <?= htmlspecialchars($order['city']) ?>,
                <?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?>
            </p>
            <hr class="my-2">
            <div class="d-flex justify-content-between">
                <span class="small fw-bold">Order Total</span>
                <span class="price fw-bold">₹<?= number_format($order['total_amount'], 0) ?></span>
            </div>
        </div>
    </div>

    <a href="<?= base_url() ?>" class="btn btn-brand btn-lg w-100">
        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
    </a>

    <p class="mt-3 small text-muted">
        <i class="bi bi-whatsapp me-1 text-success"></i>
        Need help? WhatsApp us at <strong>+91 98765 43210</strong>
    </p>
</div>
</section>
