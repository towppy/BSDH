<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="headerstyle.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
            <img src="../Images/sdlogo.png" alt="sdlogo" width="50" height="50">

                <a href="masacc_db.php">BSDH</a>
            </div>
            <nav>
                <ul>
                    <li><a href="masacc_db.php">Dashboard</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
