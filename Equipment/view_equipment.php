<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Check session data
if (!isset($_SESSION['user_id'])) {
    echo "SESSION ERROR: User ID is missing!<br>";
    print_r($_SESSION);  // Debugging: Check what session data exists
    exit();
}

// Include header
include_once '../Users/header.php';

// Include database connection
include_once '../systembsdh.php';

// Ensure database connection exists
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


$query = "SELECT * FROM equipment_inventory ORDER BY equipment_id ASC";
$result = mysqli_query($conn, $query);


// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>




<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Inventory</title>
    <link rel="stylesheet" href="view.css">
    <link rel="stylesheet" href="../Users/headerstyle.css">

</head>
<body>
    <div class="container">
    <a href="add_equipment.php" class="add-btn">+ Add Equipment</a>

        <h2>Equipment Inventory</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Equipment Name</th>
                    <th>Availability</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['equipment_id']; ?></td>
                        <td><?php echo $row['equipment_name']; ?></td>
                        <td class="availability <?php echo $row['is_available'] ? 'available' : 'not-available'; ?>">
                            <?php echo $row['is_available'] ? 'Available' : 'Not Available'; ?>
                        </td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['assigned_to'] ?: 'Unassigned'; ?></td>
                        <td><?php echo $row['date_added']; ?></td>
                        <td>
                            <a href="edit_equipment.php?id=<?php echo $row['equipment_id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete_equipment.php?id=<?php echo $row['equipment_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
