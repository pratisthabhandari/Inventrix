<?php
require_once 'db.php';

// FIX: Create DB connection
$db = new Database();
$conn = $db->getConnection();

// Excel download headers
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=products_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch products
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Start Excel table
echo "
<table border='1'>
    <tr>
        <th>Date</th>
        <th>Supplier</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Alert</th>
    </tr>
";

while ($row = $result->fetch_assoc()) {

    $total = $row['unit_price'] * $row['stock'];
    $alert = $row['stock'] < 10 ? "Low" : "High";

    echo "
    <tr>
        <td>{$row['created_at']}</td>
        <td>{$row['supplier']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['stock']}</td>
        <td>{$row['unit_price']}</td>
        <td>{$total}</td>
        <td>{$alert}</td>
    </tr>
    ";
}

echo "</table>";
?>