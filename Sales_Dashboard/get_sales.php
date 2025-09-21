<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM sales ORDER BY sale_date
DESC");
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($sales)) {
foreach ($sales as $sale) {
echo "<tr>";
echo "<td>{$sale['id']}</td>";
echo "<td>{$sale['product_name']}</td>";
echo "<td>$" . number_format($sale['amount'], 2) .
"</td>";
echo "<td>{$sale['sale_date']}</td>";
echo "<td><button class='btn btn-danger btn-sm
delete-btn' data-id='{$sale['id']}'>Delete</button></td>";
echo "</tr>";
}
} else {
echo "<tr><td colspan='5' class='text-center'>No sales data
available.</td></tr>";
}
?>
