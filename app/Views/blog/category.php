<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div style="display: grid; grid-template-columns: 1fr 280px; gap: 48px;">
    <div>
        <!-- Page Header -->
        <div class="section-header">
            <h1 class="section-title"><?= esc($category['name']) ?></h1>
            <p class="section-subtitle">
                <?= $category['description'] ? esc($category['description']) : 'Posts in this category' ?>
            </p>
        </div>

        <!-- Posts List -->
        <?php if ($posts && count($posts) > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 24px; padding:20px;">
                            <?php if (!empty($post['featured_image'])): ?>
                                <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>"
                                    style="width: 200px; height: 200px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <div
                                    style="width: 200px; height: 120px; background: var(--hover-bg); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: var(--text-muted); font-size: 24px;">📄</span>
                                </div>
                            <?php endif; ?>

                            <div class="post-content" style="padding: 0;">
                                <?php if (!empty($post['category_name'])): ?>
                                    <a href="<?= base_url('blog/category/' . $post['category_slug']) ?>" class="post-category">
                                        <?= esc($post['category_name']) ?>
                                    </a>
                                <?php endif; ?>

                                <h3 class="post-title">
                                    <a href="<?= base_url('blog/post/' . $post['slug']) ?>">
                                        <?= esc($post['title']) ?>
                                    </a>
                                </h3>

                                <p class="post-excerpt">
                                    <?= esc(substr($post['excerpt'] ?? '', 0, 120)) ?>
                                    <?= strlen($post['excerpt'] ?? '') > 120 ? '...' : '' ?>
                                </p>

                                <div class="post-meta">
                                    <span><?= esc($post['author_name'] ?? 'Unknown') ?></span>
                                    <span><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination dengan styling yang sama -->
            <?php if ($pagination['totalPages'] > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing page <?= $pagination['currentPage'] ?> of <?= $pagination['totalPages'] ?>
                        (<?= $pagination['totalPosts'] ?> total posts)
                    </div>

                    <nav aria-label="Page navigation" class="pagination-nav">
                        <div class="pagination-wrapper">
                            <?php if ($pagination['hasPrevious']): ?>
                                <a href="<?= current_url() ?>?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>"
                                    class="pagination-link" title="First page">
                                    ««
                                </a>
                                <a href="<?= current_url() ?>?<?= http_build_query(array_merge($_GET, ['page' => $pagination['previousPage']])) ?>"
                                    class="pagination-link" title="Previous page">
                                    ‹
                                </a>
                            <?php endif; ?>

                            <?php
                            $start = max(1, $pagination['currentPage'] - 2);
                            $end = min($pagination['totalPages'], $pagination['currentPage'] + 2);

                            for ($i = $start; $i <= $end; $i++):
                                ?>
                                <a href="<?= current_url() ?>?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                                    class="pagination-link <?= $i == $pagination['currentPage'] ? 'active' : '' ?>"
                                    <?= $i == $pagination['currentPage'] ? 'aria-current="page"' : '' ?>>
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($pagination['hasNext']): ?>
                                <a href="<?= current_url() ?>?<?= http_build_query(array_merge($_GET, ['page' => $pagination['nextPage']])) ?>"
                                    class="pagination-link" title="Next page">
                                    ›
                                </a>
                                <a href="<?= current_url() ?>?<?= http_build_query(array_merge($_GET, ['page' => $pagination['lastPage']])) ?>"
                                    class="pagination-link" title="Last page">
                                    »»
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div style="text-align: center; padding: 64px 0;">
                <span style="font-size: 48px; margin-bottom: 16px; display: block;">📁</span>
                <h4 style="color: var(--text-secondary); margin-bottom: 8px;">No posts in this category</h4>
                <p style="color: var(--text-muted); margin-bottom: 24px;">This category doesn't have any published posts
                    yet.</p>
                <a href="<?= base_url('blog') ?>" class="btn btn-primary">Back to All Posts</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar sama seperti index -->
    <div class="sidebar">
        <!-- Categories -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Categories</h3>
            <?php if ($categories): ?>
                <ul class="category-list">
                    <?php foreach ($categories as $categoryItem): ?>
                        <li class="category-item">
                            <a href="<?= base_url('blog/category/' . $categoryItem['slug']) ?>" class="category-link">
                                <?= esc($categoryItem['name']) ?>
                            </a>
                            <span class="category-count"><?= $categoryItem['post_count'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Recent Posts -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Recent Posts</h3>
            <?php if ($recentPosts): ?>
                <?php foreach (array_slice($recentPosts, 0, 5) as $recentPost): ?>
                    <div class="recent-post">
                        <?php if (!empty($recentPost['featured_image'])): ?>
                            <img src="<?= base_url('uploads/' . $recentPost['featured_image']) ?>" class="recent-post-image"
                                alt="<?= esc($recentPost['title']) ?>">
                        <?php else: ?>
                            <div class="recent-post-image">
                                <span style="color: var(--text-muted); font-size: 16px;">📄</span>
                            </div>
                        <?php endif; ?>
                        <div class="recent-post-content">
                            <h6>
                                <a href="<?= base_url('blog/post/' . $recentPost['slug']) ?>">
                                    <?= esc(substr($recentPost['title'], 0, 40)) ?>
                                    <?= strlen($recentPost['title']) > 40 ? '...' : '' ?>
                                </a>
                            </h6>
                            <div class="recent-post-date">
                                <?= date('M d, Y', strtotime($recentPost['published_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Include same pagination styles -->
<style>
    /* Pagination Styles - Monochrome Theme */
    .pagination-container {
        margin-top: 4rem;
        padding: 2rem;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }

    .pagination-info {
        text-align: center;
        margin-bottom: 1.5rem;
        color: var(--text-muted);
        font-size: 14px;
        font-weight: 500;
    }

    .pagination-nav {
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination-link {
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-primary);
        text-decoration: none;
        background: var(--card-bg);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 48px;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
    }

    .pagination-link:hover {
        background: var(--hover-bg);
        border-color: var(--text-secondary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .pagination-link.active {
        background: var(--text-primary);
        color: var(--card-bg);
        border-color: var(--text-primary);
    }

    .pagination-link.active:hover {
        background: var(--text-primary);
        color: var(--card-bg);
        border-color: var(--text-primary);
        transform: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    [data-theme="dark"] .pagination-container {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .pagination-link:hover {
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .pagination-link.active:hover {
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.2);
    }

    @media (max-width: 768px) {
        .pagination-container {
            padding: 1.5rem;
            margin-top: 3rem;
        }

        .pagination-wrapper {
            gap: 6px;
        }

        .pagination-link {
            padding: 10px 12px;
            min-width: 40px;
            font-size: 13px;
        }

        .pagination-info {
            font-size: 13px;
            margin-bottom: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>