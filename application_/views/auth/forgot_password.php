<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="auth-body">
<div class="auth-stars"></div>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="auth-card card shadow-lg p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="zodiac-logo mb-3">🔮</div>
      <h2 class="fw-bold">Reset Password</h2>
      <p class="text-muted">Enter your email to receive a reset link</p>
    </div>
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?= form_open('forgot-password') ?>
      <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" placeholder="your@email.com" required />
        </div>
      </div>
      <button type="submit" class="btn btn-primary-cosmos w-100 py-2">Send Reset Link</button>
    <?= form_close() ?>
    <p class="text-center mt-3 text-muted"><a href="<?= base_url('login') ?>" class="link-accent">Back to Login</a></p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
