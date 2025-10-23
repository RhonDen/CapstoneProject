<?php
// appointments.php - Appointment management (mock)
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
$mock_appointments = [
    ['date' => '2023-10-01 10:00', 'purpose' => 'cleaning', 'status' => 'confirmed']
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $role == 'patient') {
    $mock_appointments[] = ['date' => $_POST['date'], 'purpose' => $_POST['purpose'], 'status' => 'pending'];
    $success = "Booked!";
}
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
                <input type="datetime-local" name="date" required>
                <select name="purpose" required>
                    <option value="braces">Braces</option>
                    <option value="filling">Filling</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="extraction">Extraction</option>
                    <option value="other">Other</option>
                </select>
                <button type="submit">Book</button>
            </form>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php endif; ?>
        
        <h2>Your Appointments</h2>
        <ul>
            <?php foreach ($mock_appointments as $appt): ?>
                <li><?php echo $appt['date'] . ' - ' . $appt['purpose'] . ' (' . $appt['status'] . ')'; ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>