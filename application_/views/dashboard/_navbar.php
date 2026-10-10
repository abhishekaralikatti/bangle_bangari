<nav class="navbar navbar-expand-lg navbar-dark dash-nav">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= base_url('dashboard') ?>">
      ✦ <span>DailyHoro</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item">
          <a class="nav-link <?= ($page==='dashboard')?'active':'' ?>" href="<?= base_url('dashboard') ?>">
            <i class="fa fa-home me-1"></i>Today
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page==='history')?'active':'' ?>" href="<?= base_url('dashboard/history') ?>">
            <i class="fa fa-history me-1"></i>History
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page==='profile')?'active':'' ?>" href="<?= base_url('dashboard/profile') ?>">
            <i class="fa fa-user me-1"></i>Profile
          </a>
        </li>
        <li class="nav-item ms-lg-3">
          <a class="btn btn-outline-light btn-sm px-3" href="<?= base_url('logout') ?>">
            <i class="fa fa-sign-out-alt me-1"></i>Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
