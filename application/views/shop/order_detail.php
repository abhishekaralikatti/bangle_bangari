<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$status_map = [
    'pending'   => ['bg' => '#fff3e0', 'color' => '#e65100', 'icon' => 'bi-clock',         'label' => 'Order Placed'],
    'confirmed' => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'icon' => 'bi-check-circle',  'label' => 'Confirmed'],
    'shipped'   => ['bg' => '#f3e5f5', 'color' => '#6a1b9a', 'icon' => 'bi-truck',         'label' => 'Shipped'],
    'delivered' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'icon' => 'bi-bag-check',     'label' => 'Delivered'],
    'cancelled' => ['bg' => '#fce4ec', 'color' => '#c62828', 'icon' => 'bi-x-circle',      'label' => 'Cancelled'],
];
$s = $status_map[$order['status']] ?? $status_map['pending'];
?>

<section class="py-4">
<div class="container" style="max-width:720px;">

    <!-- Back -->
    <a href="<?= base_url('account/orders') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius:50px;">
        <i class="bi bi-arrow-left me-1"></i> My Orders
    </a>

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-4">
        <div>
            <h4 class="font-serif mb-1" style="color:var(--brand-primary);">
                Order #<?= $order['order_number'] ?>
            </h4>
            <span class="text-muted small">
                Placed on <?= date('d M Y, h:i A', strtotime($order['created_at'])) ?>
            </span>
        </div>
        <span class="badge rounded-pill px-3 py-2"
              style="background:<?= $s['bg'] ?>;color:<?= $s['color'] ?>;font-size:.88rem;">
            <i class="bi <?= $s['icon'] ?> me-1"></i> <?= $s['label'] ?>
        </span>
    </div>

    <!-- Progress tracker (not for cancelled) -->
    <?php if ($order['status'] !== 'cancelled'): ?>
    <?php
        $steps  = ['pending','confirmed','shipped','delivered'];
        $active = array_search($order['status'], $steps);
        $step_info = [
            ['Placed',    'Your order has been received.',                     'bi-bag-check'],
            ['Confirmed', 'We have confirmed your order and preparing it.',    'bi-check-circle'],
            ['Shipped',   'Your bangles are on the way!',                     'bi-truck'],
            ['Delivered', 'Your order has been delivered. Enjoy! 💍',         'bi-house-check'],
        ];
    ?>
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-4">Order Progress</h6>

            <!-- Horizontal stepper -->
            <div class="d-flex align-items-center mb-4">
            <?php foreach ($steps as $i => $step):
                $done    = $i <= $active;
                $current = $i === $active;
                $labels  = ['Placed','Confirmed','Shipped','Delivered'];
            ?>
                <div class="d-flex flex-column align-items-center" style="flex:1;min-width:0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:38px;height:38px;
                                background:<?= $done ? 'var(--brand-primary)' : '#f0e6eb' ?>;
                                color:<?= $done ? '#fff' : '#bbb' ?>;
                                font-size:.95rem;
                                box-shadow:<?= $current ? '0 0 0 5px rgba(181,32,110,.18)' : 'none' ?>;">
                        <?php if ($done && !$current): ?>
                            <i class="bi bi-check-lg"></i>
                        <?php else: ?>
                            <i class="bi <?= $step_info[$i][2] ?>"></i>
                        <?php endif; ?>
                    </div>
                    <span class="mt-1 text-center"
                          style="font-size:.72rem;
                                 color:<?= $done ? 'var(--brand-primary)' : '#bbb' ?>;
                                 font-weight:<?= $current ? '800' : '500' ?>;
                                 line-height:1.2;max-width:64px;">
                        <?= $labels[$i] ?>
                    </span>
                </div>
                <?php if ($i < count($steps)-1): ?>
                <div style="flex:1;height:2px;margin-bottom:20px;
                            background:<?= ($i < $active) ? 'var(--brand-primary)' : '#f0e6eb' ?>;"></div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>

            <!-- Current status message -->
            <div class="rounded-3 p-3 d-flex gap-3 align-items-start"
                 style="background:<?= $s['bg'] ?>;">
                <i class="bi <?= $s['icon'] ?> fs-4 mt-1" style="color:<?= $s['color'] ?>;"></i>
                <div>
                    <div class="fw-bold" style="color:<?= $s['color'] ?>;"><?= $s['label'] ?></div>
                    <div class="small mt-1" style="color:<?= $s['color'] ?>;opacity:.85;">
                        <?= $step_info[$active][1] ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php elseif ($order['status'] === 'cancelled'): ?>
    <div class="alert d-flex gap-2 align-items-center mb-4"
         style="background:#fce4ec;color:#c62828;border:none;border-radius:12px;">
        <i class="bi bi-x-circle-fill fs-4"></i>
        <div>
            <div class="fw-bold">Order Cancelled</div>
            <div class="small">This order was cancelled. Contact us if you need help.</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Items ordered -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Items Ordered</h6>

            <?php foreach ($items as $item): ?>
            <div class="d-flex gap-3 align-items-center py-2" style="border-bottom:1px solid #f5eef2;">
                <!-- Product image -->
                <a href="<?= base_url('shop/product/' . ($item['bangle_slug'] ?? '')) ?>">
                <?php if (!empty($item['bangle_image']) && file_exists(FCPATH . 'assets/uploads/bangles/' . $item['bangle_image'])): ?>
                    <img src="<?= base_url('assets/uploads/bangles/' . $item['bangle_image']) ?>"
                         style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                <?php else: ?>
                    <div style="width:60px;height:60px;background:var(--brand-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;">💍</div>
                <?php endif; ?>
                </a>
                <!-- Name & qty -->
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="font-size:.95rem;">
                        <?= htmlspecialchars($item['bangle_name']) ?>
                    </div>
                    <div class="text-muted small">Qty: <?= $item['quantity'] ?> × ₹<?= number_format($item['price'], 0) ?></div>
                </div>
                <!-- Subtotal -->
                <div class="fw-bold" style="color:var(--brand-primary);">
                    ₹<?= number_format($item['price'] * $item['quantity'], 0) ?>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Total -->
            <div class="d-flex justify-content-between align-items-center pt-3">
                <span class="fw-bold">Order Total</span>
                <span class="fw-bold fs-5" style="color:var(--brand-primary);">
                    ₹<?= number_format($order['total_amount'], 0) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Delivery info -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Delivery Details</h6>
            <div class="row g-2 small">
                <div class="col-5 text-muted">Name</div>
                <div class="col-7 fw-semibold"><?= htmlspecialchars($order['customer_name']) ?></div>

                <div class="col-5 text-muted">Phone</div>
                <div class="col-7"><?= htmlspecialchars($order['customer_phone']) ?></div>

                <div class="col-5 text-muted">Email</div>
                <div class="col-7"><?= htmlspecialchars($order['customer_email']) ?></div>

                <div class="col-5 text-muted">Address</div>
                <div class="col-7">
                    <?= htmlspecialchars($order['address']) ?>,
                    <?= htmlspecialchars($order['city']) ?>,
                    <?= htmlspecialchars($order['state']) ?> – <?= htmlspecialchars($order['pincode']) ?>
                </div>

                <?php if (!empty($order['notes'])): ?>
                <div class="col-5 text-muted">Notes</div>
                <div class="col-7 fst-italic"><?= htmlspecialchars($order['notes']) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Help -->
    <div class="text-center py-2">
        <p class="text-muted small mb-2">Need help with this order?</p>
        <a href="https://wa.me/919876543210?text=Hi!+I+need+help+with+order+%23<?= $order['order_number'] ?>"
           target="_blank"
           class="btn btn-sm btn-success" style="border-radius:50px;">
            <i class="bi bi-whatsapp me-1"></i> WhatsApp Us
        </a>
    </div>

</div>
</section>
