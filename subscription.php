<?php
// subscription.php - Subscription (mock)
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dentist') {
    header("Location: login.php");
    exit;
}

$current_tier = 'free';
$features = ['free' => ['Basic dashboard'], 'premium' => ['Basic dashboard', 'Advanced analytics']];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_tier = 'premium';
    $success = "Upgraded!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Subscription</h1>
        <p>Tier: <?php echo ucfirst($current_tier); ?></p>
        <h2>Features</h2>
        <ul><?php foreach ($features[$current_tier] as $f) echo "<li>$f</li>"; ?></ul>
        <?php if ($current_tier == 'free'): ?>
            <form method="POST"><button type="submit">Upgrade to Premium</button></form>
        <?php endif; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>