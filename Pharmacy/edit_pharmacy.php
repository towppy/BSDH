<?php
// Include header
include_once '../Users/header.php';

// Include database connection
include_once '../systembsdh.php';

// Ensure database connection exists
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if an ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$item_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM pharmacy_inventory WHERE item_id = $item_id");

// Check if item exists
if ($result->num_rows === 0) {
    die("Item not found.");
}

$item = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $name = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $expiration = $_POST['expiration_date'];

    if (!empty($name) && $quantity > 0 && !empty($expiration)) {
        $stmt = $conn->prepare("UPDATE pharmacy_inventory SET item_name = ?, quantity = ?, expiration_date = ? WHERE item_id = ?");
        $stmt->bind_param("sisi", $name, $quantity, $expiration, $item_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: pharmacy_inventory.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pharmacy Item</title>
    <link rel="stylesheet" type="text/css" href="edit_pharmacy.css">
</head>
<body>
    <div class="container">
        <h2>Edit Item</h2>
        <form method="POST">
            <input type="text" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
            <input type="date" name="expiration_date" value="<?php echo htmlspecialchars($item['expiration_date']); ?>" required>
            <button type="submit" name="update_item" class="update-btn">Update Item</button>
            <a href="pharmacy_inventory.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
