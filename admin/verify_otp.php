<?php
session_start();
require_once 'db.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['verify_email'])) {
    header("Location: login.php");
    exit();
}

$email   = $_SESSION['verify_email'];
$message = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];

    $stmt = $conn->prepare("SELECT otp FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dbOtp);
    $stmt->fetch();
    $stmt->close();

    if ($otp == $dbOtp) {
        $update = $conn->prepare("UPDATE users SET is_verified=1, otp=NULL WHERE email=?");
        $update->bind_param("s", $email);
        $update->execute();
        unset($_SESSION['verify_email']);
        $success = "Email verified successfully! Redirecting you to login...";
        echo "<script>setTimeout(() => window.location.href = 'login.php?verified=1', 2500);</script>";
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTRIX — Verify Email</title>
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
            --green-border: #a7f3d0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
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
            margin-bottom: 2rem;
        }

        /* ── EMAIL BADGE ── */
        .email-badge {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            margin-bottom: 1.75rem;
        }

        .email-badge i {
            color: var(--blue);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .email-badge span {
            font-size: 0.84rem;
            color: var(--muted);
        }

        .email-badge strong {
            color: var(--text);
            font-weight: 700;
        }

        /* ── ALERT ── */
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
        .alert-error   { background: var(--red-bg);  border: 1px solid #f5bcbc; color: var(--red); }
        .alert-success { background: var(--green-bg); border: 1px solid var(--green-border); color: var(--green); }

        /* ── OTP BOXES ── */
        .otp-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.85rem;
            text-align: center;
        }

        .otp-boxes {
            display: flex;
            gap: 0.65rem;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .otp-box {
            width: 58px;
            height: 64px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            background: var(--input-bg);
            font-family: 'Nunito', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text);
            text-align: center;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            caret-color: var(--blue);
        }

        .otp-box:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(75,175,212,0.13);
        }

        .otp-box.filled {
            border-color: var(--blue);
            background: var(--white);
            color: var(--blue-dark);
        }

        #otpHidden { display: none; }

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
        .btn:disabled {
            background: var(--blue-soft);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
        }

        /* ── SUCCESS STATE ── */
        .success-state {
            text-align: center;
            padding: 0.5rem 0 0.75rem;
        }

        .success-icon {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: var(--green-bg);
            border: 2px solid var(--green-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--green);
            margin: 0 auto 1.25rem;
            animation: bounceIn 0.5s cubic-bezier(0.34,1.56,0.64,1);
        }

        @keyframes bounceIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .success-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        .success-sub {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .redirect-bar {
            height: 4px;
            background: var(--blue-pale);
            border-radius: 999px;
            margin-top: 1.75rem;
            overflow: hidden;
        }

        .redirect-fill {
            height: 100%;
            background: var(--blue);
            border-radius: 999px;
            animation: fillBar 2.5s linear forwards;
        }

        @keyframes fillBar {
            from { width: 0%; }
            to   { width: 100%; }
        }

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

    <a href="login.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Login
    </a>

    <div class="wrapper">

        <div class="brand">
            <div class="brand-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            <span class="brand-name">Inventrix</span>
        </div>

        <div class="card">

            <?php if (!empty($success)): ?>

                <div class="success-state">
                    <div class="success-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="success-title">Email Verified!</div>
                    <div class="success-sub">You'll be redirected to login shortly…</div>
                    <div class="redirect-bar"><div class="redirect-fill"></div></div>
                </div>

            <?php else: ?>

                <div class="card-title">Verify your email</div>
                <div class="card-sub">Enter the 6-digit code we sent you</div>

                <div class="email-badge">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Code sent to <strong><?= htmlspecialchars($email) ?></strong></span>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="otpForm">
                    <label class="otp-label">Enter verification code</label>
                    <div class="otp-boxes">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="0">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="1">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="2">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="3">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="4">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="5">
                    </div>
                    <input type="hidden" name="otp" id="otpHidden">

                    <button type="submit" class="btn" id="verifyBtn" disabled>
                        <i class="fa-solid fa-shield-check"></i> Verify Email
                    </button>
                </form>

                <div class="foot">
                    Didn't receive the code? <a href="signup.php">Resend</a>
                </div>

            <?php endif; ?>

        </div>

    </div>

    <script>
        const boxes  = document.querySelectorAll('.otp-box');
        const hidden = document.getElementById('otpHidden');
        const btn    = document.getElementById('verifyBtn');

        function updateHidden() {
            const digits = [...boxes].map(b => b.value.trim());
            const val = digits.join('');
            hidden.value = val;
            boxes.forEach(b => b.classList.toggle('filled', b.value !== ''));
            btn.disabled = digits.some(d => d === '') || val.length !== 6;
        }

        boxes.forEach((box, i) => {
            box.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '').slice(-1);
                if (this.value && i < boxes.length - 1) boxes[i + 1].focus();
                updateHidden();
            });

            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && i > 0) {
                    boxes[i - 1].value = '';
                    boxes[i - 1].focus();
                    updateHidden();
                }
            });

            box.addEventListener('paste', function (e) {
                e.preventDefault();
                const text = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                [...text].forEach((ch, j) => { if (boxes[j]) boxes[j].value = ch; });
                if (boxes[Math.min(text.length, 5)]) boxes[Math.min(text.length, 5)].focus();
                updateHidden();
            });
        });

        if (boxes[0]) boxes[0].focus();
    </script>

</body>
</html>