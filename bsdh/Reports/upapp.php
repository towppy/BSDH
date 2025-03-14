<?php
session_start();
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST["appointment_id"];
    $status = $_POST["status"];

    // Update appointment status
    $update_query = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $appointment_id);

    if ($stmt->execute()) {
        // If approved, insert a new record into medical_records
        if ($status == "approved") {
            // Check if a record already exists
            $check_query = "SELECT * FROM medical_records WHERE appointment_id = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("i", $appointment_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows == 0) {
                // Insert new record into medical_records
                $insert_query = "INSERT INTO medical_records (appointment_id) VALUES (?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("i", $appointment_id);
                $insert_stmt->execute();
            }
        }

        echo "success";
    } else {
        echo "error";
    }
    
    $stmt->close();
    $conn->close();
}
?>
