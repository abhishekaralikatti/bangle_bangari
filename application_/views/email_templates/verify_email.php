<!DOCTYPE html>
<html><head><meta charset="UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
  body{font-family:'Segoe UI',sans-serif;background:#0d0d1f;margin:0;padding:0}
  .wrapper{max-width:600px;margin:40px auto;background:#1a1a3e;border-radius:16px;overflow:hidden}
  .header{background:linear-gradient(135deg,#6c3fc7,#b068ff);padding:40px 30px;text-align:center;color:#fff}
  .header h1{margin:0;font-size:28px;letter-spacing:2px}
  .header .symbol{font-size:48px;display:block;margin-bottom:10px}
  .body{padding:36px 30px;color:#d4c8f0}
  .body p{line-height:1.7;font-size:15px}
  .btn{display:inline-block;background:linear-gradient(135deg,#6c3fc7,#b068ff);color:#fff;text-decoration:none;
       padding:14px 36px;border-radius:30px;font-weight:600;margin:20px 0;font-size:16px}
  .footer{background:#111130;padding:20px 30px;text-align:center;font-size:12px;color:#6060a0}
  .link-url{word-break:break-all;color:#b068ff;font-size:12px}
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <span class="symbol">✦</span>
    <h1>Daily Horoscope</h1>
  </div>
  <div class="body">
    <h2 style="color:#fff;margin-top:0">Welcome, <?= htmlspecialchars($user->full_name) ?>!</h2>
    <p>Thank you for joining <strong>Daily Horoscope</strong>. You're one step away from receiving your personalized cosmic readings.</p>
    <p>Your zodiac sign is <strong><?= $user->zodiac_sign ?></strong>. We'll send you daily horoscope insights straight to your inbox.</p>
    <p>Please verify your email address by clicking the button below:</p>
    <div style="text-align:center">
      <a href="<?= $verify_link ?>" class="btn">✓ Verify My Email</a>
    </div>
    <p class="small" style="color:#8080b0">Or copy this link into your browser:</p>
    <p class="link-url"><?= $verify_link ?></p>
    <p style="color:#8080b0;font-size:13px">This link will expire in 24 hours. If you didn't create this account, please ignore this email.</p>
  </div>
  <div class="footer">
    &copy; <?= date('Y') ?> Daily Horoscope &nbsp;·&nbsp; Unsubscribe anytime from your profile
  </div>
</div>
</body></html>
