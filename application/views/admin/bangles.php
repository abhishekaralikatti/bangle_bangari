<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Bangles (<?= count($bangles) ?>)</h5>
    <a href="<?= base_url('admin/bangles/add') ?>" class="btn btn-sm" style="background:#b5206e;color:#fff;border-radius:50px;font-weight:700;">
        <i class="bi bi-plus-lg me-1"></i> Add Bangle
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($bangles)): ?>
        <tr><td colspan="8" class="text-center py-5 text-muted">
            No bangles yet. <a href="<?= base_url('admin/bangles/add') ?>">Add your first bangle →</a>
        </td></tr>
    <?php else: ?>
        <?php foreach ($bangles as $b): ?>
        <tr>
            <td>
                <?php if (!empty($b['image']) && file_exists(FCPATH.'assets/uploads/bangles/'.$b['image'])): ?>
                    <img src="<?= base_url('assets/uploads/bangles/'.$b['image']) ?>"
                         style="width:52px;height:52px;object-fit:cover;border-radius:8px;">
                <?php else: ?>
                    <div style="width:52px;height:52px;background:#fce8f2;border-radius:8px;display:flex;align-items:center;justify-content:center;">💍</div>
                <?php endif; ?>
            </td>
            <td>
                <span class="fw-semibold"><?= htmlspecialchars($b['name']) ?></span>
                <?php if (!empty($b['color'])): ?>
                    <br><small class="text-muted"><?= htmlspecialchars($b['color']) ?></small>
                <?php endif; ?>
            </td>
            <td><span class="badge bg-light text-dark"><?= htmlspecialchars($b['category_name'] ?? '—') ?></span></td>
            <td>
                <span class="fw-bold" style="color:#b5206e;">₹<?= number_format($b['price'],0) ?></span>
                <?php if (!empty($b['compare_price'])): ?>
                    <br><small class="text-muted text-decoration-line-through">₹<?= number_format($b['compare_price'],0) ?></small>
                <?php endif; ?>
            </td>
            <td>
                <span class="badge <?= $b['stock'] <= 5 ? 'bg-danger' : 'bg-success' ?>">
                    <?= $b['stock'] ?>
                </span>
            </td>
            <td>
                <a href="<?= base_url('admin/bangles/toggle_featured/'.$b['id']) ?>"
                   class="btn btn-sm btn-link p-0" title="Toggle featured">
                    <i class="bi bi-star<?= $b['is_featured'] ? '-fill text-warning' : '' ?> fs-5"></i>
                </a>
            </td>
            <td>
                <span class="badge <?= $b['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                    <?= $b['is_active'] ? 'Live' : 'Hidden' ?>
                </span>
            </td>
            <td>
                <a href="<?= base_url('admin/bangles/edit/'.$b['id']) ?>"
                   class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= base_url('admin/bangles/delete/'.$b['id']) ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Delete this bangle?')" title="Delete">
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
