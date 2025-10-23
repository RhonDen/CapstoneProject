<?php
// register.php - Registration (mock in session)
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Mock storage
    if (!isset($_SESSION['mock_users'])) $_SESSION['mock_users'] = [];
    $_SESSION['mock_users'][] = ['id' => count($_SESSION['mock_users']) + 1, 'username' => $username, 'password' => $password, 'role' => $role];
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Register for Dents-City</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="patient">Patient</option>
                <option value="dentist">Dentist</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>