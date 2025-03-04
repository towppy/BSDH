<?php
include_once '../systembsdh.php'; // Include database connection
include_once '../Users/header.php'; // Include header if needed

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $name = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $expiration = $_POST['expiration_date'];

    if (!empty($name) && $quantity > 0 && !empty($expiration)) {
        $stmt = $conn->prepare("INSERT INTO pharmacy_inventory (item_name, quantity, expiration_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $quantity, $expiration);
        $stmt->execute();
        $stmt->close();
        header("Location: pharmacy_inventory.php"); // Redirect after adding
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Item</title>
    <link rel="stylesheet" type="text/css" href="add_pharmacy.css"> <!-- Include your CSS -->
</head>
<body>
    <div class="container">
        <h2>Add New Pharmacy Item</h2>
        <form method="POST">
            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="expiration_date">Expiration Date:</label>
            <input type="date" id="expiration_date" name="expiration_date" required>

            <div class="button-group">
                <button type="submit" name="add_item" class="submit-btn">Add Item</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='pharmacy_inventory.php'">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
