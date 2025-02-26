<?php
include_once '../systembsdh.php'; // Ensure database connection is included

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); // Sanitize input

    $query = "SELECT id_number, role, is_active, password_updated_at FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        echo "<p><strong>ID Number:</strong> " . htmlspecialchars($user['id_number']) . "</p>";
        echo "<p><strong>Role:</strong> " . htmlspecialchars($user['role']) . "</p>";
        echo "<p><strong>Status:</strong> " . ($user['is_active'] ? 'Active' : 'Inactive') . "</p>";
        
        // Check if password was ever updated
        if ($user['password_updated_at']) {
            echo "<p><strong>Last Password Change:</strong> " . htmlspecialchars($user['password_updated_at']) . "</p>";
        } else {
            echo "<p><strong>Last Password Change:</strong> Never</p>";
        }

        echo "<button onclick='showPasswordForm(" . $user_id . ")'>Reset Password</button>";
    } else {
        echo "<p>User not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
