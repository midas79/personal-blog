<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt" style="margin-right: 12px;"></i>Dashboard
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus" style="margin-right: 8px;"></i>New Post
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="card stats-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Posts</div>
                    <div class="stats-number"><?= $totalPosts ?></div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card stats-card-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Published</div>
                    <div class="stats-number"><?= $publishedPosts ?></div>
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
                    <div class="stats-label">Drafts</div>
                    <div class="stats-number"><?= $draftPosts ?></div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card stats-card-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Categories</div>
                    <div class="stats-number"><?= $totalCategories ?></div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Grid -->
<div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px; margin-bottom: 32px;">
    <!-- Recent Posts -->
    <!-- Recent Posts -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title">
                    <i class="fas fa-clock" style="margin-right: 8px;"></i>Recent Posts
                </h6>
                <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary btn-sm">
                    View All
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($recentPosts) && is_array($recentPosts)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPosts as $post): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?= esc($post['title'] ?? 'Untitled') ?></strong>
                                            <?php if (!empty($post['category_name'])): ?>
                                                <br><span class="badge badge-secondary"><?= esc($post['category_name']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-<?= ($post['status'] ?? 'draft') == 'published' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($post['status'] ?? 'draft') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            <?php if (!empty($post['created_at'])): ?>
                                                <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/posts/edit/' . ($post['id'] ?? '')) ?>"
                                                class="btn-action btn-action-edit" title="Edit">
                                                <i class="fas fa-edit"></i>Edit
                                            </a>
                                            <?php if (($post['status'] ?? '') == 'published' && !empty($post['slug'])): ?>
                                                <a href="<?= base_url('blog/post/' . $post['slug']) ?>"
                                                    class="btn-action btn-action-view" title="View" target="_blank">
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
                <div class="text-center" style="padding: 48px 24px;">
                    <i class="fas fa-newspaper" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
                    <h5 style="color: var(--text-muted); margin-bottom: 8px;">No posts found</h5>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">
                        <?php if (ENVIRONMENT !== 'production'): ?>
                            Debug: recentPosts = <?= var_export($recentPosts, true) ?>
                        <?php else: ?>
                            Start by creating your first blog post!
                        <?php endif; ?>
                    </p>
                    <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus" style="margin-right: 8px;"></i>Create Your First Post
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="fas fa-bolt" style="margin-right: 8px;"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus" style="margin-right: 8px;"></i>Create New Post
                    </a>
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-tags" style="margin-right: 8px;"></i>Manage Categories
                    </a>
                    <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-secondary">
                        <i class="fas fa-external-link-alt" style="margin-right: 8px;"></i>View Blog
                    </a>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="fas fa-info-circle" style="margin-right: 8px;"></i>System Info
                </h6>
            </div>
            <div class="card-body">
                <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.5;">
                    <div style="margin-bottom: 8px;">
                        <strong>CodeIgniter:</strong> <?= \CodeIgniter\CodeIgniter::CI_VERSION ?>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>PHP:</strong> <?= PHP_VERSION ?>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Environment:</strong>
                        <span class="badge badge-<?= ENVIRONMENT === 'production' ? 'success' : 'warning' ?>">
                            <?= ENVIRONMENT ?>
                        </span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>User:</strong> <?= esc($user->username ?? 'Admin') ?>
                    </div>
                    <div>
                        <strong>Login:</strong> <?= date('M d, Y H:i') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 300px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<?= $this->endSection() ?>