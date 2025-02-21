<?php 
session_start();

// Determine the correct dashboard link
$dashboardLink = "Users/login.php"; // Default if not logged in

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = "../Admin/adacc_db.php";
    } else {
        $dashboardLink = "masacc_db.php";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSDH Home</title>
    <link rel="stylesheet" href="home.css"> <!-- Separate CSS File -->
</head>
<body>

    <header>
        <div class="container">
            <div class="logo">
                <img src="../Images/sdlogo.png" alt="BSDH Logo">
                <a href="home.php">BSDH</a>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="<?php echo $dashboardLink; ?>">Dashboard</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
       
            <h1>Welcome to BSDH</h1>
            <p>Your all-in-one solution for managing equipment, users, and more.</p>
            <a href="<?php echo $dashboardLink; ?>" class="btn">Go to Dashboard</a>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> BSDH. All Rights Reserved.</p>
    </footer>

</body>
</html>
