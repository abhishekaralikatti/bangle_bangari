<!DOCTYPE html>
<html><head><meta charset="UTF-8"/>
<style>
  body{font-family:'Segoe UI',sans-serif;background:#0d0d1f;margin:0;padding:0}
  .wrapper{max-width:600px;margin:40px auto;background:#1a1a3e;border-radius:16px;overflow:hidden}
  .header{background:linear-gradient(135deg,#6c3fc7,#b068ff);padding:40px 30px;text-align:center;color:#fff}
  .sign-symbol{font-size:64px;display:block;margin-bottom:8px}
  .header h1{margin:4px 0 0;font-size:24px;letter-spacing:2px}
  .header .date{font-size:14px;opacity:.85;margin-top:4px}
  .body{padding:36px 30px;color:#d4c8f0}
  .reading-box{background:#0f0f2e;border-left:4px solid #b068ff;border-radius:8px;padding:20px;margin:20px 0;font-size:15px;line-height:1.8}
  .tiles{display:flex;flex-wrap:wrap;gap:12px;margin:24px 0}
  .tile{flex:1;min-width:120px;background:#111130;border-radius:10px;padding:14px;text-align:center}
  .tile-icon{font-size:24px}
  .tile-label{font-size:11px;color:#8080b0;margin:4px 0 2px;text-transform:uppercase;letter-spacing:1px}
  .tile-value{font-size:14px;font-weight:600;color:#d4c8f0}
  .lucky-bar{background:#111130;border-radius:10px;padding:14px 20px;display:flex;align-items:center;gap:14px;margin:20px 0}
  .lucky-bar .icon{font-size:24px}
  .btn{display:inline-block;background:linear-gradient(135deg,#6c3fc7,#b068ff);color:#fff;text-decoration:none;
       padding:14px 36px;border-radius:30px;font-weight:600;font-size:15px}
  .footer{background:#111130;padding:20px 30px;text-align:center;font-size:12px;color:#6060a0}
  .footer a{color:#b068ff;text-decoration:none}
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <span class="sign-symbol"><?php
      $map=['Aries'=>'♈','Taurus'=>'♉','Gemini'=>'♊','Cancer'=>'♋','Leo'=>'♌','Virgo'=>'♍',
            'Libra'=>'♎','Scorpio'=>'♏','Sagittarius'=>'♐','Capricorn'=>'♑','Aquarius'=>'♒','Pisces'=>'♓'];
      echo $map[$user->zodiac_sign] ?? '✦';
    ?></span>
    <h1><?= $user->zodiac_sign ?> &nbsp;–&nbsp; Daily Reading</h1>
    <div class="date"><?= $date ?></div>
  </div>

  <div class="body">
    <p style="margin-top:0">Hi <strong><?= htmlspecialchars($user->full_name) ?></strong>, here's what the stars have in store for you today:</p>

    <div class="reading-box"><?= htmlspecialchars($horoscope->description) ?></div>

    <div class="tiles">
      <?php if ($horoscope->mood): ?>
      <div class="tile">
        <div class="tile-icon">😊</div>
        <div class="tile-label">Mood</div>
        <div class="tile-value"><?= htmlspecialchars($horoscope->mood) ?></div>
      </div>
      <?php endif; ?>
      <?php if ($horoscope->color): ?>
      <div class="tile">
        <div class="tile-icon">🎨</div>
        <div class="tile-label">Color</div>
        <div class="tile-value"><?= htmlspecialchars($horoscope->color) ?></div>
      </div>
      <?php endif; ?>
      <?php if ($horoscope->lucky_number): ?>
      <div class="tile">
        <div class="tile-icon">🔢</div>
        <div class="tile-label">Lucky No.</div>
        <div class="tile-value"><?= htmlspecialchars($horoscope->lucky_number) ?></div>
      </div>
      <?php endif; ?>
      <?php if ($horoscope->compatibility): ?>
      <div class="tile">
        <div class="tile-icon">💞</div>
        <div class="tile-label">Compatible</div>
        <div class="tile-value"><?= htmlspecialchars($horoscope->compatibility) ?></div>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($horoscope->lucky_time): ?>
    <div class="lucky-bar">
      <span class="icon">⏰</span>
      <div>
        <div style="font-size:11px;color:#8080b0;text-transform:uppercase;letter-spacing:1px">Best Time Today</div>
        <div style="font-weight:600"><?= htmlspecialchars($horoscope->lucky_time) ?></div>
      </div>
    </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:30px">
      <a href="<?= base_url('dashboard') ?>" class="btn">View Full Reading →</a>
    </div>
  </div>

  <div class="footer">
    &copy; <?= date('Y') ?> Daily Horoscope &nbsp;·&nbsp;
    <a href="<?= base_url('dashboard/unsubscribe') ?>">Unsubscribe</a>
  </div>
</div>
</body></html>
