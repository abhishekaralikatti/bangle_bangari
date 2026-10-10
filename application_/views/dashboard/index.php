<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="dash-body">

<?php $this->load->view('dashboard/_navbar', ['user' => $user, 'page' => $page]) ?>

<div class="container py-5">

  <!-- Header -->
  <div class="dash-header text-center mb-5">
    <div class="zodiac-symbol"><?= $this->_get_zodiac_symbol($user->zodiac_sign) ?></div>
    <h1 class="display-5 fw-bold mt-2"><?= htmlspecialchars($user->full_name) ?></h1>
    <p class="lead text-muted"><?= $user->zodiac_sign ?> &nbsp;·&nbsp; <?= date('l, d F Y') ?></p>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= $this->session->flashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($horoscope): ?>

  <!-- Main horoscope card -->
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="horo-card card p-4 mb-4">
        <div class="horo-card-header d-flex align-items-center mb-3">
          <i class="fa fa-star-half-alt me-2 text-accent"></i>
          <h5 class="mb-0 fw-semibold">Today's Reading</h5>
          <span class="ms-auto badge badge-sign"><?= $user->zodiac_sign ?></span>
        </div>
        <p class="horo-description"><?= htmlspecialchars($horoscope->description) ?></p>
      </div>

      <!-- Insight tiles -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="insight-tile card text-center p-3">
            <div class="insight-icon">🎨</div>
            <div class="insight-label">Lucky Color</div>
            <div class="insight-value"><?= htmlspecialchars($horoscope->color ?: '–') ?></div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="insight-tile card text-center p-3">
            <div class="insight-icon">🔢</div>
            <div class="insight-label">Lucky Number</div>
            <div class="insight-value"><?= htmlspecialchars($horoscope->lucky_number ?: '–') ?></div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="insight-tile card text-center p-3">
            <div class="insight-icon">😊</div>
            <div class="insight-label">Mood</div>
            <div class="insight-value"><?= htmlspecialchars($horoscope->mood ?: '–') ?></div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="insight-tile card text-center p-3">
            <div class="insight-icon">💞</div>
            <div class="insight-label">Compatible</div>
            <div class="insight-value"><?= htmlspecialchars($horoscope->compatibility ?: '–') ?></div>
          </div>
        </div>
      </div>

      <!-- Lucky time -->
      <?php if ($horoscope->lucky_time): ?>
      <div class="lucky-time-bar card p-3 mb-4 d-flex flex-row align-items-center">
        <i class="fa fa-clock me-3 text-accent fs-4"></i>
        <div>
          <div class="small text-muted">Best Time Today</div>
          <div class="fw-semibold"><?= htmlspecialchars($horoscope->lucky_time) ?></div>
        </div>
      </div>
      <?php endif; ?>

    </div>
  </div>

  <?php else: ?>
  <div class="alert alert-warning text-center">
    <i class="fa fa-exclamation-triangle me-2"></i>
    Horoscope data is temporarily unavailable. Please try again later.
  </div>
  <?php endif; ?>

</div>

<?php
// Helper used inline
function _get_zodiac_symbol($sign) {
  $map = ['Aries'=>'♈','Taurus'=>'♉','Gemini'=>'♊','Cancer'=>'♋','Leo'=>'♌','Virgo'=>'♍',
          'Libra'=>'♎','Scorpio'=>'♏','Sagittarius'=>'♐','Capricorn'=>'♑','Aquarius'=>'♒','Pisces'=>'♓'];
  return $map[$sign] ?? '✦';
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
