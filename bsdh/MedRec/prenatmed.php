<?php
session_start();
include '../database.php';
include '../Pages/sidebar.php';

// Fetch approved prenatal appointments
$queryApproved = "SELECT appointment_id, full_name, email, appointment_date, status 
                  FROM appointments 
                  WHERE status = 'approved' AND description = 'Prenatal' 
                  ORDER BY appointment_date ASC";

$resultApproved = $conn->query($queryApproved);

// Fetch completed prenatal appointments
$queryCompleted = "SELECT appointment_id, full_name, email, appointment_date, status 
                   FROM appointments 
                   WHERE status = 'completed' AND description = 'Prenatal' 
                   ORDER BY appointment_date ASC";

$resultCompleted = $conn->query($queryCompleted);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenatal Dashboard</title>
    <link rel="stylesheet" href="../CSS/consulmed.css">
</head>
<body>

<div class="container">
    <h2>Prenatal Dashboard</h2>
    <input type="text" id="search" placeholder="Search by name..." onkeyup="filterAppointments()">

    <!-- Approved Appointments -->
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
            <?php while ($row = $resultApproved->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                    <td>
                        <a href="../MedRec/view_prenatal.php?appointment_id=<?php echo $row['appointment_id']; ?>&source=prenmed">View Record</a>
                        <a href="../MedRec/create_prenatal.php?appointment_id=<?php echo $row['appointment_id']; ?>">Create Record</a>
                        <button class="complete-btn" data-id="<?php echo $row['appointment_id']; ?>">Complete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Completed Appointments -->
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
        <tbody id="completedAppointments">
    <?php while ($row = $resultCompleted->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
            <td>✔️ Completed</td>
            <td>
                <a href="../MedRec/view_prenatal.php?appointment_id=<?php echo $row['appointment_id']; ?>&source=prenmed">View Record</a>
                <a href="../MedRec/update_prenrec.php?appointment_id=<?php echo $row['appointment_id']; ?>">Update Record</a>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</div>

<script>
function filterAppointments() {
    var input = document.getElementById("search").value.toLowerCase();
    var rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
        var name = row.cells[1].textContent.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
    });
}

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
                row.remove(); // Remove from the approved table

                // Move to completed table
                const completedTable = document.getElementById("completedAppointments");
                row.cells[4].innerHTML = "✔️ Completed"; // Change status
                row.cells[5].innerHTML = `<a href="../MedRec/view_prenatal.php?appointment_id=${appointment_id}&source=prenmed">View Record</a>`; // Remove the complete button
                completedTable.appendChild(row);
            }
        });
    });
});
</script>

</body>
</html>
