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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg:        #ffffff;
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

        /* subtle tinted bottom */
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

        /* top stripe */
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

        /* ── ERROR ── */
        .error-box {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            background: var(--red-bg);
            border: 1px solid #f5bcbc;
            color: var(--red);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* ── FIELDS ── */
        .field { margin-bottom: 1.25rem; }

        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
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

        .eye-btn {
            position: absolute;
            right: 14px;
            color: #b0d0df;
            font-size: 0.85rem;
            cursor: pointer;
            transition: color 0.15s;
        }
        .eye-btn:hover { color: var(--blue); }

        /* ── BUTTON ── */
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

            <div class="card-title">Welcome!</div>
            <div class="card-sub">Sign in to your account to continue</div>

            <?php if (!empty($error)): ?>
                <div class="error-box">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope fi"></i>
                        <input
                            type="email" id="email" name="email"
                            placeholder="you@example.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock fi"></i>
                        <input
                            type="password" id="password" name="password"
                            placeholder="Enter your password"
                            required>
                        <i class="fa-solid fa-eye eye-btn" id="togglePwd"></i>
                    </div>
                </div>

                <button type="submit" class="btn">
                    Sign In &nbsp;<i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <div class="foot">
                Don't have an account? <a href="signup.php">Create one</a>
            </div>

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