<?php
// login.php - Login with mock users (fixed to include registered users)
session_start();

// Hardcoded mock users
$hardcoded_users = [
    ['id' => 1, 'username' => 'dentist1', 'password' => 'pass', 'role' => 'dentist'],
    ['id' => 2, 'username' => 'patient1', 'password' => 'pass', 'role' => 'patient']
];

// Merge with session-stored users (from registration)
$mock_users = $hardcoded_users;
if (isset($_SESSION['mock_users'])) {
    $mock_users = array_merge($mock_users, $_SESSION['mock_users']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    foreach ($mock_users as $user) {
        if ($user['username'] == $username && $user['password'] == $password) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dents-City</title>
    <link href="https://fonts.googleapis.com/css2?family=Days+One&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login to Dents-City</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Mock: dentist1/pass (dentist), patient1/pass (patient)</p>
        <p>No account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
