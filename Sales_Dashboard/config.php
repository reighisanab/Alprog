<?php
// Database connection using PDO
$host = 'localhost';
$dbname = 'sales_db';
$user = 'root';
$pass = '';
try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user,
$pass);
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Connection failed: " . $e->getMessage());
}
?>
