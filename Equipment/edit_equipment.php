<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once '../systembsdh.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM equipment_inventory WHERE equipment_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = $_POST['equipment_name'];
    $is_available = $_POST['is_available'];
    $status = $_POST['status'];
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : NULL;

    $update_query = "UPDATE equipment_inventory 
                     SET equipment_name='$equipment_name', is_available='$is_available', status='$status', assigned_to=" . 
                     ($assigned_to ? "'$assigned_to'" : "NULL") . " 
                     WHERE equipment_id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Equipment Updated Successfully!'); window.location.href='view_equipment.php';</script>";
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
    <title>Edit Equipment</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>

    <div class="container-wrapper">
        <!-- Header Section with Logo -->
        <div class="header">
            <img src="../Images/sdlogo.png"alt="BSDH Logo">
            <h2>Edit Equipment</h2>
        </div>

        <form action="" method="POST">
            <label for="equipment_name">Equipment Name:</label>
            <input type="text" id="equipment_name" name="equipment_name" value="<?php echo $row['equipment_name']; ?>" required>

            <label for="is_available">Availability:</label>
            <select id="is_available" name="is_available" required>
                <option value="1" <?php echo $row['is_available'] ? 'selected' : ''; ?>>Available</option>
                <option value="0" <?php echo !$row['is_available'] ? 'selected' : ''; ?>>Not Available</option>
            </select>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Active" <?php echo $row['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="For Replacement" <?php echo $row['status'] == 'For Replacement' ? 'selected' : ''; ?>>For Replacement</option>
            </select>

            <label for="assigned_to">Assigned To:</label>
            <input type="text" id="assigned_to" name="assigned_to" value="<?php echo isset($row['assigned_to']) ? $row['assigned_to'] : ''; ?>">

            <button type="submit">Update</button>
        </form>
    </div>

</body>
</html>
