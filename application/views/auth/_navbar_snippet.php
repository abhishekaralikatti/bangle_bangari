{{-- PASTE THIS INTO layouts/header.php --}}
{{-- Replace the <ul class="navbar-nav ..."> block with this --}}

<ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 mt-2 mt-lg-0">
    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
        <ul class="dropdown-menu">
            <?php if (!empty($categories)): foreach ($categories as $cat): ?>
            <li>
                <a class="dropdown-item" href="<?= base_url('shop/category/' . $cat['slug']) ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            </li>
            <?php endforeach; endif; ?>
        </ul>
    </li>

    <!-- Cart -->
    <li class="nav-item d-none d-lg-block">
        <a href="<?= base_url('shop/cart') ?>" class="btn btn-brand btn-sm cart-count">
            <i class="bi bi-bag-heart-fill"></i> Cart
            <?php if ($cart_qty > 0): ?>
                <span class="badge bg-white text-danger"><?= $cart_qty ?></span>
            <?php endif; ?>
        </a>
    </li>

    <!-- ── Customer account area (NEW) ── -->
    <?php if ($this->session->userdata('customer_id')): ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
            <?php if ($this->session->userdata('customer_avatar')): ?>
                <img src="<?= $this->session->userdata('customer_avatar') ?>"
                     class="rounded-circle" width="28" height="28" style="object-fit:cover;">
            <?php else: ?>
                <i class="bi bi-person-circle fs-5"></i>
            <?php endif; ?>
            <span class="d-none d-lg-inline"><?= htmlspecialchars(explode(' ', $this->session->userdata('customer_name'))[0]) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text text-muted small"><?= htmlspecialchars($this->session->userdata('customer_email')) ?></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a></li>
        </ul>
    </li>
    <?php else: ?>
    <li class="nav-item">
        <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-brand btn-sm" style="border-radius:50px;">
            <i class="bi bi-person me-1"></i> Login
        </a>
    </li>
    <?php endif; ?>
    <!-- ── End account area ── -->

</ul>
