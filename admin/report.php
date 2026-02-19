<?php
// require_once 'auth.php';
require_once 'db.php';
$db = new Database();
$conn = $db->getConnection();

$res = $conn->query("SELECT DISTINCT supplier FROM products");
$pageTitle = "Products Report";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventrix – <?= $pageTitle ?></title>
    <link rel="stylesheet" href="./css/report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar-container">
        <?php include 'sidebar.html'; ?>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php include 'header.php'; ?>

        <div class="page-content">

            <!-- Filters -->
            <div class="content-header">
                <div class="content-title">
                    <h2>Filter Reports</h2>
                </div>
            </div>

            <div class="filter-section">
                <h3 class="filter-title">Report Filters</h3>
                <form id="reportFilterForm">
                    <div class="filter-form">
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select id="supplier">
                                <option>All Suppliers</option>
                                <?php
                                // Load suppliers dynamically
                                require_once 'db.php';
                                $res = $conn->query("SELECT DISTINCT supplier FROM products");
                                while($row = $res->fetch_assoc()){
                                    echo "<option>{$row['supplier']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select id="product">
                                <option>All Products</option>
                                <?php
                                $res = $conn->query("SELECT DISTINCT product_name FROM products");
                                while($row = $res->fetch_assoc()){
                                    echo "<option>{$row['product_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn">Generate Report</button>
                    </div>
                </form>
            </div>

            <!-- Report Table -->
            <div class="content-header">
                <div class="content-title">
                    <h2>Report Preview</h2>
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
                    <tbody id="reportTableBody">
                        <!-- Dynamic rows go here -->
                    </tbody>
                </table>
            </div>

            <!-- Export Button -->
            <div class="export-options">
                <button class="btn" onclick="window.location.href='export_products.php'">
                    Export to Excel
                </button>
            </div>

        </div>

        <div class="footer">
            <p>© 2025 Inventrix. All rights reserved.</p>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Load products initially
    loadReportData();

    // Filter form submit
    document.getElementById('reportFilterForm').addEventListener('submit', e => {
        e.preventDefault();
        loadReportData();
    });

    function loadReportData(){
        const supplier = document.getElementById('supplier').value;
        const product  = document.getElementById('product').value;

        fetch(`fetch_report_products.php?supplier=${encodeURIComponent(supplier)}&product=${encodeURIComponent(product)}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('reportTableBody');
                tbody.innerHTML = '';

                if(data.length === 0){
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">No products found</td></tr>`;
                    return;
                }

                data.forEach(item => {
                    const totalPrice = (item.unit_price * item.stock).toFixed(2);
                    const alertStatus = item.stock < 10 ? 'Low' : 'High';
                    const alertClass = item.stock < 10 ? 'status-cancelled' : 'status-completed';

                    tbody.innerHTML += `
                        <tr>
                            <td>${item.created_at}</td>
                            <td>${item.supplier}</td>
                            <td>${item.product_name}</td>
                            <td>${item.stock}</td>
                            <td>Rs. ${parseFloat(item.unit_price).toFixed(2)}</td>
                            <td>Rs. ${totalPrice}</td>
                            <td class="${alertClass}">${alertStatus}</td>
                        </tr>
                    `;
                });
            })
            .catch(err => console.error(err));
    }

});
</script>

</body>
</html>