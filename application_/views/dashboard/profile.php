<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profile – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="dash-body">

<?php $this->load->view('dashboard/_navbar', ['user' => $user, 'page' => $page]) ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <h2 class="fw-bold mb-4"><i class="fa fa-user-circle me-2 text-accent"></i>Your Profile</h2>

      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= $this->session->flashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Profile card -->
      <div class="card p-4 mb-4">
        <div class="d-flex align-items-center mb-4">
          <div class="profile-avatar me-3">
            <?= strtoupper(substr($user->full_name, 0, 1)) ?>
          </div>
          <div>
            <h5 class="mb-0 fw-bold"><?= htmlspecialchars($user->full_name) ?></h5>
            <span class="text-muted small"><?= htmlspecialchars($user->email) ?></span><br/>
            <span class="badge badge-sign mt-1"><?= $user->zodiac_sign ?></span>
          </div>
        </div>

        <?= form_open('dashboard/profile') ?>
          <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control <?= form_error('full_name')?'is-invalid':'' ?>"
                   value="<?= htmlspecialchars($user->full_name) ?>" required />
            <?php if (form_error('full_name')): ?><div class="invalid-feedback"><?= form_error('full_name') ?></div><?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Email <span class="text-muted">(cannot change)</span></label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($user->email) ?>" disabled />
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="dob" class="form-control"
                     value="<?= $user->dob ?>" required />
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select">
                <option value="male"   <?= $user->gender==='male'  ?'selected':'' ?>>Male</option>
                <option value="female" <?= $user->gender==='female'?'selected':'' ?>>Female</option>
                <option value="other"  <?= $user->gender==='other' ?'selected':'' ?>>Other</option>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary-cosmos px-4">
            <i class="fa fa-save me-2"></i>Save Changes
          </button>
        <?= form_close() ?>
      </div>

      <!-- Email subscription card -->
      <div class="card p-4">
        <h6 class="fw-semibold mb-3"><i class="fa fa-envelope me-2 text-accent"></i>Daily Email Horoscope</h6>
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="fw-medium"><?= $user->email_subscribed ? 'Subscribed' : 'Unsubscribed' ?></div>
            <div class="text-muted small">
              <?= $user->email_subscribed
                ? 'You receive your daily horoscope every morning.'
                : 'You are not receiving daily horoscope emails.' ?>
            </div>
          </div>
          <a href="<?= base_url('dashboard/unsubscribe') ?>"
             class="btn <?= $user->email_subscribed ? 'btn-outline-danger' : 'btn-outline-success' ?> btn-sm">
            <?= $user->email_subscribed ? '<i class="fa fa-bell-slash me-1"></i>Unsubscribe' : '<i class="fa fa-bell me-1"></i>Subscribe' ?>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
