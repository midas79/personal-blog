<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-newspaper" style="margin-right: 12px;"></i>Posts Management
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus" style="margin-right: 8px;"></i>Create New Post
        </a>
    </div>
</div>

<!-- Filter & Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('admin/posts') ?>" class="search-form">
            <div>
                <label for="search" class="form-label">Search Posts</label>
                <input type="text" class="form-control" name="search" id="search" placeholder="Search posts..."
                    value="<?= esc($search ?? '') ?>">
            </div>
            <div>
                <label for="status" class="form-label">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="">All Status</option>
                    <option value="published" <?= ($status ?? '') == 'published' ? 'selected' : '' ?>>Published</option>
                    <option value="draft" <?= ($status ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            <div>
                <label for="category" class="form-label">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">All Categories</option>
                    <?php if (isset($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($category ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div>
                <button type="submit" class="search-btn" title="Search">
                    <i class="fas fa-search">Search</i>
                </button>
            </div>
            <div>
                <?php if (($search ?? '') || ($status ?? '') || ($category ?? '')): ?>
                    <a href="<?= base_url('admin/posts') ?>" class="clear-btn" title="Clear Filters">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Posts Overview -->
<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="card stats-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Posts</div>
                    <div class="stats-number"><?= count($posts) ?></div>
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
                    <div class="stats-label">Drafts</div>
                    <div class="stats-number">
                        <?= count(array_filter($posts, function ($post) {
                            return $post['status'] == 'draft';
                        })) ?>
                    </div>
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
                    <div class="stats-label">This Week</div>
                    <div class="stats-number">
                        <?= count(array_filter($posts, function ($post) {
                            return strtotime($post['created_at']) > strtotime('-1 week');
                        })) ?>
                    </div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="card">
    <div class="card-header">
        <h6 class="card-title">
            <i class="fas fa-list" style="margin-right: 8px;"></i>All Posts (<?= count($posts) ?>)
            <?php if (($search ?? '') || ($status ?? '') || ($category ?? '')): ?>
                <span class="badge badge-secondary" style="margin-left: 8px;">Filtered</span>
            <?php endif; ?>
        </h6>
    </div>
    <div class="card-body">
        <?php if ($posts): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Title</th>
                            <th width="15%">Category</th>
                            <th width="10%">Status</th>
                            <th width="15%">Created</th>
                            <th width="15%">Author</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $index => $post): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div>
                                        <strong><?= esc($post['title']) ?></strong>
                                        <?php if ($post['excerpt']): ?>
                                            <br><small style="color: var(--text-muted);">
                                                <?= esc(substr($post['excerpt'], 0, 80)) ?>...
                                            </small>
                                        <?php endif; ?>
                                        <?php if ($post['featured_image']): ?>
                                            <br><small style="color: var(--info-color);">
                                                <i class="fas fa-image" style="margin-right: 4px;"></i>Has featured image
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($post['category_name']): ?>
                                        <span class="badge badge-secondary"><?= esc($post['category_name']) ?></span>
                                    <?php else: ?>
                                        <span class="badge"
                                            style="background: var(--hover-bg); color: var(--text-muted);">Uncategorized</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $post['status'] == 'published' ? 'success' : 'warning' ?>">
                                        <i class="fas fa-<?= $post['status'] == 'published' ? 'check-circle' : 'clock' ?>"></i>
                                        <?= ucfirst($post['status']) ?>
                                    </span>
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
                                    <small><?= esc($post['author_name'] ?? 'Unknown') ?></small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Edit Button -->
                                        <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>"
                                            class="btn-action btn-action-edit" title="Edit Post">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>

                                        <!-- View Button (only for published posts) -->
                                        <?php if ($post['status'] == 'published'): ?>
                                            <a href="<?= base_url('blog/post/' . $post['slug']) ?>"
                                                class="btn-action btn-action-view" title="View Post" target="_blank">
                                                <i class="fas fa-eye"></i>View
                                            </a>
                                        <?php endif; ?>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn-action btn-action-delete"
                                            onclick="deletePost(<?= $post['id'] ?>, '<?= esc($post['title']) ?>')"
                                            title="Delete Post">
                                            <i class="fas fa-trash"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center" style="padding: 64px 24px;">
                <i class="fas fa-newspaper" style="font-size: 64px; color: var(--text-muted); margin-bottom: 24px;"></i>
                <h4 style="color: var(--text-muted); margin-bottom: 12px;">No posts found</h4>
                <?php if (($search ?? '') || ($status ?? '') || ($category ?? '')): ?>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">No posts match your filter criteria.</p>
                    <a href="<?= base_url('admin/posts') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>Clear Filters
                    </a>
                <?php else: ?>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">Start creating your first blog post!</p>
                    <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus" style="margin-right: 8px;"></i>Create New Post
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: var(--card-bg); border-radius: 8px; padding: 24px; max-width: 400px; width: 90%;">
        <h5 style="margin-bottom: 16px; color: var(--text-primary);">Confirm Delete</h5>
        <p style="margin-bottom: 16px;">Are you sure you want to delete this post?</p>
        <p style="margin-bottom: 16px;"><strong id="postTitle"></strong></p>
        <p style="color: var(--error-color); font-size: 12px; margin-bottom: 16px;">This action cannot be undone.</p>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button type="button" class="btn btn-outline-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-action-delete">
                    <i class="fas fa-trash" style="margin-right: 8px;"></i>Delete Post
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function deletePost(postId, postTitle) {
        document.getElementById('postTitle').textContent = postTitle;
        document.getElementById('deleteForm').action = '<?= base_url('admin/posts/delete/') ?>' + postId;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modal on outside click
    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
<?= $this->endSection() ?>