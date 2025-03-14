<?php

include '../Pages/sidebar.php';
include '../database.php';

// Add user (Nurse/Doctor)
if (isset($_POST['add_user'])) {
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $passwordtxt = $_POST['password'];
    $role = $_POST['role']; // 'nurse' or 'doctor'
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO users (id_number, email, password, passwordtxt, role, created_at)
            VALUES ('$id_number', '$email', '$password', '$passwordtxt', '$role', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update user
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $passwordtxt = $_POST['password'];
    $role = $_POST['role']; // 'nurse' or 'doctor'

    $sql = "UPDATE users SET id_number='$id_number', email='$email', password='$password', 
            passwordtxt='$passwordtxt', role='$role' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete user
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Display users (Nurse & Doctor)
$sql_users = "SELECT * FROM users WHERE role='nurse' OR role='doctor' ORDER BY created_at DESC";
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/um.css">
    <title>Manage Nurses & Doctors</title>
</head>
<body>
    <h1>Manage Nurses & Doctors</h1>

    <!-- Add User Form -->
    <form action="" method="POST">
        <h2>Add New User</h2>
        <label for="id_number">ID Number:</label>
        <input type="text" name="id_number" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="nurse">Nurse</option>
            <option value="doctor">Doctor</option>
        </select><br>
        <input type="submit" name="add_user" value="Add User">
    </form>

    <h2>User List</h2>
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
        <?php while ($row = $result_users->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['id_number']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['passwordtxt']; ?></td>
            <td><?php echo ucfirst($row['role']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <!-- Update Form -->
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="text" name="id_number" value="<?php echo $row['id_number']; ?>" required><br>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
                    <input type="password" name="password" value="<?php echo $row['passwordtxt']; ?>" required><br>
                    <select name="role">
                        <option value="nurse" <?= $row['role'] === 'nurse' ? 'selected' : '' ?>>Nurse</option>
                        <option value="doctor" <?= $row['role'] === 'doctor' ? 'selected' : '' ?>>Doctor</option>
                    </select><br>
                    <input type="submit" name="update_user" value="Update">
                </form>

                <!-- Delete Form -->
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="submit" name="delete_user" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
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
