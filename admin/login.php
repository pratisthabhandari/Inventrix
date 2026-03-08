<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'db.php';

$db = new Database();
$conn = $db->getConnection();
if (!$conn) die("Database connection failed.");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, full_name, email, password, role, is_verified FROM users WHERE email = ? LIMIT 1");
        if (!$stmt) die("Prepare failed: " . $conn->error);

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role']  = $user['role'];
                header("Location: " . ($user['role'] === 'admin' ? "admin_dashboard.php" : "../users/user_dashboard.php"));
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
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
    <title>INVENTRIX — Sign In</title>
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
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-900) 0%, var(--blue-800) 50%, var(--blue-600) 100%);
            position: relative;
            overflow: hidden;
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

        /* Dot grid */
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
            box-shadow: 0 20px 60px rgba(37,99,235,0.12), 0 4px 16px rgba(0,0,0,0.05);
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
            padding: 2rem 2rem 1.75rem;
            text-align: center;
        }

        .card-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.1rem;
        }

        .card-logo-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .card-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.06em;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 0.3rem;
        }

        .card-subtitle {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
        }

        /* Card body */
        .card-body { padding: 1.75rem 2rem; }

        /* Error */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 0.7rem 0.9rem;
            border-radius: 9px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            animation: shake 0.35s ease;
        }

        @keyframes shake {
            0%,100% { transform:translateX(0); }
            25%      { transform:translateX(-5px); }
            75%      { transform:translateX(5px); }
        }

        /* Fields */
        .field { margin-bottom: 1.1rem; }

        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--gray-600);
            margin-bottom: 0.4rem;
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
            padding: 0.72rem 1rem 0.72rem 2.55rem;
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

        /* Submit */
        .submit-btn {
            width: 100%;
            margin-top: 0.5rem;
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

    <a href="../index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <div class="card">

        <div class="card-header">
            <div class="card-logo">
              
                <span class="card-logo-name">INVENTRIX</span>
            </div>
            <div class="card-title">Welcome!</div>
            <div class="card-subtitle">Sign in to your account to continue</div>
        </div>

        <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-envelope field-icon"></i>
                        <input type="email" id="email" name="email"
                            placeholder="you@example.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="field-inner">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" id="password" name="password"
                            placeholder="Enter your password" required>
                        <i class="fa-solid fa-eye toggle-pwd" id="togglePwd"></i>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Sign In <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

        </div>

        <div class="card-footer">
            Don't have an account? <a href="signup.php">Sign up</a>
        </div>

    </div>

    <script>
        document.getElementById('togglePwd').addEventListener('click', function () {
            const f = document.getElementById('password');
            f.type = f.type === 'password' ? 'text' : 'password';
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>