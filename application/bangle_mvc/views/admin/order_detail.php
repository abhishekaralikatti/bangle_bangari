<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-3">
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> All Orders
    </a>
</div>

<div class="row g-3">
    <!-- Order info -->
    <div class="col-12 col-md-7">
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">#<?= $order['order_number'] ?></h5>
                        <span class="text-muted small"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></span>
                    </div>
                    <span class="badge badge-<?= $order['status'] ?> rounded-pill fs-6">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </div>

                <!-- Items -->
                <h6 class="fw-bold mb-2">Items Ordered</h6>
                <?php foreach ($items as $item): ?>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span><?= htmlspecialchars($item['bangle_name']) ?> × <?= $item['quantity'] ?></span>
                    <span class="fw-bold">₹<?= number_format($item['price'] * $item['quantity'], 0) ?></span>
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between pt-2 fw-bold fs-5">
                    <span>Total</span>
                    <span style="color:#b5206e;">₹<?= number_format($order['total_amount'],0) ?></span>
                </div>

                <?php if (!empty($order['notes'])): ?>
                    <div class="alert alert-light mt-3 mb-0">
                        <strong>Note:</strong> <?= htmlspecialchars($order['notes']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Customer + Update status -->
    <div class="col-12 col-md-5">
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Customer Details</h6>
                <p class="mb-1"><i class="bi bi-person me-2"></i><?= htmlspecialchars($order['customer_name']) ?></p>
                <p class="mb-1"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($order['customer_email']) ?></p>
                <p class="mb-1"><i class="bi bi-telephone me-2"></i><?= htmlspecialchars($order['customer_phone']) ?></p>
                <hr>
                <p class="mb-0 small">
                    <i class="bi bi-geo-alt me-2"></i>
                    <?= htmlspecialchars($order['address']) ?>,
                    <?= htmlspecialchars($order['city']) ?>,
                    <?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?>
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Update Order Status</h6>
                <form action="<?= base_url('admin/orders/status/'.$order['id']) ?>" method="post">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                    <select name="status" class="form-select mb-2">
                        <?php foreach (['pending','confirmed','shipped','delivered','cancelled'] as $s): ?>
                        <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                            <?= ucfirst($s) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn w-100 fw-bold" style="background:#b5206e;color:#fff;border-radius:50px;">
                        <i class="bi bi-save me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
