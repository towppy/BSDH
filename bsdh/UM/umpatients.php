<?php
session_start();
include '../database.php';
include '../Pages/sidebar.php';

// Fetch completed appointments with a medical record
$query = "SELECT a.appointment_id, a.full_name, a.email, a.appointment_date
          FROM appointments a
          INNER JOIN medical_records m ON a.appointment_id = m.appointment_id
          WHERE a.status = 'completed'
          ORDER BY a.appointment_date ASC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients Records</title>
    <link rel="stylesheet" href="../CSS/consulmed.css">
</head>
<body>

<div class="container">
    <h2>Patient Records</h2>
    <input type="text" id="search" placeholder="Search by name..." onkeyup="filterRecords()">
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Appointment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="recordData">
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><a href="../MedRec/view_record.php?appointment_id=<?php echo $row['appointment_id']; ?>">View Record</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function filterRecords() {
    var input = document.getElementById("search").value.toLowerCase();
    var rows = document.querySelectorAll("#recordData tr");
    rows.forEach(row => {
        var name = row.cells[1].textContent.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
    });
}
</script>

</body>
</html>
