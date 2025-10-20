<?php
// subscription.php - Manage clinic subscriptions
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dentist') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch clinic details
$stmt = $pdo->prepare("SELECT c.id, c.name, c.subscription_tier FROM clinics c JOIN users u ON u.clinic_id = c.id WHERE u.id = ?");
$stmt->execute([$user_id]);
$clinic = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$clinic) {
    die("No clinic associated with this account.");
}

$clinic_id = $clinic['id'];
$current_tier = $clinic['subscription_tier'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upgrade'])) {
    // Simulate upgrade (in real app, integrate payment gateway like Stripe)
    $new_tier = 'premium';
    $stmt = $pdo->prepare("UPDATE clinics SET subscription_tier = ? WHERE id = ?");
    $stmt->execute([$new_tier, $clinic_id]);
    $current_tier = $new_tier;
    $success = "Subscription upgraded to Premium!";
}

// Feature restrictions
$features = [
    'free' => ['Basic dashboard', 'Appointment booking'],
    'premium' => ['Basic dashboard', 'Appointment booking', 'Advanced analytics', 'Predictive demand', 'Revenue reports']
];
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
        <h1>Manage Subscription for <?php echo htmlspecialchars($clinic['name']); ?></h1>
        <p>Current Tier: <?php echo ucfirst($current_tier); ?></p>
        
        <h2>Available Features</h2>
        <ul>
            <?php foreach ($features[$current_tier] as $feature): ?>
                <li><?php echo htmlspecialchars($feature); ?></li>
            <?php endforeach; ?>
        </ul>
        
        <?php if ($current_tier == 'free'): ?>
            <form method="POST">
                <p>Upgrade to Premium for $9.99/month (includes advanced analytics).</p>
                <button type="submit" name="upgrade">Upgrade Now</button>
            </form>
        <?php endif; ?>
        
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
