<!DOCTYPE html>
<html><head><meta charset="UTF-8"/>
<style>
  body{font-family:'Segoe UI',sans-serif;background:#0d0d1f;margin:0;padding:0}
  .wrapper{max-width:600px;margin:40px auto;background:#1a1a3e;border-radius:16px;overflow:hidden}
  .header{background:linear-gradient(135deg,#6c3fc7,#b068ff);padding:40px 30px;text-align:center;color:#fff}
  .header h1{margin:0;font-size:28px;letter-spacing:2px}
  .body{padding:36px 30px;color:#d4c8f0}
  .btn{display:inline-block;background:linear-gradient(135deg,#6c3fc7,#b068ff);color:#fff;text-decoration:none;
       padding:14px 36px;border-radius:30px;font-weight:600;margin:20px 0;font-size:16px}
  .footer{background:#111130;padding:20px 30px;text-align:center;font-size:12px;color:#6060a0}
  .link-url{word-break:break-all;color:#b068ff;font-size:12px}
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <span style="font-size:48px">🔑</span>
    <h1>Password Reset</h1>
  </div>
  <div class="body">
    <h2 style="color:#fff;margin-top:0">Hi <?= htmlspecialchars($user->full_name) ?>,</h2>
    <p>We received a request to reset your Daily Horoscope account password. Click the button below to create a new password:</p>
    <div style="text-align:center">
      <a href="<?= $reset_link ?>" class="btn">Reset My Password</a>
    </div>
    <p class="link-url"><?= $reset_link ?></p>
    <p style="color:#8080b0;font-size:13px">This link expires in <strong>1 hour</strong>. If you didn't request this, simply ignore this email — your password will remain unchanged.</p>
  </div>
  <div class="footer">&copy; <?= date('Y') ?> Daily Horoscope</div>
</div>
</body></html>
