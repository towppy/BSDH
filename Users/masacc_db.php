<?php include_once 'header.php'; ?>

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
    <div class="sidebar">
        <div class="sidebar-logo">
            <h2>Master</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">Overview</a></li>
            <li><a href="usermanage.php">User Management</a></li>
            <li><a href="#">Registration</a></li>
            <li><a href="#">Medical Records</a></li>
            <li><a href="#">Pharmacy Inventory</a></li>
            <li><a href="#">Equipment</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome to the Master Dashboard</h1>
        </header>

        <div class="overview">
            <h2>Overview</h2>
            <p>This is the main area where you can view important information.</p>
        </div>

        <div class="user-management">
            <h2>User Management</h2>
            <p>Manage users and their roles here.</p>
        </div>

        <div class="settings">
            <h2>Settings</h2>
            <p>Customize your dashboard settings.</p>
        </div>
    </div>

    <script src="script.js"></script> <!-- If you want to add any JS functionalities -->
</body>
</html>
