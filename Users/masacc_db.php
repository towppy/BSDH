<?php 
include_once 'header.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Dashboard</title>
    <link rel="stylesheet" href="masacc_db.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <h2>Master</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">Overview</a></li>
            <li><a href="usermanage.php">User Management</a></li>
            <li><a href="#">Medical Records</a></li>
            <li><a href="#">Pharmacy Inventory</a></li>
            <li><a href="../Equipment/view_equipment.php">Equipment</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome to the Master Dashboard</h1>
        </header>

        <a href="#" class="card">
            <div class="overview">
                <h2>Overview</h2>
                <p>Know more about Barangay South Daang Hari's Health Center.</p>
            </div>
        </a>

        <a href="#" class="card">
            <div class="user-management">
                <h2>User Management</h2>
                <p>Manage admin accounts.</p>
            </div>
        </a>

        <a href="#" class="card">
            <div class="settings">
                <h2>Settings</h2>
                <p>Change from light to dark mode.</p>
            </div>
        </a>
    </div>

    <script src="script.js"></script>
</body>
</html>
