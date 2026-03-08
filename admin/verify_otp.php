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
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-800) 50%, var(--blue-600) 100%);
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
            padding: 2rem 1rem;
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
            top: 1.5rem; left: 1.75rem;
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
            max-width: 420px;
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
        .card-body { padding: 1.75rem 2rem; }

        /* Email badge */
        .email-badge {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }

        .email-badge i {
            color: var(--blue-500);
            font-size: 0.85rem;
        }

        .email-badge span {
            font-size: 0.82rem;
            color: var(--gray-600);
        }

        .email-badge strong {
            color: var(--blue-700, #1e40af);
            font-weight: 700;
        }

        /* OTP inputs */
        .otp-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
            display: block;
        }

        .otp-boxes {
            display: flex;
            gap: 0.6rem;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .otp-box {
            width: 52px; height: 56px;
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            background: var(--gray-100);
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--blue-900);
            text-align: center;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            caret-color: var(--blue-500);
        }

        .otp-box:focus {
            border-color: var(--blue-400);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        .otp-box.filled {
            border-color: var(--blue-400);
            background: var(--blue-50);
        }

        /* Hidden real input (fallback) */
        #otpHidden { display: none; }

        /* Alerts */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.7rem 0.9rem;
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }
        .alert-error   { background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; animation: shake 0.35s ease; }
        .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; }

        @keyframes shake {
            0%,100% { transform:translateX(0); }
            25%      { transform:translateX(-5px); }
            75%      { transform:translateX(5px); }
        }

        /* Submit */
        .submit-btn {
            width: 100%;
            margin-top: 1.25rem;
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
        .submit-btn:disabled {
            background: var(--gray-400);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Success state */
        .success-state {
            text-align: center;
            padding: 1rem 0;
        }

        .success-icon {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: #f0fdf4;
            border: 2px solid #86efac;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1rem;
            animation: bounceIn 0.5s cubic-bezier(0.34,1.56,0.64,1);
        }

        @keyframes bounceIn {
            from { transform: scale(0); opacity:0; }
            to   { transform: scale(1); opacity:1; }
        }

        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--blue-900);
            margin-bottom: 0.4rem;
        }

        .success-sub {
            font-size: 0.82rem;
            color: var(--gray-400);
        }

        .redirect-bar {
            height: 3px;
            background: var(--gray-200);
            border-radius: 999px;
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .redirect-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--blue-500), var(--blue-400));
            border-radius: 999px;
            animation: fillBar 2.5s linear forwards;
        }

        @keyframes fillBar {
            from { width: 0%; }
            to   { width: 100%; }
        }

        /* Card footer */
        .card-footer {
            text-align: center;
            padding: 1rem 2rem 1.5rem;
            font-size: 0.8rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-100);
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
            <div class="card-title">Verify your email</div>
            <div class="card-subtitle">Enter the 6-digit code we sent you</div>
        </div>

        <div class="card-body">

            <?php if (!empty($success)): ?>
                <div class="success-state">
                  
                    <div class="success-title">Email Verified!</div>
                    <div class="success-sub">You can now login...</div>
                    <div class="redirect-bar"><div class="redirect-fill"></div></div>
                </div>

            <?php else: ?>

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
                    <label class="otp-label">Enter OTP</label>
                    <div class="otp-boxes">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="0">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="1">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="2">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="3">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="4">
                        <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" data-index="5">
                    </div>
                    <input type="hidden" name="otp" id="otpHidden">

                    <button type="submit" class="submit-btn" id="verifyBtn" disabled>
                        <i class="fa-solid fa-shield-check"></i> Verify OTP
                    </button>
                </form>

            <?php endif; ?>

        </div>

        <?php if (empty($success)): ?>
        <div class="card-footer">
            Didn't receive the code? <a href="signup.php">Resend</a>
        </div>
        <?php endif; ?>

    </div>

    <script>
        const boxes   = document.querySelectorAll('.otp-box');
        const hidden  = document.getElementById('otpHidden');
        const btn     = document.getElementById('verifyBtn');

        function updateHidden() {
            const digits = [...boxes].map(b => b.value.trim());
            const val = digits.join('');
            hidden.value = val;
            // style filled boxes
            boxes.forEach(b => b.classList.toggle('filled', b.value !== ''));
            // enable button only when all 6 boxes have exactly 1 digit
            btn.disabled = digits.some(d => d === '') || val.length !== 6;
        }

        boxes.forEach((box, i) => {
            box.addEventListener('input', function () {
                // only allow digits, take last char if somehow multiple
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

            // allow pasting full OTP
            box.addEventListener('paste', function (e) {
                e.preventDefault();
                const text = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                [...text].forEach((ch, j) => { if (boxes[j]) boxes[j].value = ch; });
                if (boxes[Math.min(text.length, 5)]) boxes[Math.min(text.length, 5)].focus();
                updateHidden();
            });
        });

        // Focus first box on load
        if (boxes[0]) boxes[0].focus();
    </script>

</body>
</html>