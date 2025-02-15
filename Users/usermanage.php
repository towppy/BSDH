<?php
include_once '../systembsdh.php'; 
include_once 'header.php'; 

// Handle account deactivation/reactivation and deletion
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $action = $_GET['action'];
    $user_id = $_GET['user_id'];

    if ($action == 'deactivate') {
        $updateQuery = "UPDATE users SET is_active = FALSE WHERE user_id = $user_id";
        mysqli_query($conn, $updateQuery);
        header("Location: usermanage.php");
        exit;
    } elseif ($action == 'reactivate') {
        $updateQuery = "UPDATE users SET is_active = TRUE WHERE user_id = $user_id";
        mysqli_query($conn, $updateQuery);
        header("Location: usermanage.php");
        exit;
    } elseif ($action == 'delete') {
        $deleteQuery = "DELETE FROM users WHERE user_id = $user_id";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "User deleted successfully!";
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
        header("Location: usermanage.php");
        exit;
    }
}

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Hash the password before inserting
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $query = "INSERT INTO users (id_number, password, role, is_active) 
              VALUES ('$id_number', '$hashed_password', '$role', TRUE)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "User added successfully!";
        header("Location: usermanage.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle updating a user's password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $user_id = $_POST['user_id'];
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $updateQuery = "UPDATE users SET password = '$hashed_password' WHERE user_id = $user_id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Password updated successfully!";
        header("Location: usermanage.php");
        exit;
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }
}

// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #0056b3;
            margin-top: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #0056b3;
            color: white;
        }

        table td {
            background-color: #fff;
        }

        table td a {
            color: #007bff;
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            border-radius: 8px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container select,
        .form-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #0056b3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            table th, table td {
                padding: 10px;
                font-size: 14px;
            }

            .form-container {
                padding: 15px;
            }

            .form-container label {
                font-size: 13px;
            }

            .form-container input[type="text"],
            .form-container input[type="password"],
            .form-container select,
            .form-container input[type="submit"] {
                padding: 10px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <h1>User Management</h1>

    <!-- Display all users in a table -->
    <table border="1">
        <tr>
            <th>ID Number</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id_number']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?></td>
            <td>
                <?php if ($row['is_active']): ?>
                    <a href="?action=deactivate&user_id=<?php echo $row['user_id']; ?>">Deactivate</a>
                <?php else: ?>
                    <a href="?action=reactivate&user_id=<?php echo $row['user_id']; ?>">Reactivate</a>
                <?php endif; ?>
                
                <a href="javascript:void(0);" onclick="showPasswordForm(<?php echo $row['user_id']; ?>)">Change Password</a>
                
                <a href="?action=delete&user_id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add New User</h2>
    <div class="form-container">
        <form action="usermanage.php" method="post">
            <label>ID Number:</label>
            <input type="text" name="id_number" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <label>Role:</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br>
            <input type="submit" name="add_user" value="Add User">
        </form>
    </div>

    <!-- Update Password Form (Hidden initially) -->
    <div id="password_form" class="form-container" style="display:none;">
        <h3>Update Password</h3>
        <form action="usermanage.php" method="post">
            <input type="hidden" name="user_id" id="user_id">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>
            <input type="submit" name="update_password" value="Update Password">
        </form>
    </div>

    <script>
        // JavaScript function to show password change form
        function showPasswordForm(userId) {
            document.getElementById('user_id').value = userId;
            document.getElementById('password_form').style.display = 'block';
        }
    </script>

</body>
</html>
