<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to login page (change to the correct login page path)
header("Location: ../Users/login.php");
exit;
?>
