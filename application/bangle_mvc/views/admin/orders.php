<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="card border-0 shadow-sm rounded-3">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($orders)): ?>
        <tr><td colspan="7" class="text-center py-5 text-muted">No orders yet.</td></tr>
    <?php else: ?>
    <?php foreach ($orders as $o): ?>
        <tr>
            <td><a href="<?= base_url('admin/orders/'.$o['id']) ?>" class="fw-semibold">#<?= $o['order_number'] ?></a></td>
            <td>
                <?= htmlspecialchars($o['customer_name']) ?>
                <br><small class="text-muted"><?= htmlspecialchars($o['customer_email']) ?></small>
            </td>
            <td><?= htmlspecialchars($o['customer_phone']) ?></td>
            <td class="fw-bold" style="color:#b5206e;">₹<?= number_format($o['total_amount'],0) ?></td>
            <td><span class="badge badge-<?= $o['status'] ?> rounded-pill"><?= ucfirst($o['status']) ?></span></td>
            <td class="text-muted small"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
            <td>
                <a href="<?= base_url('admin/orders/'.$o['id']) ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>
</div>
