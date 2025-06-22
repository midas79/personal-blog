<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="hero">
    <h1 class="hero-title">THE CODEX</h1>
    <p class="hero-subtitle">
        Sharing insights, experiences, and knowledge about web development,
        design, and technology trends.
    </p>
</div>

<!-- Recent Blog Posts -->
<div class="section-header">
    <h2 class="section-title">Recent blog posts</h2>
    <p class="section-subtitle">Latest articles and insights</p>
</div>

<?php if ($posts): ?>
    <div class="posts-grid">
        <?php foreach (array_slice($posts, 0, 6) as $post): ?>
            <article class="post-card">
                <?php if ($post['featured_image']): ?>
                    <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>"
                        class="post-image">
                <?php else: ?>
                    <div class="post-image">
                        <span style="color: var(--text-muted); font-size: 24px;">📄</span>
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <?php if ($post['category_name']): ?>
                        <a href="<?= base_url('blog/category/' . url_title($post['category_name'], '-', true)) ?>"
                            class="post-category">
                            <?= esc($post['category_name']) ?>
                        </a>
                    <?php endif; ?>

                    <h3 class="post-title">
                        <a href="<?= base_url('blog/post/' . $post['slug']) ?>">
                            <?= esc($post['title']) ?>
                        </a>
                    </h3>

                    <p class="post-excerpt">
                        <?= esc(substr($post['excerpt'], 0, 100)) ?>        <?= strlen($post['excerpt']) > 100 ? '...' : '' ?>
                    </p>

                    <div class="post-meta">
                        <span><?= esc($post['author_name']) ?></span>
                        <span><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="text-align: center; margin-top: 32px;">
    <a href="<?= base_url('blog') ?>" class="btn btn-primary">View All Posts</a>
</div>
<?= $this->endSection() ?>