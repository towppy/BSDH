<?php
session_start();
require '../systembsdh.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = $_POST['id_number'];
    $password = $_POST['password'];

    // Prepare a secure query
    $stmt = $conn->prepare("SELECT user_id, id_number, password, role, is_active FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            if ($row['is_active']) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];

                // Redirect based on role or specific user
                if ($row['id_number'] === 'masacc') {
                    header("Location: ./masacc_db.php");
                } elseif ($row['role'] === 'admin') {
                    header("Location: adacc_db.php");
                } else {
                    $error = "Access Denied. Contact an admin.";
                }
                exit();
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
    <title>Login</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
    <div class="login-container">
    <div class="logo-login">
    <img src="../Images/sdlogo.png" alt="Logo">
</div>

        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="id_number" placeholder="ID Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
