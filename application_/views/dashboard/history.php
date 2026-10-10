<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>History – Daily Horoscope</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body class="dash-body">

<?php $this->load->view('dashboard/_navbar', ['user' => $user, 'page' => $page]) ?>

<div class="container py-5">

  <div class="d-flex align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="fa fa-history me-2 text-accent"></i>Your Horoscope History</h2>
    <span class="ms-auto badge badge-sign"><?= $user->zodiac_sign ?></span>
  </div>

  <?php if (!empty($history)): ?>

    <div class="history-timeline">
      <?php foreach ($history as $h): ?>
        <div class="history-item card mb-3 p-4">
          <div class="d-flex align-items-start">
            <div class="history-date-badge me-4 text-center">
              <div class="hist-day"><?= date('d', strtotime($h->horoscope_date)) ?></div>
              <div class="hist-mon"><?= date('M', strtotime($h->horoscope_date)) ?></div>
              <div class="hist-yr"><?= date('Y', strtotime($h->horoscope_date)) ?></div>
            </div>
            <div class="flex-grow-1">
              <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                <span class="fw-semibold"><?= date('l', strtotime($h->horoscope_date)) ?></span>
                <?php if ($h->mood): ?>
                  <span class="badge bg-light text-dark border">😊 <?= htmlspecialchars($h->mood) ?></span>
                <?php endif; ?>
                <?php if ($h->email_sent): ?>
                  <span class="badge text-bg-success"><i class="fa fa-envelope me-1"></i>Emailed</span>
                <?php endif; ?>
              </div>
              <p class="mb-2 history-desc"><?= htmlspecialchars($h->description) ?></p>
              <?php if ($h->lucky_number || $h->color || $h->compatibility): ?>
              <div class="d-flex flex-wrap gap-3 mt-2 small text-muted">
                <?php if ($h->lucky_number): ?>
                  <span><i class="fa fa-star me-1 text-accent"></i><?= htmlspecialchars($h->lucky_number) ?></span>
                <?php endif; ?>
                <?php if ($h->color): ?>
                  <span><i class="fa fa-palette me-1 text-accent"></i><?= htmlspecialchars($h->color) ?></span>
                <?php endif; ?>
                <?php if ($h->compatibility): ?>
                  <span><i class="fa fa-heart me-1 text-accent"></i><?= htmlspecialchars($h->compatibility) ?></span>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php if ($current_page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $current_page-1 ?>"><i class="fa fa-chevron-left"></i></a>
          </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i==$current_page?'active':'' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $current_page+1 ?>"><i class="fa fa-chevron-right"></i></a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

  <?php else: ?>
    <div class="text-center py-5">
      <div class="empty-state-icon">🔮</div>
      <h4 class="mt-3">No history yet</h4>
      <p class="text-muted">Your daily horoscopes will appear here.</p>
      <a href="<?= base_url('dashboard') ?>" class="btn btn-primary-cosmos">View Today's Horoscope</a>
    </div>
  <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
