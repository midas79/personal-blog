<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>New Post
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Posts</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $totalPosts ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Published</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $publishedPosts ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-3">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Drafts</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $draftPosts ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Categories</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $totalCategories ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Posts -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-clock me-2"></i>Recent Posts
        </h6>
        <a href="<?= base_url('admin/posts') ?>" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body">
        <?php if ($recentPosts): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentPosts as $post): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($post['title']) ?></strong>
                                    <?php if ($post['excerpt']): ?>
                                        <br><small class="text-muted"><?= esc(substr($post['excerpt'], 0, 60)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($post['category_name']): ?>
                                        <span class="badge bg-secondary"><?= esc($post['category_name']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark">Uncategorized</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $post['status'] == 'published' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($post['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small><?= date('M d, Y', strtotime($post['created_at'])) ?></small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>"
                                            class="btn-action btn-action-edit" title="Edit">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <?php if ($post['status'] == 'published'): ?>
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
            <div class="text-center py-4">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No posts yet</h5>
                <p class="text-muted">Start by creating your first blog post!</p>
                <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Post
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>