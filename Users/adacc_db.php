<?php include_once 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="masacc_db.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <h2>Admin</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="home.php">Overview</a></li>
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
            <h1>Welcome to the Admin Dashboard</h1>
        </header>

        <div class="overview">
            <h2>Overview</h2>
            <p>This is the main area where you can view important administrative information and activities.</p>
        </div>

        <div class="registration">
            <h2>Registration</h2>
            <p>Manage new registrations here. Keep track of all incoming users.</p>
        </div>

        <div class="medical-records">
            <h2>Medical Records</h2>
            <p>Access and manage patient medical records from this section.</p>
        </div>

        <div class="pharmacy-inventory">
            <h2>Pharmacy Inventory</h2>
            <p>View and manage the pharmacy inventory for supplies and medications.</p>
        </div>

        <div class="equipment">
            <h2>Equipment</h2>
            <p>Keep track of medical equipment and ensure they are in good working condition.</p>
        </div>

    </div>

    <script src="script.js"></script> <!-- If you want to add any JS functionalities -->

</body>
</html>
