<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$product_name = $_POST['product_name'];
$amount = $_POST['amount'];
$sale_date = $_POST['sale_date'];
// Insert into database
$sql = "INSERT INTO sales (product_name, amount, sale_date)
VALUES (:product_name, :amount, :sale_date)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_name', $product_name);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':sale_date', $sale_date);
if ($stmt->execute()) {
// Fetch the ID of the newly added sale
$sale_id = $pdo->lastInsertId();
$new_sale = [
'id' => $sale_id,
'product_name' => $product_name,
'amount' => $amount,
'sale_date' => $sale_date
];
// Return JSON response
echo json_encode(['status' => 'success', 'sale' =>
$new_sale]);
} else {
// Return error message
echo json_encode(['status' => 'error', 'message' =>
'Failed to add sale.']);
}
} else {
echo json_encode(['status' => 'error', 'message' => 'Invalid
request.']);
}
