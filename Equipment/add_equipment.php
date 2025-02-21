<?php
// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include_once '../systembsdh.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = $_POST['equipment_name'];
    $is_available = $_POST['is_available'];
    $status = $_POST['status'];
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : NULL;

    // Insert data into the database
    $query = "INSERT INTO equipment_inventory (equipment_name, is_available, status, assigned_to) 
              VALUES ('$equipment_name', '$is_available', '$status', '$assigned_to')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Equipment Added Successfully!'); window.location.href='view_equipment.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <link rel="stylesheet" href="add.css">
</head>
<body>

    <h2>Add Equipment</h2>
    <form action="" method="POST">
        <label for="equipment_name">Equipment Name:</label>
        <input type="text" id="equipment_name" name="equipment_name" required>

        <label for="is_available">Availability:</label>
        <select id="is_available" name="is_available" required>
            <option value="1">Available</option>
            <option value="0">Not Available</option>
        </select>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Active">Active</option>
            <option value="For Replacement">For Replacement</option>
        </select>

        <label for="assigned_to">Assigned To (Optional):</label>
        <input type="text" id="assigned_to" name="assigned_to">

        <button type="submit">Add Equipment</button>
        <button type="reset">Reset</button>
    </form>

</body>
</html>
