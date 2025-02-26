<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require '../systembsdh.php';

// Ensure database connection exists
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = trim($_POST['id_number']);
    $password = $_POST['password'];

    // Prepare a secure query
    $stmt = $conn->prepare("SELECT user_id, id_number, password, role, is_active FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            if ($row['is_active']) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];

                // Redirect based on role or specific user
                if ($row['id_number'] === 'masacc') {
                    header("Location: home.php");
                    exit();
                } elseif ($row['role'] === 'admin') {
                    header("Location: home.php");
                    exit();
                } else {
                    $error = "Access Denied. Contact an admin.";
                }
            } else {
                $error = "Your account is inactive. Contact support.";
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this ID.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="loginstyle.css">
    <style>
        body {
            background: url('../Images/bgl.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo-login">
                <img src="../Images/sdlogo.png" alt="Logo">
            </div>
            <h2>Log In</h2>
            
            <form method="POST">
                <div class="input-container">
                    <input type="text" name="id_number" placeholder="ID Number" required>
                </div>
                <div class="input-container password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <img src="../Images/eyeclose.png" id="togglePassword" class="eye-icon" onclick="togglePassword()">
                </div>
                
                <button type="submit" class="login-btn">Log In</button>
            </form>
        </div>
    </div>
   
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("togglePassword");

            eyeIcon.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeIcon.src = "../Images/eyeopen.png";
                } else {
                    passwordInput.type = "password";
                    eyeIcon.src = "../Images/eyeclose.png";
                }
            });
        });
    </script>
</body>
</html>
