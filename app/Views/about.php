<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* About Hero Section */
    .about-hero {
        text-align: center;
        padding: 48px 0;
    }

    .about-intro {
        max-width: 800px;
        margin: 0 auto;
    }

    .greeting {
        font-size: 18px;
        color: var(--text-secondary);
        margin-bottom: 8px;
        font-weight: 400;
    }

    .name {
        font-size: 48px;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 12px;
        line-height: 1.1;
        letter-spacing: -0.025em;
    }

    .tagline {
        font-size: 32px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .subtitle {
        font-size: 18px;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
    }

    /* About Content */
    .about-content {
        margin-bottom: 64px;
    }

    .about-text {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .lead {
        font-size: 20px;
        line-height: 1.6;
        color: var(--text-primary);
        margin-bottom: 24px;
        font-weight: 400;
    }

    .about-text p {
        font-size: 16px;
        line-height: 1.7;
        color: var(--text-secondary);
        margin-bottom: 24px;
    }

    .about-text a {
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .about-text a:hover {
        border-bottom-color: var(--text-primary);
    }

    /* Skills Section */
    .skills-section {
        margin-bottom: 64px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 16px;
        text-align: center;
    }

    .section-subtitle {
        font-size: 14px;
        color: var(--text-secondary);
        text-align: center;
        margin-bottom: 48px;
    }

    .tech-category {
        margin-bottom: 48px;
    }

    .category-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 24px;
        text-align: center;
    }

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .skill-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 24px 16px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .skill-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border-color: var(--text-primary);
    }

    .skill-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--text-primary);
        transform: scaleX(0);
        transition: transform 0.2s ease;
    }

    .skill-item:hover::before {
        transform: scaleX(1);
    }

    .skill-item i {
        font-size: 32px;
        color: var(--text-primary);
        margin-bottom: 12px;
    }

    .skill-item span {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    /* Custom icons for technologies without Font Awesome */
    .skill-item .custom-icon {
        width: 32px;
        height: 32px;
        background: var(--text-primary);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 700;
        color: var(--card-bg);
    }

    /* Focus Section */
    .focus-section {
        margin-bottom: 64px;
    }

    .focus-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 32px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .focus-item {
        text-align: center;
        padding: 32px 24px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .focus-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .focus-icon {
        width: 64px;
        height: 64px;
        background: var(--text-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .focus-icon i {
        font-size: 24px;
        color: var(--card-bg);
    }

    .focus-item h4 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 12px;
    }

    .focus-item p {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
    }

    /* Contact Section */
    .contact-section {
        text-align: center;
        padding: 48px 24px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 32px;
    }

    .contact-text {
        font-size: 16px;
        color: var(--text-secondary);
        margin-bottom: 32px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .contact-links {
        display: flex;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .contact-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--hover-bg);
        color: var(--text-primary);
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
    }

    .contact-link:hover {
        background: var(--text-primary);
        color: var(--card-bg);
        transform: translateY(-2px);
        text-decoration: none;
    }

    .contact-link i {
        font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .name {
            font-size: 36px;
        }

        .tagline {
            font-size: 24px;
        }

        .subtitle {
            font-size: 16px;
        }

        .skills-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 16px;
        }

        .focus-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .contact-links {
            flex-direction: column;
            align-items: center;
        }

        .contact-link {
            width: 200px;
            justify-content: center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="about-hero">
    <div class="about-intro">
        <div class="greeting">Hi, My name is</div>
        <h1 class="name">Dionisius Surya Jaya</h1>
        <h2 class="tagline">I build things for web</h2>
    </div>
</div>

<!-- About Content -->
<div class="about-content">
    <div class="about-text">
        <p class="lead">
            I am an undergraduate Computer Science student at Brawijaya University with a strong passion for programming
            and software development. My goal is to become a professional programmer who not only writes clean and
            efficient code but also builds meaningful and impactful solutions.
        </p>

        <p>
            I am constantly seeking opportunities to learn new technologies, improve my skills, and contribute to
            real-world projects. You can explore some of my academic work and personal projects on my <a
                href="https://github.com/midas79" target="_blank" rel="noopener noreferrer">GitHub</a>.
        </p>
    </div>
</div>

<!-- Skills & Technologies -->
<div class="skills-section">
    <h3 class="section-title">My Tech Stack</h3>
    <p class="section-subtitle">Technologies I've been working with recently</p>

    <!-- Programming Languages -->
    <div class="tech-category">
        <h4 class="category-title">Programming Languages</h4>
        <div class="skills-grid">
            <div class="skill-item">
                <i class="fab fa-python"></i>
                <span>Python</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-js-square"></i>
                <span>JavaScript</span>
            </div>
            <div class="skill-item">
                <div class="custom-icon">TS</div>
                <span>TypeScript</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-java"></i>
                <span>Java</span>
            </div>
            <div class="skill-item">
                <div class="custom-icon">KT</div>
                <span>Kotlin</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-php"></i>
                <span>PHP</span>
            </div>
        </div>
    </div>

    <!-- Frameworks & Tools -->
    <div class="tech-category">
        <h4 class="category-title">Frameworks & Tools</h4>
        <div class="skills-grid">
            <div class="skill-item">
                <i class="fab fa-laravel"></i>
                <span>Laravel</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-react"></i>
                <span>React</span>
            </div>
            <div class="skill-item">
                <div class="custom-icon">NX</div>
                <span>Next.js</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-node-js"></i>
                <span>Node.js</span>
            </div>
            <div class="skill-item">
                <div class="custom-icon">TW</div>
                <span>TailwindCSS</span>
            </div>
            <div class="skill-item">
                <i class="fab fa-git-alt"></i>
                <span>Git</span>
            </div>
        </div>
    </div>
</div>

<!-- Current Focus -->
<div class="focus-section">
    <h3 class="section-title">What I'm currently focused on</h3>
    <div class="focus-grid">
        <div class="focus-item">
            <div class="focus-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h4>Academic Excellence</h4>
            <p>Pursuing my Computer Science degree at Brawijaya University while maintaining high academic standards.
            </p>
        </div>
        <div class="focus-item">
            <div class="focus-icon">
                <i class="fas fa-code"></i>
            </div>
            <h4>Full Stack Development</h4>
            <p>Building modern web applications using React, Next.js, Laravel, and exploring new technologies like
                TypeScript and Kotlin.</p>
        </div>
        <div class="focus-item">
            <div class="focus-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <h4>Innovation</h4>
            <p>Exploring new technologies and methodologies to create innovative solutions for real-world problems.</p>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="contact-section">
    <h3 class="section-title">Let's connect</h3>
    <p class="contact-text">
        I'm always interested in discussing new opportunities, collaborating on projects, or just having a chat about
        technology and programming.
    </p>
    <div class="contact-links">
        <a href="mailto:dionisius.suryajaya@gmail.com" class="contact-link">
            <i class="fas fa-envelope"></i>
            <span>Email</span>
        </a>
        <a href="https://github.com/midas79" target="_blank" rel="noopener noreferrer" class="contact-link">
            <i class="fab fa-github"></i>
            <span>GitHub</span>
        </a>
        <a href="https://linkedin.com/in/dionisiussj" target="_blank" rel="noopener noreferrer" class="contact-link">
            <i class="fab fa-linkedin"></i>
            <span>LinkedIn</span>
        </a>
        <a href="https://twitter.com/grriffitth" target="_blank" rel="noopener noreferrer" class="contact-link">
            <i class="fab fa-twitter"></i>
            <span>Twitter</span>
        </a>
    </div>
</div>
<?= $this->endSection() ?>