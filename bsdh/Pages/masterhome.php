<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../database.php'; // Ensure this is the correct path
include '../Pages/sidebar.php';

// Fetch user details from the database
$stmt = $conn->prepare("SELECT id_number, email, role FROM users WHERE user_id = ?");
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch all users for the table
$users_query = "SELECT id_number, email, role FROM users";
$users_result = $conn->query($users_query);

// Fetch all medicines from the pharmacy table
$medicines_query = "SELECT name, category, price, stock, expiration_date FROM medicines";
$medicines_result = $conn->query($medicines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../CSS/masterhome.css"> <!-- Ensure this is the correct path -->
</head>
<body>

<div class="welcome-message">
    Welcome, <?php echo htmlspecialchars($user['id_number']); ?>!
</div>

<div class="dashboard-container">

    <div class="info-container">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
    </div>

    <div class="table-container">
        <!-- User List Table -->
        <div class="data-container">
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($users_result->num_rows > 0) {
                        while ($row = $users_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . ucfirst(htmlspecialchars($row['role'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


      

        <!-- Pharmacy Inventory Table -->
        <div class="data-container2">
            <h2>Pharmacy Inventory</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price (₱)</th>
                        <th>Stock</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($medicines_result && $medicines_result->num_rows > 0) {
                        while ($row = $medicines_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                            echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['expiration_date']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No medicines found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
                

</body>
</html>
