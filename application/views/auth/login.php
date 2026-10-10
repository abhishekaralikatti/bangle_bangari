<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="py-5">
<div class="container" style="max-width:440px;">

    <div class="text-center mb-4">
        <div style="font-size:2.5rem;">💍</div>
        <h2 class="font-serif mt-2" style="color:var(--brand-primary);">Welcome Back</h2>
        <p class="text-muted small">Login to continue shopping</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-warning">
            <i class="bi bi-lock me-1"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <!-- Google Login -->
        <?php if (!empty($google_client_id)): ?>
        <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-secondary w-100 mb-3 d-flex align-items-center justify-content-center gap-2" style="border-radius:50px;font-weight:600;">
            <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
            Continue with Google
        </a>

        <div class="d-flex align-items-center gap-2 mb-3">
            <hr class="flex-grow-1"><span class="text-muted small">or</span><hr class="flex-grow-1">
        </div>
        <?php endif; ?>

        <!-- Email Login -->
        <form action="<?= base_url('auth/login') ?>" method="post">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control"
                       value="<?= set_value('email') ?>" placeholder="you@email.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-brand btn-lg">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </button>
            </div>
        </form>
    </div>
    </div>

    <p class="text-center mt-3 text-muted">
        New here?
        <a href="<?= base_url('auth/register') ?>" style="color:var(--brand-primary);font-weight:700;">
            Create an account
        </a>
    </p>

</div>
</section>
