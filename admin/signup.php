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
    <title>INVENTRIX — Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg:        #e8f4fb;
            --bg2:       #d4ecf7;
            --blue:      #4bafd4;
            --blue-dark: #2a8db5;
            --blue-deep: #1a6e91;
            --blue-pale: #cce8f5;
            --blue-soft: #a8d8ec;
            --white:     #ffffff;
            --text:      #1c3a4a;
            --muted:     #6b9ab0;
            --border:    #c0dcea;
            --input-bg:  #f4fafd;
            --red:       #e05a5a;
            --red-bg:    #fdf2f2;
            --green:     #2da06b;
            --green-bg:  #f0fdf6;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 3rem 1rem 3rem;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(to top, var(--bg2), transparent);
            pointer-events: none;
        }

        /* ── BACK LINK ── */
        .back-link {
            position: fixed;
            top: 1.4rem;
            left: 1.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--blue-dark);
            text-decoration: none;
            z-index: 10;
            transition: gap 0.18s, color 0.15s;
        }
        .back-link:hover { gap: 0.65rem; color: var(--blue-deep); }

        /* ── WRAPPER ── */
        .wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── BRAND ── */
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: var(--blue);
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: white;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(75,175,212,0.3);
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: 0.13em;
            text-transform: uppercase;
        }

        /* ── CARD ── */
        .card {
            background: var(--white);
            border-radius: 22px;
            border: 1.5px solid var(--border);
            box-shadow:
                0 2px 0 var(--blue-pale),
                0 8px 32px rgba(74,175,212,0.1),
                0 2px 6px rgba(0,0,0,0.04);
            padding: 3rem 3rem 2.5rem;
        }

        .card::before {
            content: '';
            display: block;
            width: 48px;
            height: 4px;
            background: var(--blue);
            border-radius: 2px;
            margin: 0 auto 2rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
            text-align: center;
            margin-bottom: 0.4rem;
        }

        .card-sub {
            font-size: 0.88rem;
            color: var(--muted);
            text-align: center;
            margin-bottom: 2.25rem;
        }

        /* ── ALERTS ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .alert-error   { background: var(--red-bg);   border: 1px solid #f5bcbc; color: var(--red); }
        .alert-success { background: var(--green-bg);  border: 1px solid #a7f3d0; color: var(--green); }

        /* ── FIELDS ── */
        .field { margin-bottom: 1.25rem; }

        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .fi {
            position: absolute;
            left: 14px;
            font-size: 0.85rem;
            color: var(--blue-soft);
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.9rem 2.6rem 0.9rem 2.6rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--input-bg);
            font-family: 'Nunito', sans-serif;
            font-size: 0.92rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }

        .input-wrap input::placeholder { color: #b0d0df; }

        .input-wrap input:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(75,175,212,0.13);
        }

        .input-wrap input.is-error {
            border-color: var(--red);
            box-shadow: 0 0 0 4px rgba(224,90,90,0.1);
        }

        .eye-btn {
            position: absolute;
            right: 14px;
            color: #b0d0df;
            font-size: 0.85rem;
            cursor: pointer;
            transition: color 0.15s;
        }
        .eye-btn:hover { color: var(--blue); }

        /* inline error */
        .field-error {
            display: none;
            font-size: 0.75rem;
            color: var(--red);
            margin-top: 0.35rem;
            padding-left: 0.2rem;
            font-weight: 600;
        }

        /* strength bar */
        .strength-wrap {
            margin-top: 0.45rem;
            height: 4px;
            background: var(--blue-pale);
            border-radius: 999px;
            overflow: hidden;
        }
        .strength-bar {
            height: 100%;
            width: 0;
            border-radius: 999px;
            transition: width 0.3s, background 0.3s;
        }

        /* ── ROLE BUTTONS ── */
        .role-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .role-btn {
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            background: var(--input-bg);
            color: var(--muted);
            font-family: 'Nunito', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            transition: all 0.18s;
        }
        .role-btn:hover {
            border-color: var(--blue-soft);
            color: var(--blue-dark);
            background: var(--white);
        }
        .role-btn.selected {
            border-color: var(--blue);
            background: var(--white);
            color: var(--blue-dark);
            box-shadow: 0 0 0 4px rgba(75,175,212,0.13);
        }

        /* ── SUBMIT BUTTON ── */
        .btn {
            width: 100%;
            margin-top: 1.75rem;
            padding: 0.95rem;
            background: var(--blue);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.96rem;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 16px rgba(74,175,212,0.35);
            transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
        }
        .btn:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(74,175,212,0.4);
        }
        .btn:active { transform: none; }

        /* ── FOOTER ── */
        .foot {
            text-align: center;
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1.5px solid var(--blue-pale);
            font-size: 0.84rem;
            color: var(--muted);
        }
        .foot a {
            color: var(--blue-dark);
            font-weight: 700;
            text-decoration: none;
        }
        .foot a:hover { color: var(--blue-deep); text-decoration: underline; }
    </style>
</head>
<body>

    <a href="../index.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <div class="wrapper">

        <div class="brand">
            <div class="brand-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            <span class="brand-name">Inventrix</span>
        </div>

        <div class="card">

            <div class="card-title">Create account</div>
            <div class="card-sub">Join Inventrix to manage your inventory</div>

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
                    <div class="input-wrap">
                        <i class="fa-solid fa-user fi"></i>
                        <input type="text" id="fullName" name="name"
                            placeholder="Your full name"
                            value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                    </div>
                    <div class="field-error" id="nameError">Please enter your full name</div>
                </div>

                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope fi"></i>
                        <input type="email" id="email" name="email"
                            placeholder="you@example.com"
                            value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                    </div>
                    <div class="field-error" id="emailError">Please enter a valid email</div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock fi"></i>
                        <input type="password" id="password" name="password"
                            placeholder="Min. 6 characters" required>
                        <i class="fa-solid fa-eye eye-btn" id="togglePwd"></i>
                    </div>
                    <div class="strength-wrap"><div class="strength-bar" id="strengthBar"></div></div>
                    <div class="field-error" id="passwordError">Password must be at least 6 characters</div>
                </div>

                <div class="field">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock fi"></i>
                        <input type="password" id="confirmPassword" name="confirm_password"
                            placeholder="Re-enter your password" required>
                        <i class="fa-solid fa-eye eye-btn" id="toggleConfirm"></i>
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

                <button type="submit" class="btn">
                    Create Account &nbsp;<i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <div class="foot">
                Already have an account? <a href="login.php">Sign in</a>
            </div>

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
            bar.style.background = s < 34 ? '#e05a5a' : s < 67 ? '#f59e0b' : '#2da06b';
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

        // Validation helpers
        function showErr(id, inputId) {
            document.getElementById(id).style.display = 'block';
            if (inputId) document.getElementById(inputId).classList.add('is-error');
        }
        function hideErr(id, inputId) {
            document.getElementById(id).style.display = 'none';
            if (inputId) document.getElementById(inputId).classList.remove('is-error');
        }

        // Submit validation
        document.getElementById('signupForm').addEventListener('submit', function (e) {
            const name    = document.getElementById('fullName').value.trim();
            const email   = document.getElementById('email').value.trim();
            const pwd     = document.getElementById('password').value;
            const confirm = document.getElementById('confirmPassword').value;
            let ok = true;

            hideErr('nameError','fullName');
            hideErr('emailError','email');
            hideErr('passwordError','password');
            hideErr('confirmError','confirmPassword');

            if (name.length < 2)                                { showErr('nameError','fullName');         ok=false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))     { showErr('emailError','email');           ok=false; }
            if (pwd.length < 6)                                 { showErr('passwordError','password');     ok=false; }
            if (pwd !== confirm)                                 { showErr('confirmError','confirmPassword'); ok=false; }

            if (!ok) e.preventDefault();
        });

        // Blur validation
        ['fullName','email','password','confirmPassword'].forEach(id => {
            const el = document.getElementById(id);
            const map = { fullName:'nameError', email:'emailError', password:'passwordError', confirmPassword:'confirmError' };
            el.addEventListener('focus', () => hideErr(map[id], id));
            el.addEventListener('blur', () => {
                const v = el.value;
                if (id === 'fullName'        && v.trim().length < 2)                    showErr('nameError','fullName');
                if (id === 'email'           && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) showErr('emailError','email');
                if (id === 'password'        && v.length < 6)                           showErr('passwordError','password');
                if (id === 'confirmPassword' && v !== document.getElementById('password').value) showErr('confirmError','confirmPassword');
            });
        });
    </script>

</body>
</html>