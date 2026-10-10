<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Bangle Store' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #b5206e;
            /* deep rose */
            --brand-secondary: #f7c5d5;
            /* petal pink */
            --brand-gold: #c9963a;
            /* gold accent */
            --brand-dark: #2b1325;
            /* aubergine text */
            --brand-light: #fdf4f7;
            /* blush bg */
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            color: var(--brand-dark);
            background: #fff;
        }

        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* ── Navbar ─────────────────────────────── */
        .navbar-brand .brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--brand-primary);
        }

        .navbar {
            background: #fff;
            border-bottom: 2px solid var(--brand-secondary);
        }

        .navbar .nav-link {
            color: var(--brand-dark) !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover {
            color: var(--brand-primary) !important;
        }

        .cart-badge {
            background: var(--brand-primary);
        }

        /* ── Buttons ────────────────────────────── */
        .btn-brand {
            background: var(--brand-primary);
            color: #fff;
            border: none;
            font-weight: 700;
            border-radius: 50px;
            padding: .5rem 1.5rem;
        }

        .btn-brand:hover {
            background: #8f1554;
            color: #fff;
        }

        .btn-outline-brand {
            border: 2px solid var(--brand-primary);
            color: var(--brand-primary);
            font-weight: 700;
            border-radius: 50px;
            padding: .45rem 1.4rem;
            background: transparent;
        }

        .btn-outline-brand:hover {
            background: var(--brand-primary);
            color: #fff;
        }

        /* ── Product cards ──────────────────────── */
        .product-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(181, 32, 110, .09);
            transition: transform .22s, box-shadow .22s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(181, 32, 110, .18);
        }

        .product-card .card-img-top {
            height: 210px;
            object-fit: cover;
            background: var(--brand-light);
        }

        .product-card .price {
            color: var(--brand-primary);
            font-weight: 700;
            font-size: 1.15rem;
        }

        .product-card .compare-price {
            text-decoration: line-through;
            color: #aaa;
            font-size: .9rem;
        }

        .badge-featured {
            background: var(--brand-gold);
            color: #fff;
            font-size: .73rem;
        }

        /* ── Hero ───────────────────────────────── */
        .hero {
            background: linear-gradient(135deg, var(--brand-light) 0%, #ffe4ef 100%);
            padding: 3.5rem 0 2.5rem;
        }

        .hero h1 {
            font-size: clamp(1.8rem, 5vw, 3rem);
        }

        /* ── Section titles ─────────────────────── */
        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--brand-dark);
        }

        .section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--brand-primary);
            margin: .4rem 0 0;
        }

        /* ── Category pills ─────────────────────── */
        .cat-pill {
            display: inline-block;
            padding: .35rem 1rem;
            border-radius: 50px;
            border: 1.5px solid var(--brand-secondary);
            color: var(--brand-dark);
            font-weight: 600;
            font-size: .88rem;
            transition: all .18s;
            text-decoration: none;
            margin: .2rem;
        }

        .cat-pill:hover,
        .cat-pill.active {
            background: var(--brand-primary);
            color: #fff;
            border-color: var(--brand-primary);
        }

        /* ── No-image placeholder ───────────────── */
        .img-placeholder {
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brand-light);
            color: var(--brand-secondary);
            font-size: 3rem;
        }

        /* ── Footer ─────────────────────────────── */
        footer {
            background: var(--brand-dark);
            color: #e8ccd7;
        }

        footer a {
            color: var(--brand-secondary);
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* ── Flash messages ─────────────────────── */
        .flash-wrapper {
            position: fixed;
            top: 70px;
            right: 16px;
            z-index: 9999;
            min-width: 280px;
        }

        /* ── Cart floating badge ────────────────── */
        .cart-count {
            position: relative;
        }

        .cart-count .badge {
            position: absolute;
            top: -8px;
            right: -10px;
            font-size: .65rem;
        }

        @media (max-width:576px) {
            .product-card .card-img-top {
                height: 170px;
            }

            .hero {
                padding: 2rem 0 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- ── Navbar ──────────────────────────────────────────── -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
                <span style="font-size:1.6rem;">💍</span>
                <span class="brand-text">Bangle Bangari</span>
            </a>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <!-- Cart icon (mobile) -->
                <a href="<?= base_url('shop/cart') ?>" class="btn btn-brand btn-sm cart-count d-lg-none">
                    <i class="bi bi-bag-heart-fill"></i>
                    <?php
                    $cart = $this->session->userdata('cart') ?? [];
                    $cart_qty = array_sum(array_column($cart, 'quantity'));
                    if ($cart_qty > 0): ?>
                        <span class="badge bg-white text-danger"><?= $cart_qty ?></span>
                    <?php endif; ?>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="mainNav">
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
                            <?php endforeach;
                            endif; ?>
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
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('account/orders') ?>">
                                <i class="bi bi-receipt me-2"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
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
            </div>
        </div>
    </nav>

    <!-- Flash messages -->
    <div class="flash-wrapper">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>