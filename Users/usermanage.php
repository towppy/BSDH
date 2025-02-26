<!--On Going. Need to view User details, need to finish
Profile editing first-->

<?php
include_once '../systembsdh.php';
include_once 'header.php';

// Handle user actions (Deactivate, Reactivate, Delete)
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $action = $_GET['action'];
    $user_id = intval($_GET['user_id']); // Ensure user_id is an integer

    if ($action == 'deactivate') {
        $updateQuery = "UPDATE users SET is_active = FALSE WHERE user_id = $user_id";
    } elseif ($action == 'reactivate') {
        $updateQuery = "UPDATE users SET is_active = TRUE WHERE user_id = $user_id";
    } elseif ($action == 'delete') {
        $updateQuery = "DELETE FROM users WHERE user_id = $user_id";
    }

    if (isset($updateQuery) && mysqli_query($conn, $updateQuery)) {
        header("Location: usermanage.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle Adding a New User
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (id_number, password, role, is_active) VALUES ('$id_number', '$hashed_password', '$role', TRUE)";
    if (mysqli_query($conn, $query)) {
        header("Location: usermanage.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle Password Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $user_id = intval($_POST['user_id']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE users SET password = '$hashed_password', password_updated_at = NOW() WHERE user_id = $user_id";
    if (mysqli_query($conn, $updateQuery)) {
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
            margin-right: 10px;
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
            display: none;
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
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
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <h1>User Management</h1>

    <table border="1">
        <tr>
            <th>ID Number</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id_number']); ?></td>
            <td><?php echo htmlspecialchars($row['role']); ?></td>
            <td><?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?></td>
            <td>
                <a href="?action=<?php echo $row['is_active'] ? 'deactivate' : 'reactivate'; ?>&user_id=<?php echo $row['user_id']; ?>">
                    <?php echo $row['is_active'] ? 'Deactivate' : 'Reactivate'; ?>
                </a>
                <a href="javascript:void(0);" onclick="showPasswordForm(<?php echo $row['user_id']; ?>)">Change Password</a>
                <a href="javascript:void(0);" onclick="showUserDetails(<?php echo $row['user_id']; ?>)">View</a>
                <a href="?action=delete&user_id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add New User</h2>
    <button onclick="document.getElementById('add_user_form').style.display='block'">
        Add New User
    </button>

    <div id="add_user_form" class="form-container" style="display: none;">
        <form action="usermanage.php" method="post">
            <label>ID Number:</label>
            <input type="text" name="id_number" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Role:</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="add_user" value="Add User">
        </form>
    </div>

    <!-- Change Password Form -->
    <div id="password_form" class="form-container">
        <h3>Update Password</h3>
        <form action="usermanage.php" method="post">
            <input type="hidden" name="user_id" id="user_id">
            <label>New Password:</label>
            <input type="password" name="new_password" required>
            <input type="submit" name="update_password" value="Update Password">
        </form>
    </div>

    <!-- Modal for Viewing User Details -->
    <div id="userDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>User Details</h3>
            <div id="userDetailsContent"></div>
        </div>
    </div>

    <script>
    function showPasswordForm(userId) {
        var form = document.getElementById('password_form');
        var userIdField = document.getElementById('user_id');
        userIdField.value = userId;
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
    }

    function showUserDetails(userId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('userDetailsContent').innerHTML = xhr.responseText;
            document.getElementById('userDetailsModal').style.display = 'block';
        }
    };
    xhr.open('GET', 'get_user_deets.php?user_id=' + userId, true);
    xhr.send();
}


    function closeModal() {
        document.getElementById('userDetailsModal').style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('userDetailsModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
    </script>
</body>
</html>