<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div style="display: grid; grid-template-columns: 1fr 280px; gap: 48px;">
    <div>
        <!-- Post Content -->
        <article class="post-card" style="margin-bottom: 48px;">
            <!-- Featured Image -->
            <?php if ($post['featured_image']): ?>
                <img src="<?= base_url('uploads/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>"
                    style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px 8px 0 0;">
            <?php endif; ?>

            <div class="post-content" style="padding: 32px;">
                <!-- Post Meta -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div>
                        <?php if ($post['category_name']): ?>
                            <a href="<?= base_url('blog/category/' . url_title($post['category_name'], '-', true)) ?>"
                                class="post-category" style="margin-right: 8px;">
                                <?= esc($post['category_name']) ?>
                            </a>
                        <?php endif; ?>
                        <span class="post-category" style="background: #22c55e; color: white;">Published</span>
                    </div>
                    <div style="text-align: right; font-size: 12px; color: var(--text-muted);">
                        <div><?= date('F d, Y', strtotime($post['published_at'])) ?></div>
                        <div><?= date('g:i A', strtotime($post['published_at'])) ?></div>
                    </div>
                </div>

                <!-- Post Title -->
                <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 24px; line-height: 1.2;">
                    <?= esc($post['title']) ?>
                </h1>

                <!-- Author Info -->
                <div
                    style="display: flex; align-items: center; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
                    <div
                        style="width: 40px; height: 40px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                        <span style="color: var(--card-bg); font-size: 16px;">👤</span>
                    </div>
                    <div>
                        <div style="font-weight: 500; font-size: 14px;"><?= esc($post['author_name']) ?></div>
                        <div style="font-size: 12px; color: var(--text-muted);">Author</div>
                    </div>
                    <div style="margin-left: auto;">
                        <!-- Social Share -->
                        <div style="display: flex; gap: 8px;">
                            <button onclick="sharePost('facebook')"
                                style="width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--card-bg); cursor: pointer; display: flex; align-items: center; justify-content: center;">📘</button>
                            <button onclick="sharePost('twitter')"
                                style="width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--card-bg); cursor: pointer; display: flex; align-items: center; justify-content: center;">🐦</button>
                            <button onclick="copyLink()"
                                style="width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--card-bg); cursor: pointer; display: flex; align-items: center; justify-content: center;">🔗</button>
                        </div>
                    </div>
                </div>

                <!-- Post Excerpt -->
                <?php if ($post['excerpt']): ?>
                    <div
                        style="background: var(--hover-bg); padding: 20px; border-radius: 8px; border-left: 4px solid var(--text-primary); margin-bottom: 32px;">
                        <p style="margin: 0; font-weight: 500; color: var(--text-secondary);"><?= esc($post['excerpt']) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="post-content-body" style="line-height: 1.7; font-size: 16px;">
                    <?= $post['content'] ?>
                </div>

                <!-- Post Tags -->
                <?php if (!empty($post['tags'])): ?>
                    <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-color);">
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 12px;">Tags:</div>
                        <?php
                        $tags = explode(',', $post['tags']);
                        foreach ($tags as $tag):
                            $tag = trim($tag);
                            if ($tag):
                                ?>
                                <span class="post-category" style="margin-right: 8px; margin-bottom: 8px; display: inline-block;">
                                    #<?= esc($tag) ?>
                                </span>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Post Actions -->
                <div
                    style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= base_url('blog') ?>" class="btn btn-outline">← Back to Blog</a>
                    <div style="font-size: 12px; color: var(--text-muted);">
                        Last updated:
                        <?= $post['updated_at'] ? date('M d, Y', strtotime($post['updated_at'])) : date('M d, Y', strtotime($post['created_at'])) ?>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Posts -->
        <?php if ($relatedPosts): ?>
            <div class="post-card">
                <div class="post-content">
                    <h3 style="margin-bottom: 24px;">Related Posts</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                        <?php foreach ($relatedPosts as $relatedPost): ?>
                            <div style="border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                                <?php if ($relatedPost['featured_image']): ?>
                                    <img src="<?= base_url('uploads/' . $relatedPost['featured_image']) ?>"
                                        alt="<?= esc($relatedPost['title']) ?>"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div
                                        style="width: 100%; height: 120px; background: var(--hover-bg); display: flex; align-items: center; justify-content: center;">
                                        <span style="color: var(--text-muted); font-size: 24px;">📄</span>
                                    </div>
                                <?php endif; ?>
                                <div style="padding: 16px;">
                                    <h6 style="font-size: 14px; font-weight: 500; margin-bottom: 8px;">
                                        <a href="<?= base_url('blog/post/' . $relatedPost['slug']) ?>"
                                            style="color: var(--text-primary); text-decoration: none;">
                                            <?= esc(substr($relatedPost['title'], 0, 50)) ?>        <?= strlen($relatedPost['title']) > 50 ? '...' : '' ?>
                                        </a>
                                    </h6>
                                    <div style="font-size: 12px; color: var(--text-muted);">
                                        <?= date('M d, Y', strtotime($relatedPost['published_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Post Info -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Post Information</h3>
            <div
                style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; text-align: center; margin-bottom: 16px;">
                <div>
                    <div style="font-size: 20px; margin-bottom: 4px;">📅</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Published</div>
                    <div style="font-size: 14px; font-weight: 500;">
                        <?= date('M d, Y', strtotime($post['published_at'])) ?></div>
                </div>
                <div>
                    <div style="font-size: 20px; margin-bottom: 4px;">👤</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Author</div>
                    <div style="font-size: 14px; font-weight: 500;"><?= esc($post['author_name']) ?></div>
                </div>
            </div>

            <?php if ($post['category_name']): ?>
                <div style="text-align: center;">
                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">Category</div>
                    <a href="<?= base_url('blog/category/' . url_title($post['category_name'], '-', true)) ?>"
                        class="btn btn-outline" style="font-size: 12px; padding: 8px 16px;">
                        <?= esc($post['category_name']) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Categories -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Categories</h3>
            <?php if ($categories): ?>
                <ul class="category-list">
                    <?php foreach (array_slice($categories, 0, 5) as $category): ?>
                        <li class="category-item">
                            <a href="<?= base_url('blog/category/' . $category['slug']) ?>" class="category-link">
                                <?= esc($category['name']) ?>
                            </a>
                            <span class="category-count"><?= $category['post_count'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Recent Posts -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Recent Posts</h3>
            <?php if ($recentPosts): ?>
                <?php foreach (array_slice($recentPosts, 0, 3) as $recentPost): ?>
                    <div class="recent-post">
                        <?php if ($recentPost['featured_image']): ?>
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
                                    <?= esc(substr($recentPost['title'], 0, 40)) ?>        <?= strlen($recentPost['title']) > 40 ? '...' : '' ?>
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

<style>
    .post-content-body h1,
    .post-content-body h2,
    .post-content-body h3,
    .post-content-body h4,
    .post-content-body h5,
    .post-content-body h6 {
        margin-top: 32px;
        margin-bottom: 16px;
        color: var(--text-primary);
        font-weight: 600;
    }

    .post-content-body p {
        margin-bottom: 16px;
    }

    .post-content-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 16px 0;
    }

    .post-content-body blockquote {
        border-left: 4px solid var(--text-primary);
        padding-left: 16px;
        margin: 24px 0;
        font-style: italic;
        color: var(--text-secondary);
    }

    .post-content-body code {
        background-color: var(--hover-bg);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 14px;
        color: #e83e8c;
    }

    .post-content-body pre {
        background-color: var(--hover-bg);
        padding: 16px;
        border-radius: 8px;
        overflow-x: auto;
        margin: 24px 0;
    }

    @media (max-width: 768px) {
        .main-content>div {
            display: block !important;
        }

        .sidebar {
            margin-top: 48px;
            position: static !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function sharePost(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('<?= addslashes($post['title']) ?>');

        let shareUrl = '';
        switch (platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
        }

        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function () {
            const btn = event.target;
            btn.textContent = '✅';
            setTimeout(() => btn.textContent = '🔗', 2000);
        });
    }
</script>
<?= $this->endSection() ?>