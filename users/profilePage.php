<?php require_once '../admin/auth.php'; ?>
<?php include 'sidebar.html'; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="./css/profile.css">

<style>
:root {
    --blue-900: #0c1e3d;
    --blue-800: #1a3460;
    --blue-700: #1e4080;
    --blue-600: #1d4ed8;
    --blue-500: #2563eb;
    --blue-400: #3b82f6;
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
    --red:      #dc2626;
    --shadow-md: 0 4px 16px rgba(30,78,180,0.12);
    --shadow-lg: 0 8px 40px rgba(30,78,180,0.18);
    --font: 'Plus Jakarta Sans', sans-serif;
}

* { box-sizing: border-box; }
body, input, button, label { font-family: var(--font) !important; }

.main-content {
    background: var(--gray-50);
    min-height: 100vh;
    padding: 2.5rem 2.5rem 3rem;
    margin-left: 0 !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* ── Page header ── */
.profile-page-header {
    margin-bottom: 2rem;
}
.profile-page-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--blue-900);
    letter-spacing: -0.02em;
}
.profile-page-header p {
    font-size: 0.83rem;
    color: var(--gray-400);
    margin-top: 3px;
}

/* ── Layout ── */
.profile-layout {
    max-width: 520px;
    width: 100%;
}

/* ── Override profile.css input padding to fix icon alignment ── */
.field input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.6rem !important;
    margin-bottom: 0 !important;
    border: 1.5px solid var(--gray-200) !important;
    border-radius: 10px !important;
    font-size: 0.88rem !important;
    color: var(--gray-800);
    background: var(--gray-50);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    box-sizing: border-box !important;
}

/* password field — extra right padding for eye icon */
.field input[type="password"],
.field input[type="text"]#password {
    padding-right: 2.8rem !important;
}

.field input:focus {
    border-color: var(--blue-400) !important;
    background: var(--white) !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12) !important;
}

.field input::placeholder { color: var(--gray-400); }

/* ── Form card ── */
.form-card {
    background: var(--white);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.form-card-header {
    background: linear-gradient(135deg, var(--blue-900), var(--blue-600));
    padding: 1.4rem 1.75rem;
}
.form-card-header h2 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.1rem;
}
.form-card-header p {
    font-size: 0.76rem;
    color: rgba(255,255,255,0.55);
    margin-top: 2px;
}

.form-card-body {
    padding: 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ── Field ── */
.field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.field label {
    font-size: 0.76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--gray-600);
}

.field-inner {
    position: relative;
    display: flex;
    align-items: center;
}

.field-icon {
    position: absolute;
    left: 14px;
    color: var(--gray-400);
    font-size: 0.85rem;
    pointer-events: none;
}

.field input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.6rem;
    border: 1.5px solid var(--gray-200);
    border-radius: 10px;
    font-size: 0.88rem;
    color: var(--gray-800);
    background: var(--gray-50);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}

.field input:focus {
    border-color: var(--blue-400);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

.field input::placeholder { color: var(--gray-400); }

/* password toggle */
.toggle-password {
    position: absolute;
    right: 14px;
    color: var(--gray-400);
    cursor: pointer;
    font-size: 0.85rem;
    transition: color 0.15s;
    z-index: 1;
}
.toggle-password:hover { color: var(--blue-500); }

/* section divider */
.form-section-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--gray-400);
    padding-bottom: 0.6rem;
    border-bottom: 1px solid var(--gray-100);
    margin-bottom: 0.1rem;
}

/* hint */
.field-hint {
    font-size: 0.72rem;
    color: var(--gray-400);
    margin-top: 2px;
}

/* ── Footer buttons ── */
.form-card-footer {
    padding: 1.25rem 1.75rem;
    border-top: 1px solid var(--gray-100);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.btn-save {
    background: var(--blue-500);
    color: #fff;
    border: none;
    padding: 0.65rem 1.6rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-save:hover { background: var(--blue-600); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,0.3); }
.btn-save:active { transform: none; }

.btn-reset {
    background: var(--gray-100);
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
    padding: 0.65rem 1.2rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.88rem;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-reset:hover { background: var(--gray-200); }

/* ── Toast ── */
#toast-container {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.toast {
    padding: 0.75rem 1.1rem;
    border-radius: 10px;
    font-family: var(--font);
    font-size: 0.83rem;
    font-weight: 500;
    box-shadow: var(--shadow-md);
    max-width: 320px;
    animation: toastIn 0.25s ease;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.toast-success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
.toast-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.toast.fade-out { animation: toastOut 0.4s ease forwards; }

@keyframes toastIn  { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
@keyframes toastOut { from { opacity:1; } to { opacity:0; transform:translateY(6px); } }
</style>

<div class="main-content">

    <div class="profile-layout">
        <div class="profile-page-header">
            <h1>My Profile</h1>
            <p>Manage your account information and security settings</p>
        </div>

        <!-- Form card -->
        <div class="form-card">
            <div class="form-card-header">
                <h2>Edit Profile</h2>
                <p>Update your username, email, or password</p>
            </div>

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

                    <div class="form-section-label" style="margin-top:0.25rem">Security</div>

                    <div class="field">
                        <label for="password">New Password</label>
                        <div class="field-inner">
                            <i class="fa-solid fa-lock field-icon"></i>
                            <input type="password" id="password" placeholder="Leave blank to keep current">
                            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword(this)"></i>
                        </div>
                        <span class="field-hint">Minimum 8 characters recommended</span>
                    </div>

                </div>

                <div class="form-card-footer">
                    <button type="button" class="btn-reset" onclick="resetForm()">Cancel</button>
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
// Sync avatar initial with username input
function syncAvatar() {
    const val = document.getElementById('username').value.trim();
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
    const toast = document.createElement('div');
    const icon  = type === 'success' ? '✓' : '✕';
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;
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
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            document.getElementById('password').value = '';
            // update sidebar footer name if present
            const sn = document.getElementById('sidebarName');
            if (sn) sn.textContent = payload.username;
            document.getElementById('avatarEmail').textContent = payload.email;
        }
    })
    .catch(() => showToast('Error updating profile', 'error'));
});
</script>