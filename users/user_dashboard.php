<?php 
require_once '../admin/auth.php'; 
include 'sidebar.html'; 
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/user.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root {
    --blue-900: #0c1e3d;
    --blue-800: #1a3460;
    --blue-700: #1e4080;
    --blue-600: #1d4ed8;
    --blue-500: #2563eb;
    --blue-400: #3b82f6;
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
    --green:    #16a34a;
    --green-bg: #f0fdf4;
    --font: 'Plus Jakarta Sans', sans-serif;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
body, .main-content { font-family: var(--font) !important; }

.main-content {
    background: var(--gray-50);
    min-height: 100vh;
    padding: 0;
    margin-left: 255px;
}

/* ── Hero Banner ── */
.dashboard-hero {
    background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-700) 55%, var(--blue-500) 100%);
    padding: 2.5rem 2.5rem 5rem;
    position: relative;
    overflow: hidden;
    width: 100%;
}

.dashboard-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.dashboard-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 30%;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.hero-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.hero-greeting {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.hero-eyebrow {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--blue-200);
}

.hero-name {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    color: #fff;
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.15;
}

.hero-sub {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.55);
    margin-top: 2px;
}

.hero-date-badge {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.85);
    font-size: 0.78rem;
    font-weight: 500;
    padding: 0.45rem 1rem;
    border-radius: 999px;
    white-space: nowrap;
}

/* ── Stat Cards (floating over hero) ── */
.cards-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    padding: 0 2.5rem;
    margin-top: -3.5rem;
    position: relative;
    z-index: 10;
}

@media (max-width: 900px) { .cards-row { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 540px) { .cards-row { grid-template-columns: 1fr; } }

.stat-card {
    background: var(--white);
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    box-shadow: 0 4px 24px rgba(30,78,180,0.13);
    border: 1px solid var(--gray-100);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transition: transform 0.2s, box-shadow 0.2s;
    animation: cardRise 0.5s ease both;
}
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.2s; }

@keyframes cardRise {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 32px rgba(30,78,180,0.18); }

.stat-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.stat-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.icon-blue   { background: var(--blue-50);  }
.icon-indigo { background: #eef2ff; }
.icon-green  { background: var(--green-bg); }
.icon-amber  { background: #fffbeb; }

.stat-trend {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
}
.trend-up   { background: #f0fdf4; color: var(--green); }
.trend-info { background: var(--blue-50); color: var(--blue-600); }
.trend-warn { background: #fffbeb; color: #b45309; }

.stat-value {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--blue-900);
    letter-spacing: -0.03em;
    line-height: 1;
}

.stat-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 0.07em;
}

/* ── Lower content area ── */
.dashboard-body {
    padding: 2rem 2.5rem 2.5rem;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
    margin-top: 1.5rem;
}
@media (max-width: 900px) { .dashboard-body { grid-template-columns: 1fr; } }

/* ── Section card ── */
.section-card {
    background: var(--white);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 2px 12px rgba(30,78,180,0.07);
    overflow: hidden;
}

.section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-100);
}

.section-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--blue-900);
}
.section-subtitle {
    font-size: 0.75rem;
    color: var(--gray-400);
    margin-top: 1px;
}

.section-badge {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.22rem 0.65rem;
    border-radius: 999px;
    background: var(--blue-50);
    color: var(--blue-600);
}

/* ── Activity list ── */
.activity-list {
    padding: 0.5rem 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.9rem 1.5rem;
    border-bottom: 1px solid var(--gray-50);
    transition: background 0.14s;
}
.activity-item:last-child { border-bottom: none; }
.activity-item:hover { background: var(--blue-50); }

.activity-dot {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.activity-info { flex: 1; }
.activity-title { font-size: 0.85rem; font-weight: 600; color: var(--gray-800); }
.activity-time  { font-size: 0.73rem; color: var(--gray-400); margin-top: 1px; }
.activity-amount { font-size: 0.84rem; font-weight: 700; color: var(--blue-600); white-space: nowrap; }

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2.5rem;
    gap: 0.6rem;
    color: var(--gray-400);
}
.empty-state-icon { font-size: 2rem; opacity: 0.5; }
.empty-state p { font-size: 0.82rem; }

/* ── Profile card ── */
.profile-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; }

.profile-avatar-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px dashed var(--gray-200);
}

.profile-avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-800), var(--blue-500));
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: #fff;
    font-weight: 700;
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
}

.profile-name { font-size: 1rem; font-weight: 700; color: var(--blue-900); }
.profile-role {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    background: var(--blue-50);
    color: var(--blue-600);
}

/* Progress bar */
.progress-wrap { display: flex; flex-direction: column; gap: 0.4rem; }
.progress-label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--gray-600);
}
.progress-pct { color: var(--blue-600); }
.progress-track {
    height: 7px;
    background: var(--gray-100);
    border-radius: 999px;
    overflow: hidden;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--blue-500), var(--blue-400));
    border-radius: 999px;
    transition: width 1s ease;
}

/* Info rows */
.info-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.82rem;
}
.info-icon {
    width: 32px; height: 32px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.info-label { font-size: 0.7rem; color: var(--gray-400); }
.info-value { font-weight: 600; color: var(--gray-800); }

/* Quick actions */
.quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem; padding: 1.25rem 1.5rem; border-top: 1px solid var(--gray-100); }

.quick-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.6rem;
    border-radius: 9px;
    font-family: var(--font);
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.16s;
    text-decoration: none;
    border: none;
}
.quick-btn-primary {
    background: var(--blue-500);
    color: #fff;
    grid-column: span 2;
}
.quick-btn-primary:hover { background: var(--blue-600); transform: translateY(-1px); }
.quick-btn-outline {
    background: var(--gray-50);
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
}
.quick-btn-outline:hover { background: var(--blue-50); color: var(--blue-600); border-color: var(--blue-200); }
</style>

<div class="main-content">

    <!-- Hero -->
    <div class="dashboard-hero">
        <div class="hero-top">
            <div class="hero-greeting">
              
                <h1 class="hero-name">Welcome!<br><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?> </h1>
                <p class="hero-sub">Here's what's happening with your inventory today.</p>
            </div>
            <div class="hero-date-badge" id="liveClock"></div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="cards-row">
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon icon-blue"><i class="fa-solid fa-box"></i></div>
                <span class="stat-trend trend-info">Live</span>
            </div>
            <div class="stat-value" id="totalProducts">—</div>
            <div class="stat-label">Total Products</div>
        </div>

      

        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon icon-green"><i class="fa-solid fa-user"></i></div>
                <span class="stat-trend trend-up">Good</span>
            </div>
            <div class="stat-value">85<span style="font-size:1.1rem;color:var(--gray-400)">%</span></div>
            <div class="stat-label">Profile Complete</div>
        </div>

       
    </div>

    <!-- Body -->
    <div class="dashboard-body">

        <!-- Recent Activity -->
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">Recent Activity</div>
                    <div class="section-subtitle">Your latest checkout transactions</div>
                </div>
                <span class="section-badge">History</span>
            </div>
            <div class="activity-list" id="activityList">
                <div class="empty-state">
                    <div class="empty-state-icon"></div>
                    <p>No recent activity to show.</p>
                    <p>Checkout products to see history here.</p>
                </div>
            </div>
        </div>

        <!-- Profile Panel -->
        <div class="section-card">
            <div class="section-head">
                <div>
                    <div class="section-title">My Profile</div>
                    <div class="section-subtitle">Account details</div>
                </div>
            </div>
            <div class="profile-body">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar" id="avatarInitial">
                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="profile-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></div>
                    <div class="profile-role">User</div>
                </div>

                <div class="progress-wrap">
                    <div class="progress-label-row">
                        <span>Profile Completeness</span>
                        <span class="progress-pct">85%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="progressFill" style="width:0%"></div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon"></div>
                    <div>
                        <div class="info-label">Products Available</div>
                        <div class="info-value" id="profileProducts">Loading…</div>
                    </div>
                </div>

             

                <div class="info-row">
                    <div class="info-icon"></div>
                    <div>
                        <div class="info-label">Account Status</div>
                        <div class="info-value" style="color:var(--green)">● Active</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="products.php" class="quick-btn quick-btn-primary"> &nbsp;Go to Products</a>
                <a href="profilePage.php" class="quick-btn quick-btn-outline"> Edit Profile</a>
                
            </div>
        </div>

    </div>
</div>

<script>
// Live clock
function updateClock() {
    const now = new Date();
    document.getElementById('liveClock').textContent =
        now.toLocaleDateString('en-NP', { weekday:'short', month:'short', day:'numeric' })
        + ' · ' +
        now.toLocaleTimeString('en-NP', { hour:'2-digit', minute:'2-digit' });
}
updateClock();
setInterval(updateClock, 1000);

// Animate progress bar after load
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('progressFill').style.width = '85%';
    }, 400);
});

// Fetch products
fetch('../admin/fetch_product.php')
    .then(res => res.json())
    .then(data => {
        const count = data.length;
        // Animated count-up
        let n = 0;
        const el = document.getElementById('totalProducts');
        const profileEl = document.getElementById('profileProducts');
        const step = Math.ceil(count / 30);
        const timer = setInterval(() => {
            n = Math.min(n + step, count);
            el.textContent = n;
            if (n >= count) clearInterval(timer);
        }, 30);
        if (profileEl) profileEl.textContent = count + ' products';
    })
    .catch(() => {
        document.getElementById('totalProducts').textContent = 'Error';
    });
</script>