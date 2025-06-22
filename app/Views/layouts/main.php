<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Personal Blog' ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+JP&display=swap" rel="stylesheet">

    <!-- Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #666666;
            --bg-color: #fafafa;
            --card-bg: #ffffff;
            --text-primary: #000000;
            --text-secondary: #666666;
            --text-muted: #999999;
            --border-color: #e5e5e5;
            --hover-bg: #f5f5f5;
        }

        [data-theme="dark"] {
            --primary-color: #ffffff;
            --secondary-color: #cccccc;
            --bg-color: #0a0a0a;
            --card-bg: #111111;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --text-muted: #888888;
            --border-color: #222222;
            --hover-bg: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "IBM Plex Sans JP", -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation */
        .nav-container {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            font-weight: 600;
            font-size: 16px;
            color: var(--text-primary);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 400;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--text-primary);
        }

        /* Theme Toggle - Minimalist Text Style */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s ease;
            font-family: inherit;
        }

        .theme-toggle:hover {
            color: var(--text-primary);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 48px 24px;
            width: 100%;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            margin-bottom: 64px;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            letter-spacing: -0.025em;
            margin-bottom: 16px;
            color: var(--text-primary);
        }

        .hero-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .section-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Grid Layout */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
            margin-bottom: 48px;
        }

        /* Card Styles */
        .post-card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: var(--hover-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .post-content {
            padding: 24px;
        }

        .post-category {
            display: inline-block;
            background: var(--hover-bg);
            color: var(--text-secondary);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 16px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .post-category:hover {
            background: var(--text-primary);
            color: var(--card-bg);
        }

        .post-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .post-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .post-title a:hover {
            color: var(--text-secondary);
        }

        .post-excerpt {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* All Posts Preview Section */
        .all-posts-preview {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 32px;
            text-align: center;
            margin-bottom: 32px;
        }

        .all-posts-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 24px;
            margin: 24px 0;
        }

        .stat-item {
            padding: 16px;
            background: var(--hover-bg);
            border-radius: 6px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            display: block;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* Sidebar */
        .sidebar {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 24px;
            height: fit-content;
            position: sticky;
            top: 88px;
        }

        .sidebar-section {
            margin-bottom: 32px;
        }

        .sidebar-section:last-child {
            margin-bottom: 0;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-link {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .category-link:hover {
            color: var(--text-secondary);
        }

        .category-count {
            background: var(--hover-bg);
            color: var(--text-secondary);
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Recent Posts */
        .recent-post {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .recent-post:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .recent-post-image {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--hover-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .recent-post-content h6 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .recent-post-content h6 a {
            color: var(--text-primary);
            text-decoration: none;
        }

        .recent-post-content h6 a:hover {
            color: var(--text-secondary);
        }

        .recent-post-date {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Search */
        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--text-primary);
        }

        .search-btn {
            padding: 12px 24px;
            background: var(--text-primary);
            color: var(--card-bg);
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-btn:hover {
            transform: translateY(-1px);
        }

        /* Footer */
        .footer {
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 32px 0;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-links {
            display: flex;
            gap: 24px;
            list-style: none;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--text-primary);
        }

        .footer-copyright {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--text-primary);
            color: var(--card-bg);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            color: var(--card-bg);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                padding: 0 16px;
            }

            .nav-links {
                gap: 16px;
            }

            .main-content {
                padding: 32px 16px;
            }

            .hero-title {
                font-size: 32px;
            }

            .posts-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .all-posts-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                flex-direction: column;
                gap: 16px;
                text-align: center;
                padding: 0 16px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* All Posts Grid Layout */
        .all-posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 48px;
        }

        .all-post-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.2s ease;
            position: relative;
        }

        .all-post-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: var(--text-muted);
        }

        /* Featured post yang lebih besar setiap 7 post */
        .all-post-card.featured {
            grid-column: span 2;
        }

        .all-post-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: var(--hover-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .all-post-card.featured .all-post-image {
            height: 180px;
        }

        .all-post-content {
            padding: 16px;
        }

        .all-post-category {
            display: inline-block;
            background: var(--hover-bg);
            color: var(--text-secondary);
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .all-post-category:hover {
            background: var(--text-primary);
            color: var(--card-bg);
        }

        .all-post-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .all-post-card.featured .all-post-title {
            font-size: 16px;
        }

        .all-post-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .all-post-title a:hover {
            color: var(--text-secondary);
        }

        .all-post-excerpt {
            color: var(--text-secondary);
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .all-post-card.featured .all-post-excerpt {
            font-size: 13px;
        }

        .all-post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: var(--text-muted);
        }

        .no-more-posts {
            margin-bottom: 32px;
        }

        /* Responsive untuk All Posts Grid */
        @media (max-width: 768px) {
            .all-posts-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .all-post-card.featured {
                grid-column: span 1;
            }

            .all-post-image,
            .all-post-card.featured .all-post-image {
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            .all-post-content {
                padding: 12px;
            }

            .all-post-image,
            .all-post-card.featured .all-post-image {
                height: 100px;
            }
        }

        /* Staggered animation untuk all posts */
        .all-post-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .all-post-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .all-post-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .all-post-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .all-post-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .all-post-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .all-post-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .all-post-card:nth-child(n+7) {
            animation-delay: 0.7s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="nav-content">
            <a href="<?= base_url() ?>" class="nav-brand">CODEX</a>

            <ul class="nav-links">
                <li><a href="<?= base_url('blog') ?>"
                        class="<?= (strpos(current_url(), 'blog') !== false) ? 'active' : '' ?>">Blog</a></li>
                <li><a href="<?= base_url('about') ?>"
                        class="<?= (strpos(current_url(), 'about') !== false) ? 'active' : '' ?>">About</a></li>
                <li>
                    <button class="theme-toggle" onclick="toggleDarkMode()">
                        <span id="theme-text">Dark</span>
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-copyright">
                © <?= date('Y') ?> dionysus. All rights reserved.
            </div>
            <ul class="footer-links">
                <li><a href="https://x.com/grriffitth">Twitter</a></li>
                <li><a href="https://www.linkedin.com/in/dionisiussj/">LinkedIn</a></li>
                <li><a href="mailto:dionisius.suryajaya@gmail.com">Email</a></li>
            </ul>
        </div>
    </footer>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            const body = document.body;
            const themeText = document.getElementById('theme-text');

            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                themeText.textContent = 'Light';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Dark';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function () {
            const savedTheme = localStorage.getItem('theme');
            const themeText = document.getElementById('theme-text');

            if (savedTheme === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Dark';
            } else {
                themeText.textContent = 'Light';
            }

            // Add fade-in animation
            const cards = document.querySelectorAll('.post-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>