<?php
require_once '../../admin/auth.php';
require_once '../../admin/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$username = trim($data['username'] ?? '');
$email    = trim($data['email']    ?? '');
$password = trim($data['password'] ?? '');

$response = ['success' => false, 'message' => 'Something went wrong'];

if (!$username || !$email) {
    $response['message'] = 'Username and Email are required';
    echo json_encode($response);
    exit;
}

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    $response['message'] = 'Session expired. Please log in again.';
    echo json_encode($response);
    exit;
}

// Get connection via Database class
$db   = new Database();
$conn = $db->getConnection();

if ($password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $hashed, $userId);
} else {
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $userId);
}

if ($stmt->execute()) {
    $_SESSION['user_name']  = $username;
    $_SESSION['user_email'] = $email;

    $response['success'] = true;
    $response['message'] = 'Profile updated successfully!';
} else {
    $response['message'] = 'Database error: ' . $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
