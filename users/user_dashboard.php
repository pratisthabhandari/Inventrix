<?php 
require_once '../admin/auth.php'; 
include 'sidebar.html'; 
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/user.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --bg:         #ffffff;
    --blue:       #4bafd4;
    --blue-dark:  #2a8db5;
    --blue-deep:  #1a6e91;
    --blue-pale:  #d0e9f5;
    --blue-faint: #eaf5fb;
    --blue-soft:  #a8d8ec;
    --white:      #ffffff;
    --text:       #0d2a38;
    --text-sec:   #2a5570;
    --muted:      #5589a3;
    --border:     #bcd9e8;
    --green:      #1a8f5e;
    --green-bg:   #edfaf4;
    --font:       'Nunito', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
    font-family: var(--font) !important;
    background: var(--bg) !important;
}

.main-content {
    font-family: var(--font) !important;
    background: var(--bg);
    min-height: 100vh;
    margin-left: 255px;
    padding: 0;
}

/* ── PAGE CONTENT ── */
.page-wrap {
    padding: 2rem 2.5rem 3rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* ── WELCOME BANNER ── */
.welcome-banner {
    background: var(--white);
    border-radius: 18px;
    border: 1.5px solid var(--blue-pale);
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 12px rgba(42,141,181,0.07);
    position: relative;
    overflow: hidden;
}

.welcome-banner::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: var(--blue-faint);
    border: 30px solid var(--blue-pale);
    pointer-events: none;
}

.welcome-text { position: relative; z-index: 1; }

.welcome-hello {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--blue);
    margin-bottom: 0.3rem;
}

.welcome-name {
    font-size: 1.65rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}

.welcome-sub {
    font-size: 0.84rem;
    color: var(--muted);
    font-weight: 500;
    margin-top: 0.3rem;
}

.welcome-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.65rem;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}

.welcome-icon {
    width: 48px; height: 48px;
    background: var(--blue-faint);
    border: 2px solid var(--blue-pale);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--blue);
}

.clock-pill {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    background: var(--blue-faint);
    border: 1.5px solid var(--blue-pale);
    border-radius: 999px;
    padding: 0.4rem 1rem;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-sec);
    white-space: nowrap;
}
.clock-pill i { color: var(--blue); font-size: 0.72rem; }

/* ── STAT CARDS ── */
.cards-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
@media (max-width: 860px) { .cards-row { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: var(--white);
    border-radius: 16px;
    border: 1.5px solid var(--blue-pale);
    padding: 1.5rem 1.6rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(42,141,181,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    animation: rise 0.4s ease both;
}
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.12s; }
.stat-card:nth-child(3) { animation-delay: 0.19s; }

@keyframes rise {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(42,141,181,0.14);
}

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
    font-size: 1.1rem;
}
.icon-blue  { background: var(--blue-faint); color: var(--blue-dark); }
.icon-green { background: var(--green-bg);   color: var(--green); }

.stat-pill {
    font-size: 0.68rem;
    font-weight: 700;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    letter-spacing: 0.04em;
}
.pill-blue  { background: var(--blue-faint); color: var(--blue-deep); border: 1px solid var(--blue-pale); }
.pill-green { background: var(--green-bg);   color: var(--green);     border: 1px solid #b6f0d4; }

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
    letter-spacing: -0.02em;
}

.stat-label {
    font-size: 0.74rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

/* ── BOTTOM GRID ── */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.25rem;
}
@media (max-width: 860px) { .bottom-grid { grid-template-columns: 1fr; } }

/* ── PANEL ── */
.panel {
    background: var(--white);
    border-radius: 16px;
    border: 1.5px solid var(--blue-pale);
    box-shadow: 0 2px 10px rgba(42,141,181,0.07);
    overflow: hidden;
    animation: rise 0.4s ease 0.25s both;
}

.panel-head {
    padding: 1.2rem 1.6rem;
    border-bottom: 1.5px solid var(--blue-faint);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.panel-title { font-size: 0.92rem; font-weight: 800; color: var(--text); }
.panel-sub   { font-size: 0.74rem; color: var(--muted); font-weight: 600; margin-top: 2px; }

.panel-tag {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.22rem 0.7rem;
    border-radius: 999px;
    background: var(--blue-faint);
    color: var(--blue-deep);
    border: 1px solid var(--blue-pale);
}

/* ── EMPTY STATE ── */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3.5rem 2rem;
    gap: 0.5rem;
    text-align: center;
}

.empty-icon {
    width: 54px; height: 54px;
    background: var(--blue-faint);
    border: 1.5px solid var(--blue-pale);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: var(--blue-soft);
    margin-bottom: 0.4rem;
}

.empty-state p    { font-size: 0.84rem; font-weight: 700; color: var(--text-sec); }
.empty-state span { font-size: 0.76rem; color: var(--muted); font-weight: 500; }

/* ── PROFILE PANEL ── */
.profile-inner {
    padding: 1.6rem;
    display: flex;
    flex-direction: column;
    gap: 1.3rem;
}

.avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    padding-bottom: 1.3rem;
    border-bottom: 1.5px solid var(--blue-faint);
}

.avatar {
    width: 68px; height: 68px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    font-weight: 800;
    color: #fff;
    box-shadow: 0 4px 14px rgba(42,141,181,0.3);
}

.profile-name {
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
}

.profile-badge {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 0.22rem 0.8rem;
    border-radius: 999px;
    background: var(--blue-faint);
    color: var(--blue-deep);
    border: 1px solid var(--blue-pale);
}

/* Progress */
.prog-wrap { display: flex; flex-direction: column; gap: 0.5rem; }
.prog-row  { display: flex; justify-content: space-between; align-items: center; }
.prog-row span:first-child { font-size: 0.78rem; font-weight: 700; color: var(--text); }
.prog-pct  { font-size: 0.78rem; font-weight: 800; color: var(--blue-dark); }
.prog-track {
    height: 7px;
    background: var(--blue-pale);
    border-radius: 999px;
    overflow: hidden;
}
.prog-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--blue-dark), var(--blue));
    border-radius: 999px;
    transition: width 1.1s ease;
}

/* Info row */
.info-row {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.info-ico {
    width: 34px; height: 34px;
    background: var(--blue-faint);
    border: 1.5px solid var(--blue-pale);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    color: var(--blue-dark);
    flex-shrink: 0;
}
.info-lbl { font-size: 0.68rem; color: var(--muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.info-val  { font-size: 0.86rem; font-weight: 700; color: var(--text); margin-top: 1px; }

/* Actions */
.panel-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
    padding: 1.25rem 1.6rem;
    border-top: 1.5px solid var(--blue-faint);
}

.act-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.68rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.16s;
}
.act-primary {
    background: var(--blue);
    color: #fff;
    grid-column: span 2;
    box-shadow: 0 3px 10px rgba(75,175,212,0.3);
}
.act-primary:hover {
    background: var(--blue-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(42,141,181,0.35);
}
.act-outline {
    background: var(--blue-faint);
    color: var(--blue-deep);
    border: 1.5px solid var(--blue-pale);
}
.act-outline:hover { background: var(--blue-pale); }
</style>

<div class="main-content">
    <div class="page-wrap">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <div class="welcome-hello">Good to see you</div>
                <div class="welcome-name">Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>!</div>
                <div class="welcome-sub">Here's what's happening with your inventory today.</div>
            </div>
            <div class="welcome-right">
                <div class="welcome-icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="clock-pill">
                    <i class="fa-regular fa-clock"></i>
                    <span id="liveClock"></span>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="cards-row">

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon icon-blue"><i class="fa-solid fa-box"></i></div>
                    <span class="stat-pill pill-blue">Live</span>
                </div>
                <div>
                    <div class="stat-value" id="totalProducts">—</div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
                    <span class="stat-pill pill-green">Verified</span>
                </div>
                <div>
                    <div class="stat-value" style="font-size:1.4rem; color:var(--green);">Active</div>
                    <div class="stat-label">Account Status</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon icon-blue"><i class="fa-solid fa-user"></i></div>
                    <span class="stat-pill pill-blue">Good</span>
                </div>
                <div>
                    <div class="stat-value">85<span style="font-size:1rem; color:var(--muted); font-weight:700">%</span></div>
                    <div class="stat-label">Profile Complete</div>
                </div>
            </div>

        </div>

        <!-- Bottom Grid -->
        <div class="bottom-grid">

            <!-- Recent Activity -->
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">Recent Activity</div>
                        <div class="panel-sub">Your latest checkout transactions</div>
                    </div>
                    <span class="panel-tag">History</span>
                </div>
                <div id="activityList">
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                        <p>No recent activity yet</p>
                        <span>Checkout products to see history here.</span>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="panel-title">My Profile</div>
                        <div class="panel-sub">Account overview</div>
                    </div>
                </div>

                <div class="profile-inner">

                    <div class="avatar-section">
                        <div class="avatar">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="profile-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></div>
                        <div class="profile-badge">Member</div>
                    </div>

                    <div class="prog-wrap">
                        <div class="prog-row">
                            <span>Profile Completeness</span>
                            <span class="prog-pct">85%</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" id="progressFill" style="width:0%"></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-ico"><i class="fa-solid fa-box"></i></div>
                        <div>
                            <div class="info-lbl">Products Available</div>
                            <div class="info-val" id="profileProducts">Loading…</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-ico"><i class="fa-solid fa-shield-check"></i></div>
                        <div>
                            <div class="info-lbl">Account Status</div>
                            <div class="info-val" style="color:var(--green)">● Active</div>
                        </div>
                    </div>

                </div>

                <div class="panel-actions">
                    <a href="products.php" class="act-btn act-primary">
                        <i class="fa-solid fa-boxes-stacked"></i> Go to Products
                    </a>
                    <a href="profilePage.php" class="act-btn act-outline">
                        <i class="fa-solid fa-pen"></i> Edit Profile
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Live clock — safe null check so it never crashes
function updateClock() {
    const el = document.getElementById('liveClock');
    if (!el) return;
    const now = new Date();
    el.textContent =
        now.toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric' })
        + '  ·  ' +
        now.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit' });
}
updateClock();
setInterval(updateClock, 1000);

// Progress bar
window.addEventListener('load', () => {
    setTimeout(() => {
        const bar = document.getElementById('progressFill');
        if (bar) bar.style.width = '85%';
    }, 500);
});

// Fetch total products
fetch('../admin/fetch_product.php')
    .then(r => {
        if (!r.ok) throw new Error('Network response was not ok');
        return r.json();
    })
    .then(data => {
        const count = Array.isArray(data) ? data.length : 0;
        const el = document.getElementById('totalProducts');
        const pe = document.getElementById('profileProducts');

        // Animated count-up
        let n = 0;
        const step = Math.max(1, Math.ceil(count / 30));
        const t = setInterval(() => {
            n = Math.min(n + step, count);
            if (el) el.textContent = n;
            if (n >= count) clearInterval(t);
        }, 30);

        if (pe) pe.textContent = count + ' products';
    })
    .catch(err => {
        console.error('Fetch error:', err);
        const el = document.getElementById('totalProducts');
        if (el) el.textContent = '—';
    });
</script>