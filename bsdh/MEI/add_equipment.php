<?php
include '../database.php'; // Include database connection
include '../Pages/sidebar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $assigned_doctor = !empty($_POST['assigned_doctor']) ? $_POST['assigned_doctor'] : NULL;

    $query = "INSERT INTO equipment (name, type, status, assigned_doctor_id, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $category, $status, $assigned_doctor, $category_id);
    
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Equipment added successfully!'); window.location.href='inventory.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch doctors for dropdown list
$doctorQuery = "SELECT doctor_id, CONCAT(id_number, ' (', specialization, ')') AS full_name FROM doctors";
$doctorResult = mysqli_query($conn, $doctorQuery);
$doctors = mysqli_fetch_all($doctorResult, MYSQLI_ASSOC);

// Fetch categories from the categories table
$categoryQuery = "SELECT * FROM categories ORDER BY category_name ASC";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <link rel="stylesheet" href="../CSS/inventory.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Equipment</h2>
        <form method="POST">
            <label for="name">Equipment Name:</label>
            <input type="text" name="name" id="name" required>

            <select name="category" id="category" required>
    <option value="">Select Category</option>
    <?php foreach ($categories as $category) { ?>
        <option value="<?php echo $category['category_name']; ?>">
            <?php echo htmlspecialchars($category['category_name']); ?>
        </option>
    <?php } ?>
</select>


            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="Functional">Functional</option>
                <option value="Under Maintenance">Under Maintenance</option>
                <option value="Decommissioned">Decommissioned</option>
            </select>

            <label for="assigned_doctor">Assign to Room :</label>
            <select name="assigned_doctor" id="assigned_doctor">
                <option value="">Unassigned</option>
                <?php foreach ($doctors as $doctor) { ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>">
                        <?php echo htmlspecialchars($doctor['full_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Add Equipment</button>
            <a href="../MEI/inventory.php">Cancel</a>
        </form>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .form-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
        background: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
    }

    label {
        display: block;
        text-align: left;
        margin-top: 10px;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        transition: border 0.3s;
    }

    input:focus, select:focus {
        border-color: #007bff;
        outline: none;
    }

    button {
        margin-top: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }


</style>

