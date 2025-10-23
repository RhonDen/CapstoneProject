  <?php
  // logout.php - Logout (handles both GET and POST)
  session_start();
  session_destroy();
  header("Location: login.php");
  exit;
  ?>
  