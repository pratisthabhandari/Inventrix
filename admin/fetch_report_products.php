<?php
header("Content-Type: application/json");

require_once 'db.php';

// FIX: Initialize database connection
$db = new Database();
$conn = $db->getConnection();

$supplier = $_GET['supplier'] ?? 'All Suppliers';
$product  = $_GET['product'] ?? 'All Products';

$sql = "SELECT * FROM products WHERE 1";

if ($supplier !== "All Suppliers") {
    $sql .= " AND supplier = '" . $conn->real_escape_string($supplier) . "'";
}

if ($product !== "All Products") {
    $sql .= " AND product_name = '" . $conn->real_escape_string($product) . "'";
}

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["sql_error" => $conn->error]);
    exit;
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>