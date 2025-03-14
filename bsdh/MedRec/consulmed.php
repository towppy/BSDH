<?php
session_start();
include '../database.php';
include '../Pages/sidebar.php';

// Fetch approved consultation appointments
$approvedQuery = "SELECT appointment_id, full_name, email, appointment_date, status 
                  FROM appointments 
                  WHERE status = 'approved' AND description = 'Consultation'
                  ORDER BY appointment_date ASC";
$approvedResult = $conn->query($approvedQuery);

// Fetch completed consultation appointments
$completedQuery = "SELECT appointment_id, full_name, email, appointment_date, status 
                   FROM appointments 
                   WHERE status = 'completed' AND description = 'Consultation'
                   ORDER BY appointment_date ASC";
$completedResult = $conn->query($completedQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConsulMed Dashboard</title>
    <link rel="stylesheet" href="../CSS/consulmed.css">
</head>
<body>

<div class="container">
    <h2>ConsulMed Dashboard</h2>
    <input type="text" id="search" placeholder="Search by name..." onkeyup="filterAppointments()">

    <!-- Approved Appointments Table -->
    <h3>Approved Appointments</h3>
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="appointmentData">
            <?php while ($row = $approvedResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                    <td>
                        <a href="../MedRec/view_record.php?appointment_id=<?php echo $row['appointment_id']; ?>">View Record</a>
                        <a href="../MedRec/create_record.php?appointment_id=<?php echo $row['appointment_id']; ?>">Create Record</a>
                        <button class="complete-btn" data-id="<?php echo $row['appointment_id']; ?>">Complete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Completed Appointments Table -->
    <h3>Completed Appointments</h3>
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="completedData">
    <?php while ($row = $completedResult->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
            <td>✔️ Completed</td>
            <td>
                <a href="../MedRec/view_record.php?appointment_id=<?php echo $row['appointment_id']; ?>">View Record</a>
                <a href="../MedRec/update_record.php?appointment_id=<?php echo $row['appointment_id']; ?>" class="update-btn">Update Record</a>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</div>

<script>
// Handle completing an appointment

document.querySelectorAll(".complete-btn").forEach(button => {
    button.addEventListener("click", function() {
        var appointment_id = this.getAttribute("data-id");

        fetch("../Reports/upapp.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "appointment_id=" + appointment_id + "&status=completed"
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                const row = button.closest("tr");
                button.remove();
                row.cells[4].innerText = "✔️ Completed";
                document.querySelector("#completedData").appendChild(row);
            }
        });
    });
});

// Search filter
function filterAppointments() {
    var input = document.getElementById("search").value.toUpperCase();
    var rows = document.querySelectorAll("#appointmentData tr, #completedData tr");

    rows.forEach(row => {
        var nameCell = row.cells[1];
        if (nameCell) {
            var nameText = nameCell.textContent || nameCell.innerText;
            row.style.display = nameText.toUpperCase().includes(input) ? "" : "none";
        }
    });
}
</script>

</body>
</html>
