<?php
require_once 'config.php';
// Ambil parameter tanggal dari GET request
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;
// Validasi dan format tanggal
if ($start_date) {
$start_date = date('Y-m-d', strtotime($start_date));
}
if ($end_date) {
$end_date = date('Y-m-d', strtotime($end_date));
}
// Buat query dasar
$sql = "SELECT DATE(sale_date) as date, SUM(amount) as total
FROM sales
WHERE 1=1";
// Tambahkan filter tanggal jika ada
if ($start_date) {
$sql .= " AND sale_date >= '$start_date'";
}
if ($end_date) {
$sql .= " AND sale_date <= '$end_date'";
}
// Tambahkan grouping dan ordering
$sql .= " GROUP BY DATE(sale_date) ORDER BY date";
// Eksekusi query
$stmt = $pdo->query($sql);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Siapkan data untuk chart
$labels = [];
$values = [];
// Proses hasil query
foreach ($sales as $sale) {
    $labels[] = $sale['date'];
    $values[] = $sale['total'];
    }
    // Kirim response dalam format JSON
    echo json_encode([
    'labels' => $labels,
    'values' => $values
    ]);
    ?>
