<?php
// Start session to access session variables
session_start();

// Check if the user is logged in and has either admin or master_admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'master')) {
    // Redirect to login page if not an admin or master admin
    header('Location: login.php');
    exit();
}

include '../Pages/sidebar.php';
include '../database.php';

$error_message = "";

// Add admin (similar to adding staff)
if (isset($_POST['add_admin'])) {
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure password hash
    $passwordtxt = $_POST['password'];
    $role = 'admin';  // For admin users
    $created_at = date('Y-m-d H:i:s');

    // Check if ID number already exists
    $check_sql = "SELECT * FROM users WHERE id_number = '$id_number'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $error_message = "ID number already exists!";
    } else {
        $sql = "INSERT INTO users (id_number, email, password, passwordtxt, role, created_at)
                VALUES ('$id_number', '$email', '$password', '$passwordtxt', '$role', '$created_at')";

        if ($conn->query($sql) === TRUE) {
            $error_message = "New admin added successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

// Update admin (same as for staff)
if (isset($_POST['update_admin'])) {
    $user_id = $_POST['user_id'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $passwordtxt = $_POST['password'];
    $role = 'admin';  // For admin users

    $sql = "UPDATE users SET id_number='$id_number', email='$email', password='$password', 
            passwordtxt='$passwordtxt', role='$role' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $error_message = "Admin updated successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Delete admin
if (isset($_POST['delete_admin'])) {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $error_message = "Admin deleted successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Display admins only
$sql_admin = "SELECT * FROM users WHERE role='admin' ORDER BY created_at DESC";
$result_admin = $conn->query($sql_admin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/um.css">
    <title>Manage Admins</title>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <script>
            showAlert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>

    <h1>Manage Admins</h1>

    <form action="" method="POST">
        <h2>Add New Admin</h2>
        <label for="id_number">ID Number:</label>
        <input type="text" name="id_number" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="add_admin" value="Add Admin">
    </form>

    <h2>Admins List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Number</th>
            <th>Email</th>
            <th>Password</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result_admin->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['id_number']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['passwordtxt']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <!-- Update Form -->
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="text" name="id_number" value="<?php echo $row['id_number']; ?>" required><br>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
                    <input type="password" name="password" value="<?php echo $row['passwordtxt']; ?>" required><br>
                    <input type="submit" name="update_admin" value="Update Admin">
                </form>

                <!-- Delete Form -->
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="submit" name="delete_admin" value="Delete Admin" onclick="return confirm('Are you sure you want to delete this admin?');">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
