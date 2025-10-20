<?php
// dashboard.php - Main dashboard
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch data based on role
if ($role == 'dentist') {
    // Dentist: Show clinic details, appointments, patient records
    $stmt = $pdo->prepare("SELECT c.name, c.address, c.phone FROM clinics c JOIN users u ON u.clinic_id = c.id WHERE u.id = ?");
    $stmt->execute([$user_id]);
    $clinic = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT a.id, a.appointment_date, a.purpose, a.status, u.username AS patient FROM appointments a JOIN users u ON a.patient_id = u.id WHERE a.dentist_id = ?");
    $stmt->execute([$user_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Patient: Show their appointments
    $stmt = $pdo->prepare("SELECT a.id, a.appointment_date, a.purpose, a.status, u.username AS dentist FROM appointments a JOIN users u ON a.dentist_id = u.id WHERE a.patient_id = ?");
    $stmt->execute([$user_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
        <h1>Welcome to Dents-City Dashboard</h1>
        <?php if ($role == 'dentist' && $clinic): ?>
            <h2>Clinic Details</h2>
            <p>Name: <?php echo htmlspecialchars($clinic['name']); ?></p>
            <p>Address: <?php echo htmlspecialchars($clinic['address']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($clinic['phone']); ?></p>
        <?php endif; ?>
        
        <h2>Appointments</h2>
        <ul>
            <?php foreach ($appointments as $appt): ?>
                <li><?php echo htmlspecialchars($appt['appointment_date'] . ' - ' . $appt['purpose'] . ' (' . $appt['status'] . ') - ' . ($role == 'dentist' ? 'Patient: ' . $appt['patient'] : 'Dentist: ' . $appt['dentist'])); ?></li>
            <?php endforeach; ?>
        </ul>
        
        <a href="appointments.php">Manage Appointments</a> | <a href="analytics.php">View Analytics</a> | <a href="logout.php">Logout</a>
    </div>
</body>
</html>