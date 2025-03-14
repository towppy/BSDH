<?php
session_start();
ob_start();

include '../database.php'; // Ensure database connection
include '../Pages/sidebar.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Unauthorized access. Please log in.");
}

// Check if medicine ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Medicine ID is missing.");
}

$medicine_id = intval($_GET['id']);

// Fetch the medicine details
$query = "SELECT * FROM medicines WHERE medicine_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $medicine_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medicine = mysqli_fetch_assoc($result);

if (!$medicine) {
    die("Error: Medicine not found.");
}

// Fetch categories for dropdown
$categoryQuery = "SELECT DISTINCT category FROM medicines";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $expiration_date = $_POST['expiration_date'];

    // Update the medicine
    $updateQuery = "UPDATE medicines SET name = ?, category = ?, price = ?, stock = ?, expiration_date = ? WHERE medicine_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssdisi", $name, $category, $price, $stock, $expiration_date, $medicine_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: p_inventory.php?success=Medicine updated successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine</title>
    <link rel="stylesheet" href="../CSS/editp_inventory.css">
</head>
<body>
    <div class="container">
        <h2>Edit Medicine</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($medicine['name']) ?>" required>

            <label for="category">Category:</label>
            <select name="category" required>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?= htmlspecialchars($cat['category']) ?>" <?= ($medicine['category'] == $cat['category']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category']) ?>
                    </option>
                <?php } ?>
            </select>

            <label for="price">Price (₱):</label>
            <input type="number" name="price" value="<?= number_format($medicine['price'], 2) ?>" step="0.01" required>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" value="<?= $medicine['stock'] ?>" min="0" required>

            <label for="expiration_date">Expiration Date:</label>
            <input type="date" name="expiration_date" value="<?= $medicine['expiration_date'] ?>" required>

            <button type="submit">Update Medicine</button>
            <a href="p_inventory.php" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>
