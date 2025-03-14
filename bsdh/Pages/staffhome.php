<?php
include 'sidebar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Medical Equipment Inventory</title>
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>

<body>
    <div class="dashboard-container">
   
    <!-- Welcome sa user -->
    <div class="welcome-message">
    Welcome, 
    <?php 
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'doctor') {
            echo "Dr. " . htmlspecialchars($_SESSION['name']);
        } else {
            echo htmlspecialchars($_SESSION['name']);
        }
    ?>
</div>



        <!-- User Info Section -->
        <div class="info-container">
        <p><strong>Role:</strong> 
    <?php 
        if (isset($_SESSION['role'])) {
            echo ucfirst(htmlspecialchars($_SESSION['role']));
        } else {
            echo "Unknown";
        }
    ?>
</p>

          
        </div>


        <!-- Medical Equipment Inventory + Pharmacy Inventory Tables -->
        <div class="table-container">

            <!-- Medical Equipment Table -->
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
                        <tr>
                            <td>Stethoscope</td>
                            <td>Dr. Smith</td>
                            <td>In Use</td>
                        </tr>
                        <tr>
                            <td>Blood Pressure Monitor</td>
                            <td>Dr. Reyes</td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>X-Ray Machine</td>
                            <td>Dr. Gonzales</td>
                            <td>Under Maintenance</td>
                        </tr>
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
                        <tr>
                            <td>Paracetamol</td>
                            <td>100</td>
                            <td>2025-12-10</td>
                        </tr>
                        <tr>
                            <td>Amoxicillin</td>
                            <td>50</td>
                            <td>2025-10-15</td>
                        </tr>
                        <tr>
                            <td>Antibiotics</td>
                            <td>75</td>
                            <td>2026-01-05</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>
