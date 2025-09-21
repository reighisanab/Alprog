<?php
require_once 'config.php';
// Fetch sales data from the database
$stmt = $pdo->query("SELECT * FROM sales ORDER BY sale_date
DESC");
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
initial-scale=1.0">
<title>Sales Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script
src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/boots
trap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row"></div>
    <!-- Form Input Data -->
    <div class="col-md-4">
        <h3>Add New Sale</h3>
        <form id="saleForm">
            <div class="mb-3">
                <label>Product Name:</label>
                <input type="text" name="product_name"
class="form-control" required>
</div>
<div class="mb-3">
<label>Amount:</label>
<input type="number" name="amount"
class="form-control" step="0.01" required>
</div>
<div class="mb-3">
<label>Date:</label>
<input type="date" name="sale_date"
class="form-control" required>
</div>
<button type="submit" class="btn btn-primary">Add

Sale</button>
</form>
</div>
<!-- Chart Area -->
<div class="col-md-8">
<h3>Sales Chart</h3>
<canvas id="salesChart"></canvas>
</div>
</div>

<!-- Sales Data Table -->
 <div class="row mt-5">
<div class="col-12">
<h3>Sales Data</h3>
<table class="table">
<thead>
<tr>
<th>ID</th>
<th>Product</th>
<th>Amount</th>
<th>Date</th>
<th>Actions</th>
</tr>
</thead>
<tbody id="salesData">
<?php
if (!empty($sales)) {
foreach ($sales as $sale) {
echo "<tr data-id='{$sale['id']}'>";
echo "<td>{$sale['id']}</td>";
echo
"<td>{$sale['product_name']}</td>";
echo "<td>$" .
number_format($sale['amount'], 2) . "</td>";
echo "<td>{$sale['sale_date']}</td>";
echo "<td><button class='btn
btn-danger btn-sm delete-btn'
data-id='{$sale['id']}'>Delete</button></td>";
echo "</tr>";
echo "</tr>";
}
} else {
echo "<tr><td colspan='5'
class='text-center'>No sales data available.</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<script>
let salesChart;
// Initialize Chart
function initChart(data) {
const ctx =
document.getElementById('salesChart').getContext('2d');
salesChart = new Chart(ctx, {
type: 'line',
data: {
labels: data.labels,
datasets: [{
label: 'Daily Sales',
data: data.values,
borderColor: 'rgb(75, 192, 192)',
tension: 0.1
}]
},
options: {
responsive: true,
scales: {
y: {
beginAtZero: true
}
}
}
});
}
// Update Chart with New Data
function updateChart() {
$.ajax({
url: 'get_chart_data.php',
method: 'GET',
success: function(response) {
const data = JSON.parse(response);
if (salesChart) {
salesChart.destroy();
}
initChart(data);
}
});
}
// Add New Sale Directly to the Table
function addSaleToTable(sale) {
const newRow = `<tr data-id="${sale.id}">
<td>${sale.id}</td>
<td>${sale.product_name}</td>
<td>$${parseFloat(sale.amount).toFixed(2)}</td>
<td>${sale.sale_date}</td>
<td><button class="btn btn-danger btn-sm delete-btn"
data-id="${sale.id}">Delete</button></td>
</tr>`;
$('#salesData').prepend(newRow);
}
// Load Sales Data into the Table
function loadSalesData() {
$.ajax({
url: 'get_sales.php',
method: 'GET',
success: function(response) {
$('#salesData').html(response);
}
});
}
$(document).ready(function() {
updateChart();
loadSalesData();

// Handle form submission for adding a sale
$('#saleForm').on('submit', function(e) {
e.preventDefault();
$.ajax({
url: 'add_sale.php',
method: 'POST',
data: $(this).serialize(),
success: function(response) {
const result = JSON.parse(response);
if (result.status === 'success') {
addSaleToTable(result.sale); // Add the new sale directly to the table
updateChart(); // Update the chart with the
new data
$('#saleForm')[0].reset(); // Reset the form
alert('Sale added successfully!');
} else {
alert(result.message || 'Error adding sale.');
}
}
});
});

// Handle delete button clicks
$(document).on('click', '.delete-btn', function() {
const id = $(this).data('id');
const row = $(this).closest('tr'); // Get the table row
element
if (confirm('Are you sure you want to delete this sale?')) {
$.ajax({
url: 'delete_sale.php',
method: 'POST',
data: { id: id },
success: function(response) {
alert('Sale deleted successfully!');
row.remove(); // Remove the row from the DOM
updateChart(); // Update the chart
}
});
}
});
});

</script>
</body>
</html>
