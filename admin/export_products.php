<?php
require '../vendor/autoload.php';
require_once 'db.php';

// PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// DB connection
$db = new Database();
$conn = $db->getConnection();

// Query products
$query = "SELECT product_name, unit_price, stock, supplier, created_at FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Create sheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header row
$headers = ["Date", "Supplier", "Product", "Quantity", "Unit Price", "Total Price", "Alert"];
$col = 'A';

foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $sheet->getStyle($col . '1')->getFont()->setBold(true);
    $col++;
}

$row = 2;

// Fill data
while ($data = mysqli_fetch_assoc($result)) {

    $total = $data['stock'] * $data['unit_price'];
    $alert = ($data['stock'] <= 5) ? "Low" : "High";

    $sheet->setCellValue("A$row", date('Y-m-d', strtotime($data['created_at'])));
    $sheet->setCellValue("B$row", $data['supplier']);
    $sheet->setCellValue("C$row", $data['product_name']);
    $sheet->setCellValue("D$row", $data['stock']);
    $sheet->setCellValue("E$row", $data['unit_price']);
    $sheet->setCellValue("F$row", $total);
    $sheet->setCellValue("G$row", $alert);

    $row++;
}

// Auto column width
foreach (range('A', 'G') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Output file to user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Products_Report.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>