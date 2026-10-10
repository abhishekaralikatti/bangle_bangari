<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Stats row -->
<div class="row g-3 mb-4">
    <?php
    $stats = [
        ['Total Products',  $total_products,  'bi-gem',       '#b5206e', '#fce8f2'],
        ['Active Products', $active_products, 'bi-check-circle','#0d6efd','#e8f0ff'],
        ['Pending Orders',  $pending_orders,  'bi-clock',     '#e65100', '#fff3e0'],
        ['Total Revenue',   '₹'.number_format($total_revenue,0), 'bi-currency-rupee','#2e7d32','#e8f5e9'],
    ];
    foreach ($stats as [$label, $value, $icon, $color, $bg]):
    ?>
    <div class="col-6 col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon" style="background:<?= $bg ?>;color:<?= $color ?>;">
                    <i class="bi <?= $icon ?>"></i>
                </div>
                <div>
                    <div class="fw-800 fs-5 lh-1" style="font-weight:800;"><?= $value ?></div>
                    <div class="text-muted small"><?= $label ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($low_stock > 0): ?>
<div class="alert alert-warning d-flex align-items-center gap-2">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span><strong><?= $low_stock ?> product(s)</strong> have low stock (≤ 5 units).
        <a href="<?= base_url('admin/bangles') ?>">Review bangles →</a></span>
</div>
<?php endif; ?>

<!-- Quick actions -->
<div class="mb-4 d-flex gap-2 flex-wrap">
    <a href="<?= base_url('admin/bangles/add') ?>" class="btn btn-sm" style="background:#b5206e;color:#fff;border-radius:50px;font-weight:700;">
        <i class="bi bi-plus-lg me-1"></i> Add Bangle
    </a>
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius:50px;">
        <i class="bi bi-receipt me-1"></i> View Orders
    </a>
</div>

<!-- Recent orders -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Recent Orders</h5>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($recent_orders)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($recent_orders as $o): ?>
                    <tr>
                        <td><a href="<?= base_url('admin/orders/'.$o['id']) ?>">#<?= $o['order_number'] ?></a></td>
                        <td><?= htmlspecialchars($o['customer_name']) ?></td>
                        <td class="fw-bold" style="color:#b5206e;">₹<?= number_format($o['total_amount'],0) ?></td>
                        <td><span class="badge badge-<?= $o['status'] ?> rounded-pill"><?= ucfirst($o['status']) ?></span></td>
                        <td class="text-muted small"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
