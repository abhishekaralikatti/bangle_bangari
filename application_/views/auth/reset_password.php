<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="auth-body">
<div class="auth-stars"></div>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="auth-card card shadow-lg p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="zodiac-logo mb-3">🔑</div>
      <h2 class="fw-bold">New Password</h2>
      <p class="text-muted">Choose a strong password for your account</p>
    </div>
    <?= form_open('reset-password/' . $token) ?>
      <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control <?= form_error('password') ? 'is-invalid':'' ?>"
               placeholder="Min. 6 characters" required />
        <?php if (form_error('password')): ?><div class="invalid-feedback"><?= form_error('password') ?></div><?php endif; ?>
      </div>
      <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control <?= form_error('confirm_password') ? 'is-invalid':'' ?>"
               placeholder="Repeat password" required />
        <?php if (form_error('confirm_password')): ?><div class="invalid-feedback"><?= form_error('confirm_password') ?></div><?php endif; ?>
      </div>
      <button type="submit" class="btn btn-primary-cosmos w-100 py-2">Update Password</button>
    <?= form_close() ?>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
