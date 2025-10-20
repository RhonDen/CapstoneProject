<?php
// appointments.php - Create and manage appointments
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $role == 'patient') {
    $dentist_id = $_POST['dentist_id'];
    $clinic_id = $_POST['clinic_id'];
    $date = $_POST['date'];
    $purpose = $_POST['purpose'];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, dentist_id, clinic_id, appointment_date, purpose) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $dentist_id, $clinic_id, $date, $purpose]);
    $success = "Appointment booked!";
}

// Fetch user's appointments
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE " . ($role == 'patient' ? 'patient_id' : 'dentist_id') . " = ?");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Appointments</h1>
        <?php if ($role == 'patient'): ?>
            <form method="POST">
                <input type="number" name="dentist_id" placeholder="Dentist ID" required>
                <input type="number" name="clinic_id" placeholder="Clinic ID" required>
                <input type="datetime-local" name="date" required>
                <select name="purpose" required>
                    <option value="braces">Braces</option>
                    <option value="filling">Filling</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="extraction">Extraction</option>
                    <option value="other">Other</option>
                </select>
                <button type="submit">Book Appointment</button>
            </form>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php endif; ?>
        
        <h2>Your Appointments</h2>
        <ul>
            <?php foreach ($appointments as $appt): ?>
                <li><?php echo htmlspecialchars($appt['appointment_date'] . ' - ' . $appt['purpose'] . ' (' . $appt['status'] . ')'); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>