<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="auth-body">

<div class="auth-stars"></div>

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
  <div class="auth-card card shadow-lg p-4 p-md-5" style="max-width:520px;width:100%">

    <div class="text-center mb-4">
      <div class="zodiac-logo mb-3">✦</div>
      <h2 class="fw-bold">Begin Your Journey</h2>
      <p class="text-muted">Create your cosmic profile</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?= form_open('register') ?>
      <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
          <input type="text" name="full_name" class="form-control <?= form_error('full_name') ? 'is-invalid' : '' ?>"
                 value="<?= set_value('full_name') ?>" placeholder="Your full name" required />
          <?php if (form_error('full_name')): ?>
            <div class="invalid-feedback"><?= form_error('full_name') ?></div>
          <?php endif; ?>
        </div>
      </div>

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

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Date of Birth</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa fa-calendar-star"></i></span>
            <input type="date" name="dob" class="form-control <?= form_error('dob') ? 'is-invalid' : '' ?>"
                   value="<?= set_value('dob') ?>" max="<?= date('Y-m-d', strtotime('-5 years')) ?>" required />
            <?php if (form_error('dob')): ?>
              <div class="invalid-feedback"><?= form_error('dob') ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Gender</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
            <select name="gender" class="form-select <?= form_error('gender') ? 'is-invalid' : '' ?>" required>
              <option value="">Select...</option>
              <option value="male"   <?= set_select('gender','male') ?>>Male</option>
              <option value="female" <?= set_select('gender','female') ?>>Female</option>
              <option value="other"  <?= set_select('gender','other') ?>>Other</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Zodiac Preview -->
      <div id="zodiacPreview" class="zodiac-preview mb-3" style="display:none">
        <span class="zodiac-icon" id="zodiacIcon"></span>
        <span id="zodiacName"></span>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" id="passwordInput"
                 class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                 placeholder="Min. 6 characters" required />
          <button class="btn btn-outline-secondary" type="button" onclick="togglePw('passwordInput','eye1')">
            <i class="fa fa-eye" id="eye1"></i>
          </button>
          <?php if (form_error('password')): ?>
            <div class="invalid-feedback"><?= form_error('password') ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-lock"></i></span>
          <input type="password" name="confirm_password" id="confirmInput"
                 class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>"
                 placeholder="Repeat password" required />
          <button class="btn btn-outline-secondary" type="button" onclick="togglePw('confirmInput','eye2')">
            <i class="fa fa-eye" id="eye2"></i>
          </button>
          <?php if (form_error('confirm_password')): ?>
            <div class="invalid-feedback"><?= form_error('confirm_password') ?></div>
          <?php endif; ?>
        </div>
      </div>

      <button type="submit" class="btn btn-primary-cosmos w-100 py-2 fw-semibold">
        <i class="fa fa-star me-2"></i>Create Account
      </button>
    <?= form_close() ?>

    <p class="text-center mt-4 mb-0 text-muted">
      Already have an account? <a href="<?= base_url('login') ?>" class="link-accent fw-semibold">Sign In</a>
    </p>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const signs = [
  {name:'Capricorn',icon:'♑',m1:1,d1:1,m2:1,d2:19},{name:'Aquarius',icon:'♒',m1:1,d1:20,m2:2,d2:18},
  {name:'Pisces',icon:'♓',m1:2,d1:19,m2:3,d2:20},{name:'Aries',icon:'♈',m1:3,d1:21,m2:4,d2:19},
  {name:'Taurus',icon:'♉',m1:4,d1:20,m2:5,d2:20},{name:'Gemini',icon:'♊',m1:5,d1:21,m2:6,d2:20},
  {name:'Cancer',icon:'♋',m1:6,d1:21,m2:7,d2:22},{name:'Leo',icon:'♌',m1:7,d1:23,m2:8,d2:22},
  {name:'Virgo',icon:'♍',m1:8,d1:23,m2:9,d2:22},{name:'Libra',icon:'♎',m1:9,d1:23,m2:10,d2:22},
  {name:'Scorpio',icon:'♏',m1:10,d1:23,m2:11,d2:21},{name:'Sagittarius',icon:'♐',m1:11,d1:22,m2:12,d2:21},
  {name:'Capricorn',icon:'♑',m1:12,d1:22,m2:12,d2:31}
];
document.querySelector('input[name="dob"]').addEventListener('change', function() {
  const d = new Date(this.value), m = d.getMonth()+1, day = d.getDate();
  const sign = signs.find(s => (m===s.m1&&day>=s.d1)||(m===s.m2&&day<=s.d2));
  if (sign) {
    document.getElementById('zodiacPreview').style.display='flex';
    document.getElementById('zodiacIcon').textContent=sign.icon;
    document.getElementById('zodiacName').textContent='Your sign: '+sign.name;
  }
});
function togglePw(id, iconId) {
  const el=document.getElementById(id), ic=document.getElementById(iconId);
  el.type=el.type==='password'?'text':'password';
  ic.classList.toggle('fa-eye'); ic.classList.toggle('fa-eye-slash');
}
</script>
</body>
</html>
