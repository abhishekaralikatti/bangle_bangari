<?php defined('BASEPATH') OR exit('No direct script access allowed');
$is_edit = !empty($bangle);
?>

<div class="mb-3">
    <a href="<?= base_url('admin/bangles') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Bangles
    </a>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3">
<div class="card-body p-4">
    <form action="" method="post" enctype="multipart/form-data">
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="row g-3">
            <!-- Name -->
            <div class="col-12 col-md-8">
                <label class="form-label fw-semibold">Bangle Name *</label>
                <input type="text" name="name" class="form-control"
                       value="<?= set_value('name', $bangle['name'] ?? '') ?>"
                       placeholder="e.g. Red Glass Bangle Set (12 pcs)" required>
            </div>
            <!-- Category -->
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">— No Category —</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= (($bangle['category_id'] ?? 0) == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Description -->
            <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Describe this bangle set..."><?= set_value('description', $bangle['description'] ?? '') ?></textarea>
            </div>
            <!-- Price -->
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold">Selling Price (₹) *</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0"
                       value="<?= set_value('price', $bangle['price'] ?? '') ?>" required>
            </div>
            <!-- Compare price -->
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold">Original Price (₹)</label>
                <input type="number" name="compare_price" class="form-control" step="0.01" min="0"
                       value="<?= set_value('compare_price', $bangle['compare_price'] ?? '') ?>"
                       placeholder="For strike-through">
            </div>
            <!-- Stock -->
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold">Stock Qty *</label>
                <input type="number" name="stock" class="form-control" min="0"
                       value="<?= set_value('stock', $bangle['stock'] ?? 0) ?>" required>
            </div>
            <!-- Size -->
            <div class="col-6 col-md-3">
                <label class="form-label fw-semibold">Size</label>
                <input type="text" name="size" class="form-control"
                       value="<?= set_value('size', $bangle['size'] ?? '') ?>"
                       placeholder="e.g. 2.6 / 2.8">
            </div>
            <!-- Material -->
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Material</label>
                <input type="text" name="material" class="form-control"
                       value="<?= set_value('material', $bangle['material'] ?? '') ?>"
                       placeholder="e.g. Glass, Brass with Gold Plating">
            </div>
            <!-- Color -->
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Colour</label>
                <input type="text" name="color" class="form-control"
                       value="<?= set_value('color', $bangle['color'] ?? '') ?>"
                       placeholder="e.g. Red, Multicolour, Gold &amp; Blue">
            </div>

            <!-- Image -->
            <div class="col-12">
                <label class="form-label fw-semibold">Product Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                <div class="form-text">JPG, PNG or WEBP. Max 2MB.</div>
                <?php if ($is_edit && !empty($bangle['image'])): ?>
                    <div class="mt-2">
                        <p class="small text-muted mb-1">Current image:</p>
                        <img src="<?= base_url('assets/uploads/bangles/'.$bangle['image']) ?>"
                             style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                    </div>
                <?php endif; ?>
                <img id="image-preview" src="" class="mt-2 d-none"
                     style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
            </div>

            <!-- Toggles -->
            <div class="col-12 d-flex gap-4 flex-wrap">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                           <?= ($bangle['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="is_featured">
                        ✨ Featured (show on homepage)
                    </label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           <?= ($bangle['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="is_active">
                        Live (visible on shop)
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-lg" style="background:#b5206e;color:#fff;border-radius:50px;font-weight:700;">
                    <i class="bi bi-<?= $is_edit ? 'save' : 'plus-lg' ?> me-1"></i>
                    <?= $is_edit ? 'Update Bangle' : 'Add Bangle' ?>
                </button>
                <a href="<?= base_url('admin/bangles') ?>" class="btn btn-lg btn-outline-secondary" style="border-radius:50px;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
</div>
