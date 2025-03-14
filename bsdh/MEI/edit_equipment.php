<?php
session_start(); // Ensure sessions are enabled
ob_start();

include '../database.php'; // Ensure database connection
include '../Pages/sidebar.php'; 

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Unauthorized access. Please log in.");
}

// Ensure the user has permission to edit the equipment (only admins or staff)
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'staff' && $_SESSION['role'] != 'master') {
    die("Error: Unauthorized access. You do not have permission to edit equipment.");
}

// Ensure `equipment_id` exists in GET request
if (!isset($_GET['id'])) {
    die("Error: Equipment ID not provided.");
}

$equipment_id = $_GET['id'];

// Fetch equipment details
$query = $conn->prepare("SELECT * FROM equipment WHERE equipment_id = ?");
$query->bind_param("i", $equipment_id);
$query->execute();
$result = $query->get_result();
$equipment = $result->fetch_assoc();

if (!$equipment) {
    die("Error: Equipment not found.");
}

// Assign default values if keys are missing
$category = $equipment['type'] ?? '';
$status = $equipment['status'] ?? '';
$assigned_doctor = $equipment['assigned_doctor'] ?? '';

// Fetch categories for dropdown
$categoryQuery = "SELECT category_id, category_name FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// **Handle Form Submission**
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $assigned_doctor = !empty($_POST['assigned_doctor']) ? $_POST['assigned_doctor'] : NULL;

    // Update equipment details
    $updateQuery = $conn->prepare("UPDATE equipment SET name = ?, type = ?, status = ?, assigned_doctor_id = ? WHERE equipment_id = ?");
    $updateQuery->bind_param("sssii", $name, $category, $status, $assigned_doctor, $equipment_id);

    if ($updateQuery->execute()) {
        // Redirect to inventory page after successful update
        header("Location: ../MEI/inventory.php");
        exit();
    } else {
        echo "Error updating equipment: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Equipment</title>
    <link rel="stylesheet" href="../CSS/edit_inventory.css"> 
</head>
<body>
    <div class="container">
        <h2>Edit Equipment</h2>
        <form method="POST">
            <label for="name">Equipment Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($equipment['name']) ?>" required>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?php echo $cat['category_name']; ?>" 
                        <?php if ($category == $cat['category_name']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Available" <?= $equipment['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="In Use" <?= $equipment['status'] == 'In Use' ? 'selected' : '' ?>>In Use</option>
                <option value="Maintenance" <?= $equipment['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>

            <br><br>

            <?php
            $doctorQuery = "SELECT doctor_id, CONCAT(id_number, ' - ', specialization) AS full_name FROM doctors";
            $doctorResult = mysqli_query($conn, $doctorQuery);
            $doctors = mysqli_fetch_all($doctorResult, MYSQLI_ASSOC);
            ?>
            <label for="assigned_doctor">Assigned Room:</label>
            <select name="assigned_doctor" id="assigned_doctor">
                <option value="">Unassigned</option>
                <?php foreach ($doctors as $doctor) { ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>" 
                        <?php if ($equipment['assigned_doctor_id'] == $doctor['doctor_id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($doctor['full_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Update Equipment</button>
            <a href="../MEI/inventory.php">Cancel</a>
        </form>
    </div>
</body>
</html>
