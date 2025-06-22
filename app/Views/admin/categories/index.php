<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tags" style="margin-right: 12px;"></i>Categories Management
    </h1>
    <div class="page-actions">
        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus" style="margin-right: 8px;"></i>Create New Category
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('admin/categories') ?>">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: end;">
                <div>
                    <label for="search" class="form-label">Search Categories</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search categories..."
                        value="<?= esc($search ?? '') ?>">
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search">Search</i>
                    </button>
                    <?php if ($search): ?>
                        <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Categories Overview -->
<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="card stats-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Categories</div>
                    <div class="stats-number"><?= count($categories) ?></div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card stats-card-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">With Posts</div>
                    <div class="stats-number">
                        <?= count(array_filter($categories, function ($cat) {
                            return $cat['post_count'] > 0;
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
                    <div class="stats-label">Empty Categories</div>
                    <div class="stats-number">
                        <?= count(array_filter($categories, function ($cat) {
                            return $cat['post_count'] == 0;
                        })) ?>
                    </div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card stats-card-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Posts</div>
                    <div class="stats-number"><?= array_sum(array_column($categories, 'post_count')) ?></div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header">
        <h6 class="card-title">
            <i class="fas fa-list" style="margin-right: 8px;"></i>All Categories
            <?php if ($search): ?>
                <span class="badge badge-secondary" style="margin-left: 8px;">Search: "<?= esc($search) ?>"</span>
            <?php endif; ?>
        </h6>
    </div>
    <div class="card-body">
        <?php if ($categories): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Name</th>
                            <th width="25%">Slug</th>
                            <th width="30%">Description</th>
                            <th width="10%">Posts</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $index => $category): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div
                                            style="width: 32px; height: 32px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                            <i class="fas fa-tag" style="color: var(--card-bg); font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <strong><?= esc($category['name']) ?></strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code
                                        style="background: var(--hover-bg); padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                                                        <?= esc($category['slug']) ?>
                                                    </code>
                                </td>
                                <td>
                                    <?php if ($category['description']): ?>
                                        <span style="font-size: 13px; color: var(--text-secondary);">
                                            <?= esc(substr($category['description'], 0, 100)) ?>
                                            <?= strlen($category['description']) > 100 ? '...' : '' ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="font-size: 13px; color: var(--text-muted); font-style: italic;">No
                                            description</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($category['post_count'] > 0): ?>
                                        <a href="<?= base_url('admin/categories/show/' . $category['id']) ?>"
                                            class="badge badge-success" style="text-decoration: none;">
                                            <?= $category['post_count'] ?> posts
                                        </a>
                                    <?php else: ?>
                                        <span class="badge" style="background: var(--hover-bg); color: var(--text-muted);">0
                                            posts</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- View Button -->
                                        <a href="<?= base_url('admin/categories/show/' . $category['id']) ?>"
                                            class="btn-action btn-action-view" title="View Category">
                                            <i class="fas fa-eye"></i>View
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>"
                                            class="btn-action btn-action-edit" title="Edit Category">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn-action btn-action-delete"
                                            onclick="deleteCategory(<?= $category['id'] ?>, '<?= esc($category['name']) ?>', <?= $category['post_count'] ?>)"
                                            title="Delete Category">
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
                <i class="fas fa-tags" style="font-size: 64px; color: var(--text-muted); margin-bottom: 24px;"></i>
                <h4 style="color: var(--text-muted); margin-bottom: 12px;">No categories found</h4>
                <?php if ($search): ?>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">No categories match your search criteria.</p>
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to All Categories
                    </a>
                <?php else: ?>
                    <p style="color: var(--text-muted); margin-bottom: 24px;">Start by creating your first category!</p>
                    <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus" style="margin-right: 8px;"></i>Create Your First Category
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
        <div id="deleteContent">
            <p style="margin-bottom: 16px;">Are you sure you want to delete this category?</p>
            <p style="margin-bottom: 16px;"><strong id="categoryName"></strong></p>
            <div id="warningMessage"
                style="display: none; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); color: var(--warning-color); padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
                <strong>Warning:</strong> This category has <span id="postCount"></span> post(s).
                You cannot delete it until you move or delete all posts in this category.
            </div>
            <p id="deleteWarning" style="color: var(--error-color); font-size: 12px; margin-bottom: 16px;">This action
                cannot be undone.</p>
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button type="button" class="btn btn-outline-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn" id="deleteButton"
                    style="background: var(--error-color); color: white; border-color: var(--error-color);">
                    <i class="fas fa-trash" style="margin-right: 8px;"></i>Delete Category
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function deleteCategory(categoryId, categoryName, postCount) {
        document.getElementById('categoryName').textContent = categoryName;
        document.getElementById('deleteForm').action = '<?= base_url('admin/categories/delete/') ?>' + categoryId;

        const warningMessage = document.getElementById('warningMessage');
        const deleteButton = document.getElementById('deleteButton');
        const deleteWarning = document.getElementById('deleteWarning');

        if (postCount > 0) {
            // Category has posts, show warning and disable delete
            document.getElementById('postCount').textContent = postCount;
            warningMessage.style.display = 'block';
            deleteButton.disabled = true;
            deleteButton.innerHTML = '<i class="fas fa-ban" style="margin-right: 8px;"></i>Cannot Delete';
            deleteButton.style.background = 'var(--text-muted)';
            deleteWarning.style.display = 'none';
        } else {
            // Category is empty, allow delete
            warningMessage.style.display = 'none';
            deleteButton.disabled = false;
            deleteButton.innerHTML = '<i class="fas fa-trash" style="margin-right: 8px;"></i>Delete Category';
            deleteButton.style.background = 'var(--error-color)';
            deleteWarning.style.display = 'block';
        }

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