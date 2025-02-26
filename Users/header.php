<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base URL
$host = "http://" . $_SERVER['HTTP_HOST'];

// Set the base URL to the root
$base_url = $host . "/";

// Default dashboard URL for authenticated users
$dashboard_url = $base_url . "Users/dashboard.php"; // Change this to your default dashboard

// Validate session data
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            $dashboard_url = $base_url . "Admin/adacc_db.php";
            break;
        case 'master':
            $dashboard_url = $base_url . "Users/masacc_db.php";
            break;
        default:
            // Keep default
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="<?= $base_url; ?>Users/headerstyle.css">
</head>
<body>
    <header>
        <div class="container">
            <!-- Logo Section -->
            <div class="logo">
                <img src="<?= $base_url; ?>Images/sdlogo.png" alt="BSDH Logo" width="50" height="50">
                <a href="home.php">BSDH</a>
            </div>
            
            <!-- Navigation -->
            <nav>
                <ul>
                    <li><a href="<?= $dashboard_url; ?>">Dashboard</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?= $base_url; ?>Users/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?= $base_url; ?>Users/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <!-- Profile Section -->
            <div class="profile">
                <img src="<?= $base_url; ?>Images/personnel.png" alt="Profile Image">
                <span>
                    <?= isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['username'] ?? 'User') : 'Guest'; ?>
                </span>
            </div>
        </div>
    </header>
</body>
</html>