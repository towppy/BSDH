<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../database.php'; // Ensure this is the correct path
include '../Pages/sidebar.php';

// Fetch pending prenatal appointments
$appointments_query = "SELECT appointment_id, full_name, email, appointment_date, description, status, created_at, id_image 
                       FROM appointments 
                       WHERE status = 'pending' AND LOWER(description) LIKE '%prenatal%' 
                       ORDER BY created_at DESC";

$appointments_result = $conn->query($appointments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenatal Reports</title>
    <link rel="stylesheet" href="../CSS/consultation.css"> <!-- Reusing consultation CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <style>
        .zoom-img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        /* Modal for viewing larger image */
        #imageModal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #modalContent {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }

        #closeModal {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            font-weight: bold;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Prenatal Reports</h2>

    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Created At</th>
                <th>ID Image</th>
                <th>Actions</th>
                <th>Category</th> 
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

                    // Display ID image as clickable thumbnail
                    if (!empty($row['id_image'])) {
                        echo "<td><img src='../uploads/{$row['id_image']}' alt='ID Image' class='zoom-img' onclick='showImage(this.src)'></td>";
                    } else {
                        echo "<td>No Image</td>";
                    }

                    echo "<td>
                        <button class='approve-btn' data-id='{$row['appointment_id']}'>Approve</button>
                        <button class='disqualify-btn' data-id='{$row['appointment_id']}'>Disqualify</button>
                    </td>";

                    echo "<td id='category_{$row['appointment_id']}'>" . htmlspecialchars($row['description']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No pending prenatal appointments</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Image Zoom Modal -->
<div id="imageModal">
    <span id="closeModal">&times;</span>
    <img id="modalContent">
</div>

<!-- Image Zoom Modal -->
<div id="imageModal">
    <span id="closeModal">&times;</span>
    <img id="modalContent">
</div>

<script>
   $(document).ready(function() {
    // When Approve button is clicked
    $('.approve-btn').on('click', function() {
        var appointment_id = $(this).data('id');

        $.ajax({
    url: "../Reports/upapp.php", // Use the same file as Consultation

            type: 'POST',
            data: { appointment_id: appointment_id, status: "approved" },

            success: function(response) {
                if (response === 'success') {
                    $('#status_' + appointment_id).text('Approved');
                    $('#row_' + appointment_id).fadeOut('slow');
                } else {
                    alert('Failed to approve appointment');
                }
            }
        });
    });

    $('.disqualify-btn').on('click', function() {
    var appointment_id = $(this).data('id');

    $.ajax({
        url: "../Reports/upapp.php",
        type: "POST",
        data: { appointment_id: appointment_id, status: "disqualified" },
        success: function(response) {
            if (response === 'success') {
                $('#row_' + appointment_id).fadeOut('slow');
            } else {
                alert('Failed to disqualify appointment');
            }
        }
    });
});

    // Show Image in Modal
    window.showImage = function(src) {
        document.getElementById("imageModal").style.display = "block";
        document.getElementById("modalContent").src = src;
    }

    // Close Modal
    document.getElementById("closeModal").onclick = function() {
        document.getElementById("imageModal").style.display = "none";
    }

    // Close modal when clicking outside the image
    window.onclick = function(event) {
        if (event.target == document.getElementById("imageModal")) {
            document.getElementById("imageModal").style.display = "none";
        }
    }
});

</script>
</body>
</html>
