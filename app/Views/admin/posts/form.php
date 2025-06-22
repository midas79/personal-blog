<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-<?= $post ? 'edit' : 'plus' ?>" style="margin-right: 12px;"></i>
        <?= $post ? 'Edit Post' : 'Create New Post' ?>
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to Posts
        </a>
    </div>
</div>

<form action="<?= $post ? base_url('admin/posts/update/' . $post['id']) : base_url('admin/posts/store') ?>"
    method="POST" enctype="multipart/form-data" id="postForm">
    <?= csrf_field() ?>
    <?php if ($post): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px;">
        <!-- Main Form -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Post Content -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="fas fa-edit" style="margin-right: 8px;"></i>Post Content
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Title <span style="color: var(--error-color);">*</span>
                        </label>
                        <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>"
                            id="title" name="title" value="<?= old('title', $post['title'] ?? '') ?>"
                            placeholder="Enter post title..." required>
                        <?php if (session('errors.title')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.title') ?>
                            </div>
                        <?php endif; ?>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            Slug: <span id="slugPreview"
                                style="color: var(--text-primary);"><?= $post['slug'] ?? '' ?></span>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">
                            Excerpt <span style="color: var(--error-color);">*</span>
                        </label>
                        <textarea class="form-control <?= session('errors.excerpt') ? 'is-invalid' : '' ?>" id="excerpt"
                            name="excerpt" rows="3" placeholder="Brief description of your post..."
                            maxlength="500"><?= old('excerpt', $post['excerpt'] ?? '') ?></textarea>
                        <?php if (session('errors.excerpt')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.excerpt') ?>
                            </div>
                        <?php endif; ?>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            Character count: <span id="excerptCount">0</span>/500
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">
                            Content <span style="color: var(--error-color);">*</span>
                        </label>
                        <textarea class="form-control <?= session('errors.content') ? 'is-invalid' : '' ?>" id="content"
                            name="content" rows="20"
                            placeholder="Write your post content here..."><?= old('content', $post['content'] ?? '') ?></textarea>
                        <?php if (session('errors.content')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.content') ?>
                            </div>
                        <?php endif; ?>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            <i class="fas fa-info-circle" style="margin-right: 4px;"></i>You can use HTML tags for
                            formatting
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        <input type="file"
                            class="form-control <?= session('errors.featured_image') ? 'is-invalid' : '' ?>"
                            id="featured_image" name="featured_image" accept="image/*">
                        <?php if (session('errors.featured_image')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.featured_image') ?>
                            </div>
                        <?php endif; ?>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            <i class="fas fa-upload" style="margin-right: 4px;"></i>Upload JPG, PNG, or GIF. Max size:
                            2MB
                        </div>

                        <!-- Current Image Preview -->
                        <?php if ($post && $post['featured_image']): ?>
                            <div style="margin-top: 12px;" id="currentImageContainer">
                                <label class="form-label">Current Image:</label>
                                <div style="position: relative; display: inline-block;">
                                    <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="Featured Image"
                                        style="max-width: 300px; max-height: 200px; border-radius: 6px; border: 1px solid var(--border-color);">
                                    <button type="button" onclick="removeCurrentImage()" title="Remove current image"
                                        style="position: absolute; top: 8px; right: 8px; background: var(--error-color); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <i class="fas fa-times" style="font-size: 10px;"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_image" id="removeImageFlag" value="0">
                            </div>
                        <?php endif; ?>

                        <!-- New Image Preview -->
                        <div style="margin-top: 12px; display: none;" id="newImagePreview">
                            <label class="form-label">New Image Preview:</label><br>
                            <img id="imagePreview"
                                style="max-width: 300px; max-height: 200px; border-radius: 6px; border: 1px solid var(--border-color);">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="fas fa-search" style="margin-right: 8px;"></i>SEO Settings (Optional)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2"
                            placeholder="SEO meta description..."
                            maxlength="160"><?= old('meta_description', $post['meta_description'] ?? '') ?></textarea>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            Character count: <span id="metaCount">0</span>/160
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                            value="<?= old('tags', $post['tags'] ?? '') ?>" placeholder="tag1, tag2, tag3...">
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                            Separate tags with commas
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Publish Options -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="fas fa-cog" style="margin-right: 8px;"></i>Publish Options
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            Status <span style="color: var(--error-color);">*</span>
                        </label>
                        <select class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>" id="status"
                            name="status" required>
                            <option value="draft" <?= old('status', $post['status'] ?? 'draft') == 'draft' ? 'selected' : '' ?>>
                                Draft
                            </option>
                            <option value="published" <?= old('status', $post['status'] ?? '') == 'published' ? 'selected' : '' ?>>
                                Published
                            </option>
                        </select>
                        <?php if (session('errors.status')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.status') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">
                            Category <span style="color: var(--error-color);">*</span>
                        </label>
                        <select class="form-control <?= session('errors.category_id') ? 'is-invalid' : '' ?>"
                            id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?php
                                  $selected = old('category_id', $post['category_id'] ?? $selectedCategory ?? '');
                                  echo ($selected == $category['id']) ? 'selected' : '';
                                  ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.category_id')): ?>
                            <div style="color: var(--error-color); font-size: 12px; margin-top: 4px;">
                                <?= session('errors.category_id') ?>
                            </div>
                        <?php endif; ?>
                        <div style="font-size: 12px; margin-top: 4px;">
                            <a href="<?= base_url('admin/categories') ?>" target="_blank"
                                style="color: var(--text-primary); text-decoration: none;">
                                <i class="fas fa-plus" style="margin-right: 4px;"></i>Manage Categories
                            </a>
                        </div>
                    </div>

                    <!-- Publish Date (if editing published post) -->
                    <?php if ($post && $post['published_at']): ?>
                        <div class="mb-3">
                            <label class="form-label">Published Date</label>
                            <input type="text" class="form-control"
                                value="<?= date('M d, Y H:i', strtotime($post['published_at'])) ?>" readonly>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save" style="margin-right: 8px;"></i>
                            <span id="submitText"><?= $post ? 'Update Post' : 'Create Post' ?></span>
                        </button>

                        <?php if ($post): ?>
                            <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times" style="margin-right: 8px;"></i>Cancel
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo" style="margin-right: 8px;"></i>Reset Form
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Post Info (if editing) -->
            <?php if ($post): ?>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Post Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 12px; color: var(--text-secondary);">
                            <div style="margin-bottom: 8px;">
                                <strong>ID:</strong> #<?= $post['id'] ?>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <strong>Created:</strong><br>
                                <?= date('M d, Y H:i', strtotime($post['created_at'])) ?>
                            </div>
                            <?php if ($post['updated_at']): ?>
                                <div style="margin-bottom: 8px;">
                                    <strong>Last Updated:</strong><br>
                                    <?= date('M d, Y H:i', strtotime($post['updated_at'])) ?>
                                </div>
                            <?php endif; ?>
                            <div style="margin-bottom: 16px;">
                                <strong>Slug:</strong><br>
                                <code style="background: var(--hover-bg); padding: 2px 6px; border-radius: 4px;">
                                            <?= esc($post['slug']) ?>
                                        </code>
                            </div>
                            <?php if ($post['status'] == 'published'): ?>
                                <a href="<?= base_url('blog/post/' . $post['slug']) ?>" target="_blank"
                                    class="btn-action btn-action-view" style="width: 100%; justify-content: center;">
                                    <i class="fas fa-external-link-alt"></i>View Post
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quick Tips -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="fas fa-lightbulb" style="margin-right: 8px;"></i>Quick Tips
                    </h6>
                </div>
                <div class="card-body">
                    <div style="font-size: 12px; color: var(--text-secondary);">
                        <ul style="margin: 0; padding-left: 16px;">
                            <li style="margin-bottom: 8px;">
                                Keep titles under 60 characters for better SEO
                            </li>
                            <li style="margin-bottom: 8px;">
                                Write compelling excerpts to engage readers
                            </li>
                            <li style="margin-bottom: 8px;">
                                Use featured images for better social sharing
                            </li>
                            <li style="margin: 0;">
                                Save as draft first, then publish when ready
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function () {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slugPreview').textContent = slug || 'post-slug';
    });

    // Character counters
    function updateCharacterCount(inputId, countId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(countId);

        input.addEventListener('input', function () {
            const count = this.value.length;
            counter.textContent = count;

            if (count > maxLength) {
                counter.style.color = 'var(--error-color)';
            } else if (count > maxLength * 0.8) {
                counter.style.color = 'var(--warning-color)';
            } else {
                counter.style.color = 'var(--success-color)';
            }
        });
    }

    // Initialize character counters
    updateCharacterCount('excerpt', 'excerptCount', 500);
    updateCharacterCount('meta_description', 'metaCount', 160);

    // Image preview functionality
    document.getElementById('featured_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('newImagePreview');
        const img = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Remove current image
    function removeCurrentImage() {
        if (confirm('Are you sure you want to remove the current image?')) {
            document.getElementById('currentImageContainer').style.display = 'none';
            document.getElementById('removeImageFlag').value = '1';
        }
    }

    // Initialize character counts on page load
    document.addEventListener('DOMContentLoaded', function () {
        const excerpt = document.getElementById('excerpt');
        const metaDesc = document.getElementById('meta_description');

        if (excerpt.value) {
            document.getElementById('excerptCount').textContent = excerpt.value.length;
        }

        if (metaDesc && metaDesc.value) {
            document.getElementById('metaCount').textContent = metaDesc.value.length;
        }
    });

    // Reset form function
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
            document.getElementById('postForm').reset();
            document.getElementById('slugPreview').textContent = '';
            document.getElementById('excerptCount').textContent = '0';
            document.getElementById('metaCount').textContent = '0';
            document.getElementById('newImagePreview').style.display = 'none';

            // Reset current image if it was marked for removal
            const currentImageContainer = document.getElementById('currentImageContainer');
            if (currentImageContainer) {
                currentImageContainer.style.display = 'block';
                document.getElementById('removeImageFlag').value = '0';
            }
        }
    }

    // Form submission handling
    document.getElementById('postForm').addEventListener('submit', function (e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        // Disable button and show loading
        submitBtn.disabled = true;
        submitText.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Saving...';

        // Re-enable after 5 seconds (in case of error)
        setTimeout(function () {
            submitBtn.disabled = false;
            submitText.innerHTML = '<?= $post ? "Update Post" : "Create Post" ?>';
        }, 5000);
    });

    // Prevent accidental page leave
    let formChanged = false;
    document.getElementById('postForm').addEventListener('input', function () {
        formChanged = true;
    });

    window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    // Clear form changed flag on successful submit
    document.getElementById('postForm').addEventListener('submit', function () {
        formChanged = false;
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimer;
    function autoSaveDraft() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function () {
            if (formChanged && document.getElementById('title').value.trim()) {
                // Auto-save logic here
                console.log('Auto-saving draft...');
            }
        }, 30000); // Auto-save every 30 seconds
    }

    // Trigger auto-save on form changes
    document.getElementById('postForm').addEventListener('input', autoSaveDraft);
</script>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 300px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<?= $this->endSection() ?>