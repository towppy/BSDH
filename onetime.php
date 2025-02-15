<?php
require 'systembsdh.php';

$masacc_id = 'masacc';
$plain_password = 'pass123';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id_number = ?");
$stmt->bind_param("ss", $hashed_password, $masacc_id);

if ($stmt->execute()) {
    echo "Password for masacc updated successfully.";
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
