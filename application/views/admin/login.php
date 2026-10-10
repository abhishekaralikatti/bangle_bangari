<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Bangle Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background:linear-gradient(135deg,#fdf4f7,#ffe4ef); min-height:100vh; font-family:'Nunito',sans-serif; }
        .login-card { border:none; border-radius:20px; box-shadow:0 8px 40px rgba(181,32,110,.15); max-width:400px; }
        .btn-brand { background:#b5206e; color:#fff; border:none; font-weight:700; border-radius:50px; }
        .btn-brand:hover { background:#8f1554; color:#fff; }
        .form-control:focus { border-color:#b5206e; box-shadow:0 0 0 .2rem rgba(181,32,110,.18); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
    <div class="card login-card w-100">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div style="font-size:3rem;">💍</div>
                <h2 style="font-family:'Playfair Display',serif; color:#b5206e;">Admin Login</h2>
                <p class="text-muted small">Bangle Bangari Store</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('admin/login') ?>" method="post">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@banglestore.com"
                           value="<?= set_value('email') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-brand btn-lg">Login to Dashboard</button>
                </div>
            </form>

            <p class="text-center text-muted mt-4 small">
                Default: <code>admin@banglestore.com</code> / <code>password</code>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
