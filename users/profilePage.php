<?php require_once '../admin/auth.php'; ?>
<?php include 'sidebar.html'; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


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
    --red:        #dc2626;
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
    padding: 2rem 2.5rem 3rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

@keyframes rise {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── HEADER CARD (matches welcome-banner) ── */
.header-card {
    background: var(--white);
    border-radius: 18px;
    border: 1.5px solid var(--blue-pale);
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 12px rgba(42,141,181,0.07);
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 540px;
    animation: rise 0.4s ease both;
}
.header-card::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: var(--blue-faint);
    border: 30px solid var(--blue-pale);
    pointer-events: none;
}
.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 1;
}
.header-icon {
    width: 48px; height: 48px;
    background: var(--blue-faint);
    border: 2px solid var(--blue-pale);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    color: var(--blue);
    flex-shrink: 0;
}
.header-eyebrow {
    font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.12em;
    color: var(--blue);
}
.header-title {
    font-size: 1.65rem; font-weight: 800;
    color: var(--text); line-height: 1.2;
}
.header-sub {
    font-size: 0.84rem; color: var(--muted);
    font-weight: 500; margin-top: 0.1rem;
}

/* ── LAYOUT ── */
.profile-layout {
    width: 100%;
    max-width: 540px;
    animation: rise 0.4s ease 0.08s both;
}

/* ── FORM CARD ── */
.form-card {
    background: var(--white);
    border-radius: 18px;
    border: 1.5px solid var(--border);
    box-shadow: 0 2px 0 var(--blue-pale), 0 6px 24px rgba(42,141,181,0.09);
    overflow: hidden;
}

/* gradient accent strip at top */
.form-card-accent {
    height: 4px;
    background: linear-gradient(90deg, var(--blue-deep), var(--blue), var(--blue-soft));
}

.form-card-body {
    padding: 1.75rem 1.75rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.3rem;
}

/* section label */
.form-section-label {
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.13em;
    color: var(--blue);
    padding-bottom: 0.55rem;
    border-bottom: 1.5px solid var(--blue-pale);
}

/* ── FIELD ── */
.field {
    display: flex;
    flex-direction: column;
    gap: 0.38rem;
}
.field label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-sec);
}
.field-inner {
    position: relative;
    display: flex;
    align-items: center;
}
.field-icon {
    position: absolute;
    left: 14px;
    color: var(--blue-soft);
    font-size: 0.84rem;
    pointer-events: none;
    z-index: 1;
}
.field input {
    width: 100%;
    padding: 0.78rem 1rem 0.78rem 2.7rem;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    background: var(--blue-faint);
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    box-sizing: border-box;
    -webkit-appearance: none;
}
.field input:focus {
    border-color: var(--blue);
    background: var(--white);
    box-shadow: 0 0 0 3.5px rgba(75,175,212,0.13);
}
.field input::placeholder { color: #aac8d8; font-weight: 500; }
.field input[type="password"],
.field input.has-toggle { padding-right: 2.8rem; }

.toggle-password {
    position: absolute;
    right: 14px;
    color: var(--blue-soft);
    cursor: pointer;
    font-size: 0.84rem;
    transition: color 0.15s;
    z-index: 1;
}
.toggle-password:hover { color: var(--blue); }

.field-hint {
    font-size: 0.72rem;
    color: var(--muted);
    font-weight: 500;
}

/* ── FOOTER ── */
.form-card-footer {
    padding: 1.2rem 1.75rem;
    border-top: 1.5px solid var(--blue-pale);
    background: var(--blue-faint);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    align-items: center;
}

.btn-save {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue));
    color: #fff;
    border: none;
    padding: 0.7rem 1.6rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
    display: flex;
    align-items: center;
    gap: 0.45rem;
    box-shadow: 0 3px 12px rgba(42,141,181,0.28);
    letter-spacing: 0.01em;
}
.btn-save:hover {
    background: linear-gradient(135deg, var(--blue-deep), var(--blue-dark));
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(42,141,181,0.38);
}

.btn-reset {
    background: var(--white);
    color: var(--muted);
    border: 1.5px solid var(--border);
    padding: 0.7rem 1.3rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.btn-reset:hover {
    background: var(--blue-pale);
    border-color: var(--blue-pale);
    color: var(--text-sec);
}

/* ── TOAST ── */
#toast-container {
    position: fixed;
    bottom: 1.5rem; right: 1.5rem;
    z-index: 9999;
    display: flex; flex-direction: column; gap: 0.5rem;
}
.toast {
    padding: 0.72rem 1.1rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.82rem; font-weight: 600;
    box-shadow: 0 4px 16px rgba(42,141,181,0.12);
    max-width: 320px;
    animation: toastIn 0.25s ease;
    display: flex; align-items: center; gap: 0.55rem;
}
.toast-success { background: var(--green-bg); border: 1px solid #a7f3d0; color: var(--green); }
.toast-error   { background: #fef2f2;          border: 1px solid #fca5a5; color: var(--red); }
.toast.fade-out { animation: toastOut 0.4s ease forwards; }
@keyframes toastIn  { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
@keyframes toastOut { from { opacity:1; } to { opacity:0; transform:translateY(6px); } }
</style>

<div class="main-content">

    <!-- Header card -->
    <div class="header-card">
        <div class="header-left">
            <div class="header-icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <div class="header-eyebrow">Account</div>
                <div class="header-title">My Profile</div>
                <div class="header-sub">Manage your info and security settings</div>
            </div>
        </div>
    </div>

    <!-- Form card -->
    <div class="profile-layout">
        <div class="form-card">

            <div class="form-card-accent"></div>

            <form id="profileForm">
                <div class="form-card-body">

                    <div class="form-section-label">Account Info</div>

                    <div class="field">
                        <label for="username">Username</label>
                        <div class="field-inner">
                            <i class="fa-solid fa-user field-icon"></i>
                            <input type="text" id="username"
                                value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>"
                                placeholder="Enter username" required
                                oninput="syncAvatar()">
                        </div>
                    </div>

                    <div class="field">
                        <label for="email">Email Address</label>
                        <div class="field-inner">
                            <i class="fa-solid fa-envelope field-icon"></i>
                            <input type="email" id="email"
                                value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>"
                                placeholder="Enter email" required>
                        </div>
                    </div>

                    <div class="form-section-label" style="margin-top:0.2rem">Security</div>

                    <div class="field">
                        <label for="password">New Password</label>
                        <div class="field-inner">
                            <i class="fa-solid fa-lock field-icon"></i>
                            <input type="password" id="password"
                                placeholder="Leave blank to keep current">
                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword(this)"></i>
                        </div>
                        <span class="field-hint">Minimum 8 characters recommended</span>
                    </div>

                </div>

                <div class="form-card-footer">
                    <button type="button" class="btn-reset" onclick="resetForm()">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </button>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="toast-container"></div>

<script>
function syncAvatar() {
    const val    = document.getElementById('username').value.trim();
    const circle = document.getElementById('avatarCircle');
    const nameEl = document.getElementById('avatarName');
    if (circle) circle.textContent = val.charAt(0).toUpperCase() || 'U';
    if (nameEl) nameEl.textContent = val || 'User';
}

function togglePassword(icon) {
    const field = document.getElementById('password');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function resetForm() {
    document.getElementById('password').value = '';
    document.getElementById('password').type  = 'password';
    document.querySelector('.toggle-password').classList.replace('fa-eye-slash', 'fa-eye');
}

function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast     = document.createElement('div');
    const icon      = type === 'success'
        ? '<i class="fa-solid fa-circle-check"></i>'
        : '<i class="fa-solid fa-circle-xmark"></i>';
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `${icon}<span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => toast.remove(), 450);
    }, 3500);
}

document.getElementById('profileForm').addEventListener('submit', e => {
    e.preventDefault();
    const payload = {
        username: document.getElementById('username').value,
        email:    document.getElementById('email').value,
        password: document.getElementById('password').value
    };
    fetch('api/update_profile.php', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            document.getElementById('password').value = '';
            const sn = document.getElementById('sidebarName');
            if (sn) sn.textContent = payload.username;
            const ae = document.getElementById('avatarEmail');
            if (ae) ae.textContent = payload.email;
        }
    })
    .catch(() => showToast('Error updating profile', 'error'));
});
</script>