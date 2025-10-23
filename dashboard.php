<?php
// dashboard.php - Dashboard with mock data
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];

// Mock data
$mock_appointments = [
    ['date' => '2023-10-01 10:00', 'purpose' => 'cleaning', 'status' => 'confirmed', 'person' => 'Dentist John'],
    ['date' => '2023-10-05 14:00', 'purpose' => 'filling', 'status' => 'pending', 'person' => 'Patient Jane']
];
$mock_clinic = ['name' => 'Smile Clinic', 'address' => '123 Dental St', 'phone' => '555-1234'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Dents-City Dashboard</h1>
        <?php if ($role == 'dentist'): ?>
            <h2>Clinic Details</h2>
            <p>Name: <?php echo $mock_clinic['name']; ?></p>
            <p>Address: <?php echo $mock_clinic['address']; ?></p>
            <p>Phone: <?php echo $mock_clinic['phone']; ?></p>
        <?php endif; ?>
        
        <h2>Appointments</h2>
        <ul>
            <?php foreach ($mock_appointments as $appt): ?>
                <li><?php echo $appt['date'] . ' - ' . $appt['purpose'] . ' (' . $appt['status'] . ') - ' . $appt['person']; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <a href="appointments.php">Appointments</a> | <a href="analytics.php">Analytics</a> | <a href="subscription.php">Subscription</a> | <a href="logout.php">Logout</a>
    </div>
</body>
</html>