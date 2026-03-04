<?php
require_once 'auth.php';
require_once 'db.php';

$db = new Database();
$conn = $db->getConnection();

$pageTitle = "Products Report";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <title>Inventrix – <?= $pageTitle ?></title>
</head>
<body>

<div id="sidebar-container"></div>

<div class="main-content">
    <?php include 'header.php'; ?>

    <div class="page-content">
        <div class="content-header">
            <div class="content-title">
                <h2>Products Report</h2>
                <p>Inventory overview based on current product records.</p>
            </div>

        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Alert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT product_name, unit_price, stock, supplier, created_at FROM products ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){

                            $totalPrice = $row['stock'] * $row['unit_price'];

                            // Stock Alert Logic
                            if($row['stock'] <= 5){
                                $alert = "Low";
                                $alertClass = "status-cancelled";
                            } else {
                                $alert = "High";
                                $alertClass = "status-completed";
                            }

                            echo "<tr>
                                <td>". date('Y-m-d', strtotime($row['created_at'])) ."</td>
                                <td>{$row['supplier']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['stock']}</td>
                                <td>Rs. ". number_format($row['unit_price'],2) ."</td>
                                <td>Rs. ". number_format($totalPrice,2) ."</td>
                                <td class='{$alertClass}'>{$alert}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="export-options">
            <button class="export-btn pdf">Export as PDF</button>
            <button class="export-btn excel" onclick="window.location='export_products.php'">
    Export as Excel
</button>
        </div>
    </div>

    <div class="footer">
        <p>© 2025 Inventrix. All rights reserved.</p>
    </div>
</div>

<script>
// Load Sidebar
fetch('./sidebar.html')
.then(res => res.text())
.then(data => {
    document.getElementById('sidebar-container').innerHTML = data;
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-item a').forEach(link => {
        link.classList.toggle('active', link.getAttribute('href').split('/').pop() === currentPage);
    });
});
</script>


</script>

</body>
</html>
