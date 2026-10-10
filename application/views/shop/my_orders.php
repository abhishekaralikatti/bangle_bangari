<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="py-4">
<div class="container" style="max-width:820px;">

    <!-- Page header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <?php if ($this->session->userdata('customer_avatar')): ?>
            <img src="<?= $this->session->userdata('customer_avatar') ?>"
                 class="rounded-circle" width="52" height="52" style="object-fit:cover;border:3px solid var(--brand-secondary);">
        <?php else: ?>
            <div style="width:52px;height:52px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center;font-size:1.6rem;border:3px solid var(--brand-secondary);">
                👤
            </div>
        <?php endif; ?>
        <div>
            <h4 class="mb-0 font-serif" style="color:var(--brand-primary);">
                <?= htmlspecialchars($customer['name']) ?>
            </h4>
            <small class="text-muted"><?= htmlspecialchars($customer['email']) ?></small>
        </div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-outline-secondary ms-auto" style="border-radius:50px;">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>

    <h5 class="section-title mb-4">My Orders</h5>

    <?php if (empty($orders)): ?>
        <!-- Empty state -->
        <div class="text-center py-5">
            <div style="font-size:4rem;">🛍️</div>
            <h5 class="mt-3 font-serif">No orders yet</h5>
            <p class="text-muted">You haven't placed any orders. Start shopping!</p>
            <a href="<?= base_url() ?>" class="btn btn-brand mt-1">
                <i class="bi bi-bag-heart me-1"></i> Browse Bangles
            </a>
        </div>

    <?php else: ?>

        <!-- Order cards -->
        <?php foreach ($orders as $order): ?>
        <?php
            $status_map = [
                'pending'   => ['bg' => '#fff3e0', 'color' => '#e65100', 'icon' => 'bi-clock',              'label' => 'Order Placed'],
                'confirmed' => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'icon' => 'bi-check-circle',       'label' => 'Confirmed'],
                'shipped'   => ['bg' => '#f3e5f5', 'color' => '#6a1b9a', 'icon' => 'bi-truck',              'label' => 'Shipped'],
                'delivered' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'icon' => 'bi-bag-check',          'label' => 'Delivered'],
                'cancelled' => ['bg' => '#fce4ec', 'color' => '#c62828', 'icon' => 'bi-x-circle',           'label' => 'Cancelled'],
            ];
            $s = $status_map[$order['status']] ?? $status_map['pending'];
        ?>
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-0">

                <!-- Order top bar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 px-4 pt-3 pb-2"
                     style="border-bottom:1px solid #f0e6eb;">
                    <div>
                        <span class="fw-bold" style="color:var(--brand-primary);">#<?= $order['order_number'] ?></span>
                        <span class="text-muted small ms-2">
                            <?= date('d M Y', strtotime($order['created_at'])) ?>
                        </span>
                    </div>
                    <span class="badge rounded-pill px-3 py-2"
                          style="background:<?= $s['bg'] ?>;color:<?= $s['color'] ?>;font-size:.82rem;">
                        <i class="bi <?= $s['icon'] ?> me-1"></i><?= $s['label'] ?>
                    </span>
                </div>

                <!-- Progress tracker -->
                <?php if ($order['status'] !== 'cancelled'): ?>
                <?php
                    $steps  = ['pending','confirmed','shipped','delivered'];
                    $active = array_search($order['status'], $steps);
                ?>
                <div class="px-4 py-3" style="border-bottom:1px solid #f0e6eb;">
                    <div class="d-flex align-items-center">
                    <?php foreach ($steps as $i => $step):
                        $done    = $i <= $active;
                        $current = $i === $active;
                        $labels  = ['Placed','Confirmed','Shipped','Delivered'];
                    ?>
                        <div class="d-flex flex-column align-items-center" style="flex:1;min-width:0;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:32px;height:32px;
                                        background:<?= $done ? 'var(--brand-primary)' : '#e8dce5' ?>;
                                        color:<?= $done ? '#fff' : '#aaa' ?>;
                                        font-size:.85rem;
                                        box-shadow:<?= $current ? '0 0 0 4px rgba(181,32,110,.2)' : 'none' ?>;">
                                <?php if ($done && !$current): ?>
                                    <i class="bi bi-check-lg"></i>
                                <?php elseif ($current): ?>
                                    <i class="bi bi-circle-fill" style="font-size:.5rem;"></i>
                                <?php else: ?>
                                    <i class="bi bi-circle" style="font-size:.5rem;"></i>
                                <?php endif; ?>
                            </div>
                            <span class="mt-1 text-center" style="font-size:.68rem;color:<?= $done ? 'var(--brand-primary)' : '#aaa' ?>;font-weight:<?= $current ? '700' : '500' ?>;line-height:1.2;max-width:56px;">
                                <?= $labels[$i] ?>
                            </span>
                        </div>
                        <?php if ($i < count($steps)-1): ?>
                        <div style="flex:1;height:2px;background:<?= ($i < $active) ? 'var(--brand-primary)' : '#e8dce5' ?>;margin-bottom:18px;"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Order meta -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 px-4 py-3">
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt me-1"></i>
                        <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['state']) ?>
                    </div>
                    <div class="fw-bold fs-5" style="color:var(--brand-primary);">
                        ₹<?= number_format($order['total_amount'], 0) ?>
                    </div>
                    <a href="<?= base_url('account/order/' . $order['id']) ?>"
                       class="btn btn-sm btn-outline-brand">
                        View Details <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

            </div>
        </div>
        <?php endforeach; ?>

    <?php endif; ?>

</div>
</section>
