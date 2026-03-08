<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTRIX — Smart Inventory Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --blue-900: #0c1e3d;
            --blue-800: #1a3460;
            --blue-700: #1e4080;
            --blue-600: #1d4ed8;
            --blue-500: #2563eb;
            --blue-400: #3b82f6;
            --blue-300: #93c5fd;
            --blue-200: #bfdbfe;
            --blue-100: #dbeafe;
            --blue-50:  #eff6ff;
            --white:    #ffffff;
            --gray-50:  #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--gray-800);
            overflow-x: hidden;
        }

        /* ══════════════════════════
           NAVBAR
        ══════════════════════════ */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 1rem 5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 2px 16px rgba(37,99,235,0.06);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--blue-900), var(--blue-500));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        }

        .nav-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--blue-900);
            letter-spacing: 0.04em;
        }

        .nav-logo-sub {
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gray-400);
            display: block;
            margin-top: -2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--blue-600); }

        .nav-cta {
            background: var(--blue-500) !important;
            color: var(--white) !important;
            padding: 0.55rem 1.4rem !important;
            border-radius: 9px !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(37,99,235,0.3);
            transition: all 0.2s !important;
        }
        .nav-cta:hover {
            background: var(--blue-600) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.4) !important;
        }

        /* ══════════════════════════
           HERO
        ══════════════════════════ */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 9rem 2rem 5rem;
            position: relative;
            overflow: hidden;
            background: var(--white);
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(var(--blue-200) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.5;
            mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, black 30%, transparent 100%);
        }

        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
        }
        .hero-blob-1 { width:500px; height:500px; background:rgba(37,99,235,0.08); top:-100px; left:-100px; }
        .hero-blob-2 { width:400px; height:400px; background:rgba(59,130,246,0.10); top:50px;  right:-80px; }
        .hero-blob-3 { width:350px; height:350px; background:rgba(37,99,235,0.07); bottom:0;  left:40%;   }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 780px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            color: var(--blue-600);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 0.4rem 1.1rem;
            border-radius: 999px;
            margin-bottom: 1.75rem;
            animation: fadeUp 0.6s ease both;
        }

        .eyebrow-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--blue-500);
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {
            0%,100% { opacity:1; }
            50%      { opacity:0.3; }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 6vw, 4.8rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.03em;
            color: var(--blue-900);
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease 0.1s both;
        }

        .hero-title-accent {
            background: linear-gradient(135deg, var(--blue-600), var(--blue-400));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--gray-600);
            line-height: 1.75;
            max-width: 540px;
            margin: 0 auto 2.5rem;
            font-weight: 400;
            animation: fadeUp 0.6s ease 0.2s both;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeUp 0.6s ease 0.3s both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--blue-500);
            color: var(--white);
            padding: 0.9rem 2.2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 6px 24px rgba(37,99,235,0.35);
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: var(--blue-600);
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(37,99,235,0.45);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1.5px solid var(--blue-200);
            color: var(--blue-600);
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-outline:hover {
            background: var(--blue-50);
            border-color: var(--blue-400);
            transform: translateY(-2px);
        }

        .hero-stats {
            margin-top: 5rem;
            display: flex;
            justify-content: center;
            animation: fadeUp 0.6s ease 0.4s both;
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            overflow: hidden;
            background: var(--white);
            box-shadow: 0 4px 20px rgba(37,99,235,0.07);
        }

        .stat-item {
            padding: 1.25rem 2.5rem;
            text-align: center;
            border-right: 1px solid var(--gray-200);
            flex: 1;
        }
        .stat-item:last-child { border-right: none; }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--blue-900);
        }
        .stat-number span { color: var(--blue-500); }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-400);
            margin-top: 3px;
        }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(22px); }
            to   { opacity:1; transform:none; }
        }

     
        .features {
            padding: 7rem 5rem;
            background: var(--gray-50);
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--blue-200), transparent);
        }

        .section-eyebrow {
            text-align: center;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--blue-500);
            margin-bottom: 0.75rem;
        }

        .section-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.9rem, 3vw, 2.6rem);
            font-weight: 800;
            color: var(--blue-900);
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .section-sub {
            text-align: center;
            font-size: 0.95rem;
            color: var(--gray-400);
            max-width: 460px;
            margin: 0 auto 3.5rem;
            line-height: 1.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        @media (max-width: 900px) { .features-grid { grid-template-columns: 1fr; } }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-500), var(--blue-300));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            border-color: var(--blue-200);
            box-shadow: 0 8px 32px rgba(37,99,235,0.1);
            transform: translateY(-4px);
        }
        .feature-card:hover::after { transform: scaleX(1); }

        .feature-icon {
            width: 50px; height: 50px;
            background: var(--blue-50);
            border: 1px solid var(--blue-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }

        .feature-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.85rem;
            color: var(--gray-400);
            line-height: 1.7;
        }

    
        .preview-section {
            padding: 7rem 5rem;
            background: var(--white);
        }

        .preview-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        .preview-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 16px 60px rgba(37,99,235,0.1), 0 2px 8px rgba(0,0,0,0.04);
        }

        .preview-bar {
            background: var(--gray-100);
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-red    { background: #ff5f57; }
        .dot-yellow { background: #febc2e; }
        .dot-green  { background: #28c840; }

        .preview-url {
            margin-left: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            padding: 0.25rem 1rem;
            font-size: 0.72rem;
            color: var(--gray-400);
            flex: 1;
            max-width: 280px;
        }

        .preview-body {
            display: grid;
            grid-template-columns: 190px 1fr;
            min-height: 340px;
        }

        .preview-sidebar {
            background: linear-gradient(180deg, var(--blue-900), var(--blue-800));
            padding: 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .preview-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 0.4rem;
        }

        .preview-nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.65rem;
            border-radius: 7px;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
        }
        .preview-nav-item.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        .preview-nav-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .preview-main {
            background: var(--gray-50);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .preview-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--blue-900);
        }

        .preview-cards-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .preview-stat-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            padding: 0.85rem;
        }

        .preview-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--blue-900);
            font-weight: 700;
        }

        .preview-stat-lbl {
            font-size: 0.58rem;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 2px;
            font-weight: 600;
        }

        .preview-table {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            overflow: hidden;
            flex: 1;
        }

        .preview-table-head {
            background: linear-gradient(135deg, var(--blue-900), var(--blue-600));
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            padding: 0.6rem 1rem;
        }

        .preview-th {
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.75);
        }

        .preview-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            padding: 0.55rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            align-items: center;
        }

        .preview-td { font-size: 0.65rem; color: var(--gray-400); }
        .preview-td.name  { color: var(--gray-800); font-weight: 600; }
        .preview-td.green { color: #16a34a; font-weight: 600; }
        .preview-td.red   { color: #dc2626; font-weight: 600; }

        .preview-pill {
            display: inline-block;
            font-size: 0.55rem;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
            background: var(--blue-50);
            color: var(--blue-600);
            border: 1px solid var(--blue-100);
            font-weight: 600;
        }

  
        .how-section {
            background: var(--blue-900);
            padding: 7rem 5rem;
            position: relative;
            overflow: hidden;
        }

        .how-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .how-section .section-title { color: var(--white); }
        .how-section .section-sub   { color: rgba(255,255,255,0.45); }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 800px) { .steps-grid { grid-template-columns: 1fr; } }

        .step-card {
            text-align: center;
            padding: 2rem 1.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            transition: all 0.2s;
        }
        .step-card:hover {
            background: rgba(255,255,255,0.07);
            transform: translateY(-3px);
        }

        .step-number {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: rgba(37,99,235,0.25);
            border: 1.5px solid var(--blue-400);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--blue-300);
            margin: 0 auto 1.25rem;
        }

        .step-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.5rem;
        }

        .step-desc {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
        }

    
        .cta-section {
            background: var(--blue-50);
            padding: 7rem 5rem;
            text-align: center;
            position: relative;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--blue-200), transparent);
        }

        .cta-inner { max-width: 600px; margin: 0 auto; }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            color: var(--blue-900);
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .cta-sub {
            font-size: 1rem;
            color: var(--gray-400);
            margin-bottom: 2.25rem;
            line-height: 1.7;
        }

      
        footer {
            background: var(--blue-900);
            padding: 2rem 5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: rgba(255,255,255,0.7);
        }

        .footer-copy {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.3);
        }

 
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: none;
        }
    </style>
</head>
<body>


    <nav>
        <a href="#" class="nav-logo">
           
            <div>
                <span class="nav-logo-text">INVENTRIX</span>
                <span class="nav-logo-sub">Inventory System</span>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#preview">Preview</a></li>
            <li><a href="#how">How It Works</a></li>
            <li><a href="admin/login.php" class="nav-cta">Login →</a></li>
        </ul>
    </nav>

 
    <section class="hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>

        <div class="hero-content">
            <div class="hero-eyebrow">
                <div class="eyebrow-dot"></div>
                Smart Inventory Management
            </div>

            <h1 class="hero-title">
                Manage Your Stock<br>
                <span class="hero-title-accent">Smarter & Faster.</span>
            </h1>

            <p class="hero-sub">
                INVENTRIX gives you real-time stock visibility, bulk checkouts, and instant bill generation — beautifully designed for businesses of all sizes.
            </p>

            <div class="hero-actions">
                <a href="admin/login.php" class="btn-primary">Get Started &nbsp;→</a>
                <a href="#features" class="btn-outline">Explore Features</a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">99<span>%</span></div>
                    <div class="stat-label">Uptime</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><span>∞</span></div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1<span>s</span></div>
                    <div class="stat-label">Bills</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24<span>/7</span></div>
                    <div class="stat-label">Access</div>
                </div>
            </div>
        </div>
    </section>

 
    <section class="features reveal" id="features">
        <div class="section-eyebrow">What We Offer</div>
        <h2 class="section-title">Everything you need, nothing you don't</h2>
        <p class="section-sub">A focused set of tools to keep your inventory organized and your team efficient.</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-box"></i></div>
                <div class="feature-title">Real-Time Stock Tracking</div>
                <div class="feature-desc">Monitor product quantities live with color-coded stock levels. Always know what's running low.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-cart-arrow-down"></i></div>
                <div class="feature-title">Bulk Checkout</div>
                <div class="feature-desc">Select multiple items, set quantities, and process everything in a single checkout flow.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-file"></i></div>
                <div class="feature-title">Instant Bill Generation</div>
                <div class="feature-desc">Printable bills in NRs. generated automatically after every checkout with timestamp.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="feature-title">Smart Search</div>
                <div class="feature-desc">Find any product instantly by name, category, or supplier — no scrolling required.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-user"></i></div>
                <div class="feature-title">Role-Based Access</div>
                <div class="feature-desc">Admin and Member roles with separate dashboards and permissions. Secure by design.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-arrow-trend-down"></i></div>
                <div class="feature-title">Dashboard Overview</div>
                <div class="feature-desc">See total products, stock values, and activity at a glance from your personal dashboard.</div>
            </div>
        </div>
    </section>

    <!-- PREVIEW -->
    <section class="preview-section reveal" id="preview">
        <div class="preview-wrap">
            <div class="section-eyebrow">Live Preview</div>
            <h2 class="section-title">A clean interface you'll actually enjoy</h2>
            <p class="section-sub">Here's a taste of the dashboard waiting for you inside.</p>

            <div class="preview-card">
                <div class="preview-bar">
                    <div class="dot dot-red"></div>
                    <div class="dot dot-yellow"></div>
                    <div class="dot dot-green"></div>
                    <div class="preview-url">inventrix.app / dashboard</div>
                </div>
                <div class="preview-body">
                    <div class="preview-sidebar">
                        <div class="preview-logo-text">INVENTRIX</div>
                        <div class="preview-nav-item active"><div class="preview-nav-dot"></div> Dashboard</div>
                        <div class="preview-nav-item"><div class="preview-nav-dot"></div> Products</div>
                        <div class="preview-nav-item"><div class="preview-nav-dot"></div> Profile</div>
                    </div>
                    <div class="preview-main">
                        <div class="preview-heading">Available Products</div>
                        <div class="preview-cards-row">
                            <div class="preview-stat-card">
                                <div class="preview-stat-num">24</div>
                                <div class="preview-stat-lbl">Products</div>
                            </div>
                            <div class="preview-stat-card">
                                <div class="preview-stat-num">8</div>
                                <div class="preview-stat-lbl">Orders</div>
                            </div>
                            <div class="preview-stat-card">
                                <div class="preview-stat-num" style="color:var(--blue-500)">85%</div>
                                <div class="preview-stat-lbl">Profile</div>
                            </div>
                            <div class="preview-stat-card">
                                <div class="preview-stat-num" style="font-size:0.85rem;padding-top:5px;color:var(--blue-600)">Today</div>
                                <div class="preview-stat-lbl">Login</div>
                            </div>
                        </div>
                        <div class="preview-table">
                            <div class="preview-table-head">
                                <div class="preview-th">Product</div>
                                <div class="preview-th">Category</div>
                                <div class="preview-th">Stock</div>
                                <div class="preview-th">Price</div>
                            </div>
                            <div class="preview-row">
                                <div class="preview-td name">Dell Laptop</div>
                                <div class="preview-td"><span class="preview-pill">Electronics</span></div>
                                <div class="preview-td red">5</div>
                                <div class="preview-td">NRs. 70,000</div>
                            </div>
                            <div class="preview-row">
                                <div class="preview-td name">Lays Chips</div>
                                <div class="preview-td"><span class="preview-pill">Grocery</span></div>
                                <div class="preview-td green">8</div>
                                <div class="preview-td">NRs. 30</div>
                            </div>
                            <div class="preview-row">
                                <div class="preview-td name">Wai Wai Noodles</div>
                                <div class="preview-td"><span class="preview-pill">Noodles</span></div>
                                <div class="preview-td green">6</div>
                                <div class="preview-td">NRs. 30</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-section reveal" id="how">
        <div class="section-eyebrow" style="color:var(--blue-300)">Simple Process</div>
        <h2 class="section-title">How It Works</h2>
        <p class="section-sub">Three simple steps to take full control of your inventory.</p>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-title">Login to Your Account</div>
                <div class="step-desc">Access your personal dashboard securely. Admin and member roles available.</div>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-title">Browse & Select Products</div>
                <div class="step-desc">View all stock, search by name or category, select items and set quantities.</div>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-title">Checkout & Get Your Bill</div>
                <div class="step-desc">Process bulk checkout in one click and instantly receive a printable bill in NRs.</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section reveal">
        <div class="cta-inner">
            <h2 class="cta-title">Ready to take control?</h2>
            <p class="cta-sub">Log in to your INVENTRIX account and start managing your inventory smarter today.</p>
            <a href="admin/login.php" class="btn-primary" style="font-size:1rem; padding:1rem 2.5rem; display:inline-flex;">
                Login to Dashboard &nbsp;→
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-logo">INVENTRIX</div>
        <div class="footer-copy">© <?= date('Y') ?> INVENTRIX. All rights reserved.</div>
    </footer>

    <script>
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

</body>
</html>