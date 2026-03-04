<?php
session_start();
require_once 'db.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['verify_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['verify_email'];
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
        // Mark verified
        $update = $conn->prepare("UPDATE users SET is_verified=1, otp=NULL WHERE email=?");
        $update->bind_param("s", $email);
        $update->execute();

        unset($_SESSION['verify_email']);

        // Show message then redirect
        $success = "OTP Verified Successfully! You can now login to our system.";
        echo "<script>
            setTimeout(function(){
                window.location.href = 'login.php?verified=1';
            }, 2200);
        </script>";
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="./css/verifyotp.css">
</head>
<body>

<div class="container">
    <h2>Email Verification</h2>
    <p>Please enter the 6-digit OTP sent to your email</p>

    <?php if (!empty($message)): ?>
        <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php else: ?>
    <form method="POST">
        <input type="text" maxlength="6" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify OTP</button>
    </form>
    <?php endif; ?>
</div>

</body>
</html>