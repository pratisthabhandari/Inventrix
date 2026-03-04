<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTP($toEmail, $otpCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'temppratistha1@gmail.com';
        $mail->Password   = 'caor noed svol aryv';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('temppratistha1@gmail.com', 'Inventrix');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP is: <b>$otpCode</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}