<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - My Blog</title>

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
            --error-color: #ef4444;
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
            --error-color: #ef4444;
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

        .nav-links a:hover {
            color: var(--text-primary);
        }

        /* Theme Toggle */
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
        }

        /* Login Card */
        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        /* Button */
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
            width: 100%;
            text-align: center;
        }

        .btn-primary {
            background: var(--text-primary);
            color: var(--card-bg);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            position: relative;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success-color);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-color);
        }

        .alert-dismiss {
            position: absolute;
            top: 8px;
            right: 12px;
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 16px;
            opacity: 0.7;
        }

        .alert-dismiss:hover {
            opacity: 1;
        }

        /* Demo Credentials */
        .demo-credentials {
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 16px;
            margin-top: 20px;
        }

        .demo-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .demo-text {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .back-link a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .back-link a:hover {
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                padding: 0 16px;
            }

            .main-content {
                padding: 32px 16px;
            }

            .login-card {
                padding: 24px;
            }

            .nav-links {
                gap: 16px;
            }
        }

        /* Animation */
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

        .login-card {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="nav-container">
        <div class="nav-content">
            <a href="<?= base_url() ?>" class="nav-brand">My Blog</a>

            <ul class="nav-links">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url('blog') ?>">Blog</a></li>
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
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <h1 class="login-title">Admin Login</h1>
                    <p class="login-subtitle">Access your blog dashboard</p>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="alert-dismiss"
                            onclick="this.parentElement.style.display='none'">×</button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="alert-dismiss"
                            onclick="this.parentElement.style.display='none'">×</button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('simple-login') ?>">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-input" id="email" name="email" placeholder="admin@example.com"
                            required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-input" id="password" name="password"
                            placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Login to Dashboard
                    </button>
                </form>

                <!-- Demo Credentials -->
                <div class="demo-credentials">
                    <div class="demo-title">Demo Credentials</div>
                    <div class="demo-text">
                        Email: admin@example.com<br>
                        Password: admin123
                    </div>
                </div>

                <div class="back-link">
                    <a href="<?= base_url() ?>">← Back to Blog</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            const body = document.body;
            const themeText = document.getElementById('theme-text');

            if (body.getAttribute('data-theme') === 'dark') {
                body.removeAttribute('data-theme');
                themeText.textContent = 'Dark';
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Light';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function () {
            const savedTheme = localStorage.getItem('theme');
            const themeText = document.getElementById('theme-text');

            if (savedTheme === 'dark') {
                document.body.setAttribute('data-theme', 'dark');
                themeText.textContent = 'Light';
            } else {
                themeText.textContent = 'Dark';
            }
        });

        // Auto dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
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
    </script>
</body>

</html>