<?php
session_start();
require_once 'db.php';

$db = new Database();
$conn = $db->getConnection();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = sanitize($_POST['name']);
    $email            = sanitize($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role             = sanitize($_POST['role']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $otp = rand(100000, 999999);
                $otpStmt = $conn->prepare("UPDATE users SET otp=? WHERE email=?");
                $otpStmt->bind_param("ss", $otp, $email);
                $otpStmt->execute();
                $otpStmt->close();

                require_once "send_otp.php";
                sendOTP($email, $otp);

                $_SESSION['verify_email'] = $email;
                header("Location: verify_otp.php");
                exit();
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTRIX Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --blue-900: #0c1e3d;
            --blue-800: #1a3460;
            --blue-600: #1d4ed8;
            --blue-500: #2563eb;
            --blue-400: #3b82f6;
            --blue-200: #bfdbfe;
            --blue-100: #dbeafe;
            --blue-50:  #eff6ff;
            --white:    #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-800) 50%, var(--blue-600) 100%);
            background-attachment: fixed;
            position: relative;
            overflow-y: auto;
            padding: 6rem 1rem 3rem;
        }

        body::before {
            content: '';
            position: fixed;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            filter: blur(80px);
            top: -200px; left: -150px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            filter: blur(80px);
            bottom: -150px; right: -100px;
            pointer-events: none;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* ── BACK BUTTON ── */
        .back-btn {
            position: fixed;
            top: 1.5rem;
            left: 1.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            backdrop-filter: blur(8px);
            transition: all 0.2s;
            z-index: 10;
        }
        .back-btn:hover {
            color: var(--white);
            background: rgba(255,255,255,0.18);
            transform: translateX(-2px);
        }

        /* ── CARD ── */
        .card {
            position: relative;
            z-index: 1;
            background: var(--white);
            border-radius: 20px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 24px 64px rgba(0,0,0,0.25), 0 4px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            animation: popIn 0.4s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        @keyframes popIn {
            from { opacity:0; transform: scale(0.94) translateY(16px); }
            to   { opacity:1; transform: scale(1) translateY(0); }
        }

        /* Card header */
        .card-header {
            background: var(--blue-900);
            padding: 1.75rem 2rem;
            text-align: center;
        }

        .card-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.9rem;
        }

        .card-logo-icon {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .card-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.06em;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 0.25rem;
        }

        .card-subtitle {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
        }

        /* Card body */
        .card-body { padding: 1.75rem 2rem 0; }

        /* Error / Success */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.7rem 0.9rem;
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.2rem;
            animation: shake 0.35s ease;
        }
        .alert-error   { background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; }
        .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; animation:none; }

        @keyframes shake {
            0%,100% { transform:translateX(0); }
            25%      { transform:translateX(-5px); }
            75%      { transform:translateX(5px); }
        }

        /* Fields */
        .field { margin-bottom: 1rem; }

        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--gray-600);
            margin-bottom: 0.38rem;
        }

        .field-inner {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-icon {
            position: absolute;
            left: 13px;
            color: var(--gray-400);
            font-size: 0.82rem;
            pointer-events: none;
        }

        .field input {
            width: 100%;
            padding: 0.7rem 1rem 0.7rem 2.55rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.88rem;
            color: var(--gray-800);
            background: var(--gray-100);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field input:focus {
            border-color: var(--blue-400);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        .field input.is-error { border-color: #f87171; }
        .field input::placeholder { color: var(--gray-400); }

        .toggle-pwd {
            position: absolute;
            right: 13px;
            color: var(--gray-400);
            cursor: pointer;
            font-size: 0.82rem;
            transition: color 0.15s;
        }
        .toggle-pwd:hover { color: var(--blue-500); }

        /* Inline field error */
        .field-error {
            display: none;
            font-size: 0.71rem;
            color: #dc2626;
            margin-top: 0.3rem;
            padding-left: 0.2rem;
        }

        /* Password strength bar */
        .strength-wrap {
            margin-top: 0.4rem;
            height: 4px;
            background: var(--gray-200);
            border-radius: 999px;
            overflow: hidden;
        }
        .strength-bar {
            height: 100%;
            width: 0;
            border-radius: 999px;
            transition: width 0.3s, background 0.3s;
        }

        /* Role buttons */
        .role-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
            margin-top: 0.38rem;
        }

        .role-btn {
            padding: 0.65rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            background: var(--gray-100);
            color: var(--gray-600);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }
        .role-btn:hover {
            border-color: var(--blue-300);
            color: var(--blue-600);
            background: var(--blue-50);
        }
        .role-btn.selected {
            border-color: var(--blue-500);
            background: var(--blue-50);
            color: var(--blue-600);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        /* Submit */
        .submit-btn {
            width: 100%;
            margin-top: 0.25rem;
            padding: 0.82rem;
            background: var(--blue-500);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 16px rgba(37,99,235,0.3);
            transition: all 0.2s;
        }
        .submit-btn:hover {
            background: var(--blue-600);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.4);
        }
        .submit-btn:active { transform: none; }

        /* Footer */
        .card-footer {
            text-align: center;
            padding: 1.1rem 2rem 1.5rem;
            font-size: 0.8rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-100);
            margin-top: 1.5rem;
        }
        .card-footer a {
            color: var(--blue-500);
            font-weight: 600;
            text-decoration: none;
        }
        .card-footer a:hover { color: var(--blue-600); }
    </style>
</head>
<body>

    <div class="bg-grid"></div>



    <div class="card">

        <div class="card-header">
            <div class="card-logo">
                
                <span class="card-logo-name">INVENTRIX</span>
            </div>
            <div class="card-title">Create account</div>
            <div class="card-subtitle">Join INVENTRIX to manage your inventory</div>
        </div>

        <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form id="signupForm" method="POST">

                <div class="field">
                    <label for="fullName">Full Name</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-user field-icon"></i>
                        <input type="text" id="fullName" name="name"
                            placeholder="Your full name"
                            value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                    </div>
                    <div class="field-error" id="nameError">Please enter your full name</div>
                </div>

                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-envelope field-icon"></i>
                        <input type="email" id="email" name="email"
                            placeholder="you@example.com"
                            value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                    </div>
                    <div class="field-error" id="emailError">Please enter a valid email</div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" id="password" name="password"
                            placeholder="Min. 6 characters" required>
                        <i class="fa-solid fa-eye toggle-pwd" id="togglePwd"></i>
                    </div>
                    <div class="strength-wrap"><div class="strength-bar" id="strengthBar"></div></div>
                    <div class="field-error" id="passwordError">Password must be at least 6 characters</div>
                </div>

                <div class="field">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" id="confirmPassword" name="confirm_password"
                            placeholder="Re-enter your password" required>
                        <i class="fa-solid fa-eye toggle-pwd" id="toggleConfirm"></i>
                    </div>
                    <div class="field-error" id="confirmError">Passwords do not match</div>
                </div>

                <div class="field">
                    <label>Select Role</label>
                    <div class="role-group">
                        <button type="button" class="role-btn <?= (!isset($role) || $role == 'user') ? 'selected' : '' ?>" data-role="user">
                            <i class="fa-solid fa-user"></i> User
                        </button>
                        <button type="button" class="role-btn <?= (isset($role) && $role == 'admin') ? 'selected' : '' ?>" data-role="admin">
                            <i class="fa-solid fa-shield-halved"></i> Admin
                        </button>
                    </div>
                    <input type="hidden" id="selectedRole" name="role" value="<?= isset($role) ? htmlspecialchars($role) : 'user' ?>">
                </div>

                <button type="submit" class="submit-btn">
                    Create Account <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>
        </div>

        <div class="card-footer">
            Already have an account? <a href="login.php">Sign in</a>
        </div>

    </div>

    <script>
        // Role toggle
        document.querySelectorAll('.role-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selectedRole').value = this.dataset.role;
            });
        });

        // Password strength
        document.getElementById('password').addEventListener('input', function () {
            const v = this.value;
            const bar = document.getElementById('strengthBar');
            let s = 0;
            if (v.length >= 6)  s = 33;
            if (v.length >= 8)  s = 66;
            if (v.length >= 10 && /[A-Z]/.test(v) && /[0-9]/.test(v)) s = 100;
            bar.style.width = s + '%';
            bar.style.background = s < 34 ? '#ef4444' : s < 67 ? '#f59e0b' : '#22c55e';
        });

        // Eye toggles
        function makeToggle(btnId, fieldId) {
            document.getElementById(btnId).addEventListener('click', function () {
                const f = document.getElementById(fieldId);
                f.type = f.type === 'password' ? 'text' : 'password';
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
        makeToggle('togglePwd', 'password');
        makeToggle('toggleConfirm', 'confirmPassword');

        // Validation
        const form = document.getElementById('signupForm');

        function showErr(id, inputId) {
            document.getElementById(id).style.display = 'block';
            if (inputId) document.getElementById(inputId).classList.add('is-error');
        }
        function hideErr(id, inputId) {
            document.getElementById(id).style.display = 'none';
            if (inputId) document.getElementById(inputId).classList.remove('is-error');
        }

        form.addEventListener('submit', function (e) {
            const name     = document.getElementById('fullName').value.trim();
            const email    = document.getElementById('email').value.trim();
            const pwd      = document.getElementById('password').value;
            const confirm  = document.getElementById('confirmPassword').value;
            let ok = true;

            hideErr('nameError','fullName');
            hideErr('emailError','email');
            hideErr('passwordError','password');
            hideErr('confirmError','confirmPassword');

            if (name.length < 2)                                    { showErr('nameError','fullName');    ok=false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))         { showErr('emailError','email');      ok=false; }
            if (pwd.length < 6)                                     { showErr('passwordError','password'); ok=false; }
            if (pwd !== confirm)                                     { showErr('confirmError','confirmPassword'); ok=false; }

            if (!ok) e.preventDefault();
        });

        // Blur / focus inline validation
        ['fullName','email','password','confirmPassword'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('focus', () => {
                const map = {fullName:'nameError',email:'emailError',password:'passwordError',confirmPassword:'confirmError'};
                hideErr(map[id], id);
            });
            el.addEventListener('blur', () => {
                const v = el.value;
                if (id === 'fullName'        && v.trim().length < 2)                       showErr('nameError','fullName');
                if (id === 'email'           && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v))    showErr('emailError','email');
                if (id === 'password'        && v.length < 6)                              showErr('passwordError','password');
                if (id === 'confirmPassword' && v !== document.getElementById('password').value) showErr('confirmError','confirmPassword');
            });
        });
    </script>

</body>
</html>