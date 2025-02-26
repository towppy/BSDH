<?php 
include_once '../Users/header.php'; 

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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adacc_db.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <h2>Admin</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../Users/home.php">Overview</a></li>
            <li><a href="#">Medical Records</a></li>
            <li><a href="#">Pharmacy Inventory</a></li>
            <li><a href="../Equipment/view_equipment.php">Equipment</a></li>
            <li><a href="../Users/logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome to the Admin Dashboard</h1>
        </header>

        <a href="#" class="card">
            <div class="overview">
                <h2>Overview</h2>
                <p>Know more about Barangay South Daang Hari's Health Center.</p>
            </div>
        </a>

        <a href="#" class="card">
            <div class="medical-records">
                <h2>Medical Records</h2>
                <p>View and manage patient medical records.</p>
            </div>
        </a>

        <a href="#" class="card">
            <div class="pharmacy-inventory">
                <h2>Pharmacy Inventory</h2>
                <p>Manage pharmacy stock and supplies.</p>
            </div>
        </a>

        <a href="../Equipment/view_equipment.php" class="card">
            <div class="equipment">
                <h2>Equipment</h2>
                <p>Monitor and manage medical equipment.</p>
            </div>
        </a>
    </div>

    <script src="script.js"></script>
</body>
</html>
