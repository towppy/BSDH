<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../database.php'; // Ensure this is the correct path
include '../Pages/sidebar.php';

// Fetch pending consultation appointments
$appointments_query = "SELECT appointment_id, full_name, email, appointment_date, description, status, created_at, id_image 
                       FROM appointments 
                       WHERE status = 'pending' AND LOWER(description) LIKE '%consultation%' 
                       ORDER BY created_at DESC";

$appointments_result = $conn->query($appointments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Reports</title>
    <link rel="stylesheet" href="../CSS/consultation.css"> <!-- Ensure correct path -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>

<div class="container">
    <h2>Consultation Reports</h2>

   <!-- Notification Badge -->
<div id="notifBadge" style="display: none; width: 15px; height: 15px; background-color: red; border-radius: 50%; position: absolute; top: 10px; right: 10px;"></div>

<script>
    function checkNewAppointments() {
        $.ajax({
            url: "../Reports/newapp.php",
            type: "GET",
            success: function(response) {
                // Show red circle if there's a new appointment
                if (response.trim() === "new") {
                    $("#notifBadge").show();
                } else {
                    $("#notifBadge").hide();
                }
            }
        });
    }

    // Auto-check for new appointments every 5 seconds
    setInterval(checkNewAppointments, 5000);

    // Run the function on page load
    $(document).ready(function() {
        checkNewAppointments();
    });
</script>


    <table>
    <thead>
    <tr>
        <th>Appointment ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Appointment Date</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Actions</th>
        <th>Category</th>
        <th>ID Image</th>
    </tr>
</thead>

        <tbody id="appointmentData">
            <?php
            if ($appointments_result->num_rows > 0) {
                while ($row = $appointments_result->fetch_assoc()) {
                    echo "<tr id='row_{$row['appointment_id']}'>";
                    echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                    echo "<td id='status_{$row['appointment_id']}'>" . ucfirst(htmlspecialchars($row['status'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td>
                        <button class='approve-btn' data-id='{$row['appointment_id']}'>Approve</button>
                        <button class='disqualify-btn' data-id='{$row['appointment_id']}'>Disqualify</button>
                    </td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td><img src='../uploads/{$row['id_image']}' alt='ID Image' width='50' height='50'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No pending consultations</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

   <script>
    function checkNewAppointments() {
        $.ajax({
            url: "../Reports/newapp.php",
            type: "GET",
            success: function(response) {
                if (response.trim() === "new") {
                    $("#notifBadge").show();
                } else {
                    $("#notifBadge").hide();
                }
            }
        });
    }

  // Approve Appointment
$(document).on("click", ".approve-btn", function () {
    var appointment_id = $(this).data("id");

    $.ajax({
        url: "../Reports/upapp.php",
        type: "POST",
        data: { appointment_id: appointment_id, status: "approved" },
        success: function(response) {
            if (response.trim() === "success") {
                $("#status_" + appointment_id).text("Approved");
                $("#row_" + appointment_id).fadeOut();

                // Redirect to Consultation Medical Records
                window.location.href = "../MedRec/consulmed.php?appointment_id=" + appointment_id;
            }
        }
    });
});

    // Disqualify Appointment
    $(document).on("click", ".disqualify-btn", function () {
        var appointment_id = $(this).data("id");

        $.ajax({
            url: "../Reports/upapp.php",
            type: "POST",
            data: { appointment_id: appointment_id, status: "disqualified" },
            success: function(response) {
                if (response.trim() === "success") {
                    $("#status_" + appointment_id).text("Disqualified");
                    $("#row_" + appointment_id).fadeOut();
                }
            }
        });
    });

    setInterval(checkNewAppointments, 5000);

    $(document).ready(function () {
        checkNewAppointments();
    });
</script>
</body>
</html>
