<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Admin' ?> – Bangle Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --adm-primary: #b5206e;
            --adm-dark:    #1f1028;
            --adm-sidebar: #2b1325;
        }
        body { font-family:'Nunito',sans-serif; background:#f5f0f3; }
        #sidebar {
            width:240px; min-height:100vh; background:var(--adm-sidebar);
            position:fixed; top:0; left:0; z-index:1000; transition:.25s;
        }
        #sidebar .brand {
            padding:1.2rem 1rem .8rem;
            font-size:1.15rem; font-weight:800; color:#fff;
            border-bottom:1px solid rgba(255,255,255,.1);
        }
        #sidebar .nav-link {
            color:rgba(255,255,255,.75); padding:.6rem 1.2rem;
            border-radius:8px; margin:.1rem .5rem; font-weight:600; font-size:.9rem;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background:var(--adm-primary); color:#fff;
        }
        #sidebar .nav-link i { width:20px; }
        #main { margin-left:240px; min-height:100vh; }
        #topbar {
            background:#fff; padding:.65rem 1.5rem; border-bottom:1px solid #e8dce5;
            display:flex; align-items:center; justify-content:space-between;
        }
        .stat-card { border:none; border-radius:14px; }
        .stat-card .icon { width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem; }
        .table-hover tbody tr:hover { background:rgba(181,32,110,.04); }
        .badge-pending   { background:#fff3e0; color:#e65100; }
        .badge-confirmed { background:#e8f5e9; color:#2e7d32; }
        .badge-shipped   { background:#e3f2fd; color:#1565c0; }
        .badge-delivered { background:#e8f5e9; color:#2e7d32; }
        .badge-cancelled { background:#fce4ec; color:#c62828; }

        /* Mobile sidebar */
        @media(max-width:767px) {
            #sidebar { transform:translateX(-100%); }
            #sidebar.show { transform:translateX(0); }
            #main { margin-left:0; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="brand">💍 Bangle Admin</div>
    <ul class="nav flex-column pt-2">
        <?php
        $seg = $this->uri->segment(2) ?: 'dashboard';
        $links = [
            ['dashboard','bi-speedometer2','Dashboard'],
            ['bangles',  'bi-gem',         'Bangles'],
            ['categories','bi-tags',       'Categories'],
            ['orders',   'bi-receipt',     'Orders'],
        ];
        foreach ($links as [$path, $icon, $label]):
        ?>
        <li class="nav-item">
            <a href="<?= base_url('admin/' . $path) ?>"
               class="nav-link <?= ($seg === $path) ? 'active' : '' ?>">
                <i class="bi <?= $icon ?> me-2"></i> <?= $label ?>
            </a>
        </li>
        <?php endforeach; ?>
        <li class="nav-item mt-3">
            <a href="<?= base_url() ?>" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right me-2"></i> View Shop
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/logout') ?>" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<!-- Main -->
<div id="main">
    <!-- Topbar -->
    <div id="topbar">
        <button class="btn btn-sm btn-light d-md-none me-2" id="sidebar-toggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="fw-bold" style="color:var(--adm-primary);"><?= htmlspecialchars($title ?? 'Admin') ?></span>
        <span class="small text-muted">
            <i class="bi bi-person-circle me-1"></i>
            <?= htmlspecialchars($this->session->userdata('admin_name') ?? '') ?>
        </span>
    </div>

    <div class="p-3 p-md-4">

    <!-- Flash -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('upload_error')): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Image upload issue: <?= $this->session->flashdata('upload_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
