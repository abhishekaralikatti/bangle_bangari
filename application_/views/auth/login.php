<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="auth-body">

<div class="auth-stars"></div>

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
  <div class="auth-card card shadow-lg p-4 p-md-5">

    <div class="text-center mb-4">
      <div class="zodiac-logo mb-3">✦</div>
      <h2 class="fw-bold">Welcome Back</h2>
      <p class="text-muted">Sign in to your cosmic journey</p>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?= form_open('login', ['class' => 'needs-validation']) ?>
      <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          <input type="email" name="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>"
                 value="<?= set_value('email') ?>" placeholder="you@example.com" required />
          <?php if (form_error('email')): ?>
            <div class="invalid-feedback"><?= form_error('email') ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" id="passwordInput"
                 class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                 placeholder="••••••••" required />
          <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
            <i class="fa fa-eye" id="eyeIcon"></i>
          </button>
          <?php if (form_error('password')): ?>
            <div class="invalid-feedback"><?= form_error('password') ?></div>
          <?php endif; ?>
        </div>
        <div class="text-end mt-1">
          <a href="<?= base_url('forgot-password') ?>" class="small text-decoration-none link-accent">Forgot password?</a>
        </div>
      </div>

      <button type="submit" class="btn btn-primary-cosmos w-100 py-2 fw-semibold mt-2">
        <i class="fa fa-sign-in-alt me-2"></i>Sign In
      </button>
    <?= form_close() ?>

    <p class="text-center mt-4 mb-0 text-muted">
      Don't have an account? <a href="<?= base_url('register') ?>" class="link-accent fw-semibold">Sign Up</a>
    </p>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePassword() {
    const p = document.getElementById('passwordInput');
    const i = document.getElementById('eyeIcon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.classList.toggle('fa-eye'); i.classList.toggle('fa-eye-slash');
  }
</script>
</body>
</html>
