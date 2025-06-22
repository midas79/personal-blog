<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tag" style="margin-right: 12px;"></i>Category: <?= esc($category['name']) ?>
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-primary">
            <i class="fas fa-edit" style="margin-right: 8px;"></i>Edit Category
        </a>
        <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to Categories
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 300px 1fr; gap: 24px;">
    <!-- Category Information -->
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">
                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Category Details
            </h6>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <div
                    style="width: 80px; height: 80px; background: var(--text-primary); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="fas fa-tag" style="font-size: 32px; color: var(--card-bg);"></i>
                </div>
                <h4 style="margin-bottom: 4px;"><?= esc($category['name']) ?></h4>
                <p style="color: var(--text-muted); margin: 0;">
                    <code style="background: var(--hover-bg); padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        <?= esc($category['slug']) ?>
                    </code>
                </p>
            </div>

            <?php if ($category['description']): ?>
                <div style="margin-bottom: 24px;">
                    <strong>Description:</strong>
                    <p style="color: var(--text-secondary); margin-top: 8px; line-height: 1.5;">
                        <?= esc($category['description']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <div style="border-top: 1px solid var(--border-color); padding-top: 16px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; text-align: center;">
                    <div style="padding: 12px; border-right: 1px solid var(--border-color);">
                        <h4 style="margin: 0; color: var(--text-primary);"><?= count($posts) ?></h4>
                        <small style="color: var(--text-muted);">Total Posts</small>
                    </div>
                    <div style="padding: 12px;">
                        <h4 style="margin: 0; color: var(--success-color);">
                            <?= count(array_filter($posts, function ($post) {
                                return $post['status'] == 'published';
                            })) ?>
                        </h4>
                        <small style="color: var(--text-muted);">Published</small>
                    </div>
                </div>
            </div>

            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 24px;">
                <div style="margin-bottom: 8px;">
                    <strong>Created:</strong> <?= date('M d, Y H:i', strtotime($category['created_at'])) ?>
                </div>
                <div style="margin-bottom: 8px;">
                    <strong>ID:</strong> #<?= $category['id'] ?>
                </div>
                <div>
                    <strong>Slug:</strong> <?= esc($category['slug']) ?>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit" style="margin-right: 8px;"></i>Edit Category
                </a>
                <a href="<?= base_url('blog/category/' . $category['slug']) ?>" target="_blank"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-external-link-alt" style="margin-right: 8px;"></i>View on Blog
                </a>
            </div>
        </div>
    </div>

    <!-- Posts in this Category -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">
                        <i class="fas fa-newspaper" style="margin-right: 8px;"></i>Posts in this Category
                        (<?= count($posts) ?>)
                    </h6>
                    <div style="position: relative;">
                        <button class="btn-action btn-action-edit" onclick="toggleDropdown()"
                            style="background: var(--hover-bg); color: var(--text-primary); border-color: var(--border-color);">
                            <i class="fas fa-cog"></i>Options
                        </button>
                        <div id="dropdown"
                            style="display: none; position: absolute; top: 100%; right: 0; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 100; min-width: 200px; margin-top: 4px;">
                            <a href="<?= base_url('admin/posts/create?category=' . $category['id']) ?>"
                                style="display: flex; align-items: center; padding: 12px 16px; color: var(--text-primary); text-decoration: none; border-bottom: 1px solid var(--border-color); transition: background 0.2s ease;">
                                <i class="fas fa-plus" style="margin-right: 8px; width: 16px;"></i>Add Post to Category
                            </a>
                            <a href="<?= base_url('admin/posts?category=' . $category['id']) ?>"
                                style="display: flex; align-items: center; padding: 12px 16px; color: var(--text-primary); text-decoration: none; transition: background 0.2s ease;">
                                <i class="fas fa-filter" style="margin-right: 8px; width: 16px;"></i>Filter Posts by
                                Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if ($posts): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Author</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <strong><?= esc($post['title']) ?></strong>
                                                <?php if ($post['excerpt']): ?>
                                                    <br><small style="color: var(--text-muted);">
                                                        <?= esc(substr($post['excerpt'], 0, 80)) ?>...
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-<?= $post['status'] == 'published' ? 'success' : 'warning' ?>">
                                                <i class="fas fa-<?= $post['status'] == 'published' ? 'check-circle' : 'clock' ?>"
                                                    style="margin-right: 4px;"></i>
                                                <?= ucfirst($post['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small><?= esc($post['author_name'] ?? 'Unknown') ?></small>
                                        </td>
                                        <td>
                                            <small>
                                                <?= date('M d, Y', strtotime($post['created_at'])) ?><br>
                                                <span style="color: var(--text-muted);">
                                                    <?= date('H:i', strtotime($post['created_at'])) ?>
                                                </span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>"
                                                    class="btn-action btn-action-edit" title="Edit Post">
                                                    <i class="fas fa-edit"></i>Edit
                                                </a>
                                                <?php if ($post['status'] == 'published'): ?>
                                                    <a href="<?= base_url('blog/post/' . $post['slug']) ?>"
                                                        class="btn-action btn-action-view" title="View Post" target="_blank">
                                                        <i class="fas fa-eye"></i>View
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center" style="padding: 64px 24px;">
                        <i class="fas fa-newspaper"
                            style="font-size: 64px; color: var(--text-muted); margin-bottom: 24px;"></i>
                        <h5 style="color: var(--text-muted); margin-bottom: 12px;">No posts in this category</h5>
                        <p style="color: var(--text-muted); margin-bottom: 24px;">Start by creating a post in this category!
                        </p>
                        <a href="<?= base_url('admin/posts/create?category=' . $category['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-plus" style="margin-right: 8px;"></i>Create Post in this Category
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Category Statistics -->
        <?php if ($posts): ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="card stats-card-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-label">Published Posts</div>
                                <div class="stats-number">
                                    <?= count(array_filter($posts, function ($post) {
                                        return $post['status'] == 'published';
                                    })) ?>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card stats-card-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-label">Draft Posts</div>
                                <div class="stats-number">
                                    <?= count(array_filter($posts, function ($post) {
                                        return $post['status'] == 'draft';
                                    })) ?>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdown');
        const button = e.target.closest('button');

        if (!button || !button.onclick) {
            dropdown.style.display = 'none';
        }
    });
</script>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 300px 1fr"] {
            grid-template-columns: 1fr !important;
        }

        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<?= $this->endSection() ?>