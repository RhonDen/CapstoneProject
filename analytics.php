<?php
// analytics.php - Improved analytics with charts
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dentist') {
    header("Location: login.php");
    exit;
}

// Mock data (expanded for charts)
$mock_monthly = [
    ['purpose' => 'cleaning', 'count' => 10],
    ['purpose' => 'filling', 'count' => 5],
    ['purpose' => 'braces', 'count' => 3],
    ['purpose' => 'extraction', 'count' => 2]
];
$mock_revenue = [
    ['purpose' => 'cleaning', 'revenue' => 500.00],
    ['purpose' => 'filling', 'revenue' => 250.00],
    ['purpose' => 'braces', 'revenue' => 150.00],
    ['purpose' => 'extraction', 'revenue' => 100.00]
];
$mock_performance = [
    ['username' => 'Dentist John', 'appointments' => 15],
    ['username' => 'Dentist Jane', 'appointments' => 12]
];
$mock_trends = [
    ['month' => '2023-07', 'visits' => 18],
    ['month' => '2023-08', 'visits' => 22],
    ['month' => '2023-09', 'visits' => 20],
    ['month' => '2023-10', 'visits' => 25]
];
$mock_predictions = [
    ['purpose' => 'braces', 'demand' => 8],
    ['purpose' => 'filling', 'demand' => 6],
    ['purpose' => 'cleaning', 'demand' => 10],
    ['purpose' => 'extraction', 'demand' => 4]
];

// Filter by month (mock - in real app, query DB)
$selected_month = isset($_GET['month']) ? $_GET['month'] : '2023-10';
$filtered_monthly = array_filter($mock_monthly, function($item) use ($selected_month) {
    // Mock filter - assume all data is for selected month
    return true;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Data Analytics</h1>
        
        <!-- Month Filter -->
        <form method="GET" style="margin: 20px 0;">
            <label for="month">Filter by Month:</label>
            <select name="month" id="month" onchange="this.form.submit()">
                <option value="2023-10" <?php if ($selected_month == '2023-10') echo 'selected'; ?>>October 2023</option>
                <option value="2023-09" <?php if ($selected_month == '2023-09') echo 'selected'; ?>>September 2023</option>
                <option value="2023-08" <?php if ($selected_month == '2023-08') echo 'selected'; ?>>August 2023</option>
            </select>
        </form>
        
        <!-- Charts Section -->
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <!-- Monthly Appointment Purposes (Bar Chart) -->
            <div style="flex: 1; min-width: 300px;">
                <h2>Monthly Appointment Purposes</h2>
                <canvas id="monthlyChart"></canvas>
            </div>
            
            <!-- Revenue by Treatment Type (Bar Chart) -->
            <div style="flex: 1; min-width: 300px;">
                <h2>Revenue by Treatment Type</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            
            <!-- Patient Visit Trends (Line Chart) -->
            <div style="flex: 1; min-width: 300px;">
                <h2>Patient Visit Trends</h2>
                <canvas id="trendsChart"></canvas>
            </div>
            
            <!-- Predictive Demand (Pie Chart) -->
            <div style="flex: 1; min-width: 300px;">
                <h2>Predictive Demand</h2>
                <canvas id="demandChart"></canvas>
            </div>
        </div>
        
        <!-- Dentist Performance (List for simplicity) -->
        <h2>Dentist Performance</h2>
        <ul>
            <?php foreach ($mock_performance as $perf): ?>
                <li><?php echo htmlspecialchars($perf['username']) . ': ' . $perf['appointments'] . ' appointments'; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <script>
        // Monthly Purposes Bar Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($filtered_monthly, 'purpose')); ?>,
                datasets: [{
                    label: 'Count',
                    data: <?php echo json_encode(array_column($filtered_monthly, 'count')); ?>,
                    backgroundColor: '#35C1B5',
                    borderColor: '#D9D9D9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Revenue Bar Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($mock_revenue, 'purpose')); ?>,
                datasets: [{
                    label: 'Revenue ($)',
                    data: <?php echo json_encode(array_column($mock_revenue, 'revenue')); ?>,
                    backgroundColor: '#35C1B5',
                    borderColor: '#D9D9D9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Visit Trends Line Chart
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($mock_trends, 'month')); ?>,
                datasets: [{
                    label: 'Visits',
                    data: <?php echo json_encode(array_column($mock_trends, 'visits')); ?>,
                    backgroundColor: 'rgba(53, 193, 181, 0.2)',
                    borderColor: '#35C1B5',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Predictive Demand Pie Chart
        const demandCtx = document.getElementById('demandChart').getContext('2d');
        new Chart(demandCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($mock_predictions, 'purpose')); ?>,
                datasets: [{
                    label: 'Expected Demand',
                    data: <?php echo json_encode(array_column($mock_predictions, 'demand')); ?>,
                    backgroundColor: ['#35C1B5', '#D9D9D9', '#2a9a8f', '#f4f4f4'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
