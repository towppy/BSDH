<?php
// Include header
include_once '../Users/header.php';

// Include database connection
include_once '../systembsdh.php';

// Ensure database connection exists
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Function to fetch inventory items
function getInventory($conn) {
    $result = $conn->query("SELECT * FROM pharmacy_inventory");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to delete an item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM pharmacy_inventory WHERE item_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: pharmacy_inventory.php");
    exit();
}

// Function to update an item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_item'])) {
    $id = intval($_POST['item_id']);
    $name = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $expiration = $_POST['expiration_date'];

    if ($id > 0 && !empty($name) && $quantity > 0 && !empty($expiration)) {
        $stmt = $conn->prepare("UPDATE pharmacy_inventory SET item_name = ?, quantity = ?, expiration_date = ? WHERE item_id = ?");
        $stmt->bind_param("sisi", $name, $quantity, $expiration, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: pharmacy_inventory.php");
    exit();
}

// Check if user is editing an item
$editItem = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM pharmacy_inventory WHERE item_id = $id");
    if ($result->num_rows > 0) {
        $editItem = $result->fetch_assoc();
    }
}

$inventory = getInventory($conn);
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Inventory</title>
    <link rel="stylesheet" type="text/css" href="pharmacy_inventory.css">
</head>
<body>
    <div class="container">
        <h2>Pharmacy Inventory</h2>

        <a href="add_pharmacy.php" class="add-btn">Add New Item</a>

        <h3>Inventory List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['expiration_date']); ?></td>
                        <td>
                            <a href="edit_pharmacy.php?id=<?php echo $item['item_id']; ?>" class="edit-btn">Edit</a>
                            <a href="?delete=<?php echo $item['item_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                </tr>

            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
