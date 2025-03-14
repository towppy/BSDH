<?php
include '../database.php'; // Ensure correct path

// Check if there are new pending appointments
$query = "SELECT COUNT(*) AS count FROM appointments WHERE status = 'pending'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo "new";
} else {
    echo "none";
}

$conn->close();
?>
