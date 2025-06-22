<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-<?= $category ? 'edit' : 'plus' ?>" style="margin-right: 12px;"></i>
        <?= $category ? 'Edit Category' : 'Create New Category' ?>
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to Categories
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px;">
    <!-- Main Form -->
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">
                <i class="fas fa-tag" style="margin-right: 8px;"></i>Category Information
            </h6>
        </div>
        <div class="card-body">
            <form
                action="<?= $category ? base_url('admin/categories/update/' . $category['id']) : base_url('admin/categories/store') ?>"
                method="POST" id="categoryForm">
                <?= csrf_field() ?>
                <?php if ($category): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <!-- Category Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Category Name <span style="color: var(--error-color);">*</span>
                    </label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name"
                        name="name" value="<?= old('name', $category['name'] ?? '') ?>"
                        placeholder="Enter category name..." required>
                    <?php if (session('errors.name')): ?>
                        <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                            <?= session('errors.name') ?>
                        </div>
                    <?php endif; ?>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                        Slug: <span id="slugPreview"
                            style="color: var(--text-primary);"><?= $category['slug'] ?? '' ?></span>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>"
                        id="description" name="description" rows="4" placeholder="Brief description of this category..."
                        maxlength="500"><?= old('description', $category['description'] ?? '') ?></textarea>
                    <?php if (session('errors.description')): ?>
                        <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                            <?= session('errors.description') ?>
                        </div>
                    <?php endif; ?>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                        Character count: <span id="descriptionCount">0</span>/500
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        <span id="submitText"><?= $category ? 'Update Category' : 'Create Category' ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Category Preview -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="fas fa-eye" style="margin-right: 8px;"></i>Preview
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div
                        style="width: 48px; height: 48px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                        <i class="fas fa-tag" style="color: var(--card-bg);"></i>
                    </div>
                    <div>
                        <h6 style="margin: 0; margin-bottom: 4px;" id="previewName">
                            <?= $category['name'] ?? 'Category Name' ?>
                        </h6>
                        <small style="color: var(--text-muted);"
                            id="previewSlug"><?= $category['slug'] ?? 'category-slug' ?></small>
                    </div>
                </div>
                <p style="color: var(--text-secondary); margin: 0;" id="previewDescription">
                    <?= $category['description'] ?? 'Category description will appear here...' ?>
                </p>
            </div>
        </div>

        <!-- Category Info (if editing) -->
        <?php if ($category): ?>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Category Information
                    </h6>
                </div>
                <div class="card-body">
                    <div style="font-size: 12px; color: var(--text-secondary);">
                        <div style="margin-bottom: 12px;">
                            <strong>ID:</strong> #<?= $category['id'] ?>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <strong>Created:</strong><br>
                            <?= date('M d, Y H:i', strtotime($category['created_at'])) ?>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <strong>Slug:</strong><br>
                            <code style="background: var(--hover-bg); padding: 2px 6px; border-radius: 4px;">
                                        <?= esc($category['slug']) ?>
                                    </code>
                        </div>
                        <a href="<?= base_url('admin/categories/show/' . $category['id']) ?>"
                            class="btn-action btn-action-view" style="width: 100%; justify-content: center;">
                            <i class="fas fa-eye"></i>View Category
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tips -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="fas fa-lightbulb" style="margin-right: 8px;"></i>Tips
                </h6>
            </div>
            <div class="card-body">
                <div style="font-size: 12px; color: var(--text-secondary);">
                    <ul style="margin: 0; padding-left: 16px;">
                        <li style="margin-bottom: 8px;">
                            Use clear, descriptive category names
                        </li>
                        <li style="margin-bottom: 8px;">
                            Keep categories broad enough to contain multiple posts
                        </li>
                        <li style="margin-bottom: 8px;">
                            Add descriptions to help readers understand the category
                        </li>
                        <li style="margin: 0;">
                            Avoid creating too many categories
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function () {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');

        document.getElementById('slugPreview').textContent = slug || 'category-slug';
        document.getElementById('previewName').textContent = name || 'Category Name';
        document.getElementById('previewSlug').textContent = slug || 'category-slug';
    });

    // Description character counter and preview
    document.getElementById('description').addEventListener('input', function () {
        const description = this.value;
        const count = description.length;

        document.getElementById('descriptionCount').textContent = count;
        document.getElementById('previewDescription').textContent = description || 'Category description will appear here...';

        const counter = document.getElementById('descriptionCount');
        if (count > 500) {
            counter.style.color = 'var(--error-color)';
        } else if (count > 400) {
            counter.style.color = 'var(--warning-color)';
        } else {
            counter.style.color = 'var(--success-color)';
        }
    });

    // Initialize character count on page load
    document.addEventListener('DOMContentLoaded', function () {
        const description = document.getElementById('description');
        if (description.value) {
            document.getElementById('descriptionCount').textContent = description.value.length;
        }
    });

    // Form submission handling
    document.getElementById('categoryForm').addEventListener('submit', function (e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        // Disable button and show loading
        submitBtn.disabled = true;
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Saving...';

        // Re-enable after 5 seconds (in case of error)
        setTimeout(function () {
            submitBtn.disabled = false;
            submitText.innerHTML = '<?= $category ? "Update Category" : "Create Category" ?>';
        }, 5000);
    });

    // Prevent accidental page leave
    let formChanged = false;
    document.getElementById('categoryForm').addEventListener('input', function () {
        formChanged = true;
    });

    window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    // Clear form changed flag on successful submit
    document.getElementById('categoryForm').addEventListener('submit', function () {
        formChanged = false;
    });
</script>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 300px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<?= $this->endSection() ?>