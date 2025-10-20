

<?php
// config.php - Database configuration
$host = 'localhost';
$dbname = 'dents_city';
$username = 'your_db_user'; // Replace with your DB username
$password = 'your_db_password'; // Replace with your DB password
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>