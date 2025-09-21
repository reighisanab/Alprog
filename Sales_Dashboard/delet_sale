<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$id = $_POST['id'];
// Delete from database
$sql = "DELETE FROM sales WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
if ($stmt->execute()) {
echo json_encode(['status' => 'success', 'message' =>
'Sale deleted successfully!']);
} else {
echo json_encode(['status' => 'error', 'message' =>
'Failed to delete sale.']);
}
}
?>
