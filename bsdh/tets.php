<?php
include 'database.php'; // Ensure this path is correct

$id_number = 'ADM-2025001'; // The user's ID number
$new_password = 'pass123!'; // Change this to the actual new password

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update the user's password in the database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id_number = ?");
$stmt->bind_param("ss", $hashed_password, $id_number);

if ($stmt->execute()) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
