<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - My Blog</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

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
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --info-color: #3b82f6;
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
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --info-color: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 14px;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }

        .sidebar-brand {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
            margin-bottom: 4px;
            display: block;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: var(--text-muted);
        }

        .sidebar-nav {
            padding: 16px 0;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background-color: var(--hover-bg);
            text-decoration: none;
        }

        .nav-link.active {
            color: var(--text-primary);
            background-color: var(--hover-bg);
            border-left-color: var(--text-primary);
            font-weight: 500;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .nav-divider {
            height: 1px;
            background: var(--border-color);
            margin: 16px 24px;
        }

        /* Theme Toggle Improvements */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            padding: 12px 24px;
            transition: all 0.2s ease;
            font-family: inherit;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            border-left: 3px solid transparent;
        }

        .theme-toggle:hover {
            color: var(--text-primary);
            background-color: var(--hover-bg);
        }

        .theme-toggle i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            transition: all 0.2s ease;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 32px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 24px;
            margin-bottom: 32px;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Button Improvements */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            min-height: 36px;
            box-sizing: border-box;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            min-height: 28px;
        }

        .btn-primary {
            background: var(--text-primary);
            color: var(--card-bg);
            border-color: var(--text-primary);
        }

        .btn-primary:hover {
            background: var(--text-secondary);
            border-color: var(--text-secondary);
            color: var(--card-bg);
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-outline-secondary:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
            border-color: var(--text-primary);
            text-decoration: none;
        }

        /* Action Buttons with Labels */
        .btn-group {
            display: flex;
            gap: 4px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            min-height: 28px;
            box-sizing: border-box;
        }

        .btn-action i {
            margin-right: 4px;
            font-size: 11px;
        }

        .btn-action-edit {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info-color);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .btn-action-edit:hover {
            background: var(--info-color);
            color: white;
            border-color: var(--info-color);
            text-decoration: none;
        }

        .btn-action-view {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .btn-action-view:hover {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
            text-decoration: none;
        }

        .btn-action-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .btn-action-delete:hover {
            background: var(--error-color);
            color: white;
            border-color: var(--error-color);
        }

        /* Search Form Improvements */
        .search-form {
            display: grid;
            grid-template-columns: 1fr auto auto auto auto;
            gap: 16px;
            align-items: end;
        }

        .search-btn {
            background: var(--text-primary);
            color: var(--card-bg);
            border: 1px solid var(--text-primary);
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
        }

        .search-btn:hover {
            background: var(--text-secondary);
            border-color: var(--text-secondary);
            transform: translateY(-1px);
        }

        .clear-btn {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            text-decoration: none;
        }

        .clear-btn:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
            border-color: var(--text-primary);
            text-decoration: none;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .card-body {
            padding: 24px;
        }

        /* Stats Cards */
        .stats-card {
            background: var(--text-primary);
            color: var(--card-bg);
            border: none;
        }

        .stats-card-2 {
            background: var(--success-color);
            color: white;
            border: none;
        }

        .stats-card-3 {
            background: var(--warning-color);
            color: white;
            border: none;
        }

        .stats-card-4 {
            background: var(--info-color);
            color: white;
            border: none;
        }

        .stats-number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stats-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-icon {
            font-size: 24px;
            opacity: 0.7;
        }

        /* Form Controls */
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
            transition: all 0.2s ease;
            height: 44px;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table th {
            font-weight: 600;
            color: var(--text-primary);
            background: var(--hover-bg);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background: var(--hover-bg);
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--error-color);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.2);
            color: var(--warning-color);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
            color: var(--info-color);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .badge i {
            margin-right: 4px;
            font-size: 10px;
        }

        .badge-success {
            background: var(--success-color);
            color: white;
        }

        .badge-warning {
            background: var(--warning-color);
            color: white;
        }

        .badge-secondary {
            background: var(--text-secondary);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .search-form {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .btn-group {
                flex-wrap: wrap;
            }

            .btn-action {
                font-size: 11px;
                padding: 4px 8px;
            }
        }

        /* Utilities */
        .mb-4 {
            margin-bottom: 24px;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .mb-2 {
            margin-bottom: 12px;
        }

        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .gap-2 {
            gap: 8px;
        }

        .gap-3 {
            gap: 12px;
        }

        /* Dropdown Hover Effects */
        #dropdown a:hover {
            background: var(--hover-bg) !important;
        }

        #dropdown a:first-child:hover {
            border-radius: 6px 6px 0 0;
        }

        #dropdown a:last-child:hover {
            border-radius: 0 0 6px 6px;
        }

        #dropdown a:only-child:hover {
            border-radius: 6px;
        }

        /* Action Button Full Width */
        .btn-action[style*="width: 100%"] {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-brand">Admin Panel</a>
            <div class="sidebar-subtitle">Welcome, <?= session()->get('username') ?? 'Admin' ?></div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin' || uri_string() == 'admin/dashboard') ? 'active' : '' ?>"
                    href="<?= base_url('admin/dashboard') ?>">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link <?= (strpos(uri_string(), 'admin/posts') !== false) ? 'active' : '' ?>"
                    href="<?= base_url('admin/posts') ?>">
                    <i class="fas fa-newspaper"></i>Posts
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link <?= (strpos(uri_string(), 'admin/categories') !== false) ? 'active' : '' ?>"
                    href="<?= base_url('admin/categories') ?>">
                    <i class="fas fa-tags"></i>Categories
                </a>
            </div>

            <div class="nav-divider"></div>

            <div class="nav-item">
                <button class="theme-toggle" onclick="toggleDarkMode()">
                    <i class="fas fa-moon" id="theme-icon"></i>
                    <span id="theme-text">Dark Mode</span>
                </button>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="<?= base_url() ?>" target="_blank">
                    <i class="fas fa-external-link-alt"></i>View Blog
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="<?= base_url('simple-logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            const body = document.body;
            const themeText = document.getElementById('theme-text');
            const themeIcon = document.getElementById('theme-icon');

            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                themeText.textContent = 'Dark Mode';
                themeIcon.className = 'fas fa-moon';
                localStorage.setItem('admin-theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Light Mode';
                themeIcon.className = 'fas fa-sun';
                localStorage.setItem('admin-theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function () {
            const savedTheme = localStorage.getItem('admin-theme');
            const themeText = document.getElementById('theme-text');
            const themeIcon = document.getElementById('theme-icon');

            if (savedTheme === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Light Mode';
                themeIcon.className = 'fas fa-sun';
            } else {
                themeText.textContent = 'Dark Mode';
                themeIcon.className = 'fas fa-moon';
            }

            // Auto dismiss alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>