<?php
session_start();
include '../database.php';

if (!isset($_GET['appointment_id'])) {
    die("No appointment selected.");
}

$appointment_id = $_GET['appointment_id'];

// Fetch medical record
$query = "SELECT * FROM medical_records WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

// File upload handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["record_file"])) {
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["record_file"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ["pdf", "doc", "docx", "jpg", "png"];

    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Invalid file type. Allowed: PDF, DOC, DOCX, JPG, PNG');</script>";
    } elseif (move_uploaded_file($_FILES["record_file"]["tmp_name"], $target_file)) {
        // Save file path in database
        $updateQuery = "UPDATE medical_records SET file_path = ? WHERE appointment_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $target_file, $appointment_id);
        if ($stmt->execute()) {
            echo "<script>alert('File uploaded successfully!'); window.location.href='view_record.php?appointment_id=$appointment_id';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medical Record</title>
    <link rel="stylesheet" href="../CSS/medical_record.css">
</head>
<body>

<div class="container">
    <h2>Medical Record</h2>

    <?php if ($record): ?>
        <p><strong>Diagnosis:</strong> <?php echo nl2br(htmlspecialchars($record['diagnosis'])); ?></p>
        <p><strong>Prescription:</strong> <?php echo nl2br(htmlspecialchars($record['prescription'])); ?></p>
        <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($record['notes'] ?? "No notes available.")); ?></p>
        <p><strong>Created At:</strong> <?php echo $record['created_at']; ?></p>

        <!-- Uploaded File -->
        <?php if (!empty($record['file_path'])): ?>
            <p><strong>Uploaded Record:</strong> 
                <a href="<?php echo $record['file_path']; ?>" target="_blank">View File</a>
            </p>
        <?php endif; ?>

    <?php else: ?>
        <p style="color: red; font-weight: bold;">No medical record found.</p>
        <a href="create_record.php?appointment_id=<?php echo $appointment_id; ?>" class="create-button">Create Record</a>
    <?php endif; ?>

    <!-- Back Button -->
    <a href="consulmed.php" class="back-button">Back to ConsulMed Dashboard</a>
</div>

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        text-align: center;
    }

    .back-button, .create-button {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 15px;
        background-color: #2c3e50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        cursor: pointer;
    }

    .back-button:hover, .create-button:hover {
        background-color: #0056b3;
    }
</style>

</body>
</html>
