<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row g-4">
    <!-- Add category form -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Add Category</h5>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>
                <form action="<?= base_url('admin/categories') ?>" method="post">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Silver Bangles" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Short description..."></textarea>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold" style="background:#b5206e;color:#fff;border-radius:50px;">
                        <i class="bi bi-plus-lg me-1"></i> Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Name</th><th>Slug</th><th>Description</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="4" class="text-center py-4 text-muted">No categories yet.</td></tr>
            <?php else: ?>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td class="fw-semibold"><?= htmlspecialchars($cat['name']) ?></td>
                <td><code class="small"><?= htmlspecialchars($cat['slug']) ?></code></td>
                <td class="text-muted small"><?= htmlspecialchars(substr($cat['description'] ?? '', 0, 50)) ?></td>
                <td>
                    <a href="<?= base_url('shop/category/'.$cat['slug']) ?>"
                       class="btn btn-sm btn-outline-secondary me-1" target="_blank" title="View on shop">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="<?= base_url('admin/categories/delete/'.$cat['id']) ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Delete this category?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
        </div>
    </div>
</div>
