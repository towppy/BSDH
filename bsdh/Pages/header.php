<?php
session_start(); // Start session to access user data

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    die("Error: Unauthorized access.");
}

// Determine the correct dashboard based on user role
$dashboardPage = ($_SESSION['user_id'] === 'adm-2025001') ? "masterhome.php" : "admhome.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Center Management</title>
    <link rel="stylesheet" href="../CSS/header.css"> 
</head>
<body>
<header class="header">
    <div class="logo">
        <h1>Health Center</h1>
    </div>
    <nav class="nav">
        <ul>
            <li><a href="../Pages/<?= $dashboardPage ?>">Dashboard</a></li>
        </ul>
    </nav>
</header>

</body>
</html>

