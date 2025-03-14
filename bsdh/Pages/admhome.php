<?php 
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../Users/login.php");
  exit();
}

include 'sidebar.php';
include '../database.php'; // Your database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | BSDH</title>
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
   
        <!-- Welcome message -->
        <div class="welcome-message">
            Welcome, 
            <?php 
                echo htmlspecialchars($_SESSION['name'] ?? 'Admin');
            ?>
        </div>

        <!-- User Info Section -->
        <div class="info-container">
            <p><strong>Role:</strong> Admin</p>
        </div>

        <!-- Inventory Section -->
        <div class="table-container">

            <!-- Medical Equipment Inventory Table -->
            <div class="data-container">
                <h3>Medical Equipment Inventory</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Equipment Name</th>
                            <th>Assigned Doctor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                      $equipmentQuery = "SELECT e.equip_name, u.name AS doctor_name, e.status 
                      FROM equipment e
                      LEFT JOIN doctors d ON e.assigned_doctor = d.doctor_id
                      LEFT JOIN users u ON d.user_id = u.user_id";
   
    
       
                            $result = $conn->query($equipmentQuery);

                            while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['equip_name']) ?></td>
                            <td><?= htmlspecialchars($row['doctor_name'] ?? 'Unassigned') ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pharmacy Inventory Table -->
            <div class="data-container">
                <h3>Pharmacy Inventory</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Stock</th>
                            <th>Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $pharmacyQuery = "SELECT med_name, stock, expiration_date FROM pharmacy_inventory";
                            $result = $conn->query($pharmacyQuery);

                            while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['med_name']) ?></td>
                            <td><?= htmlspecialchars($row['stock']) ?></td>
                            <td><?= htmlspecialchars($row['expiration_date']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>
