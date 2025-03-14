<?php
session_start();
include '../database.php';

if (!isset($_GET['appointment_id'])) {
    die("No appointment selected.");
}

$appointment_id = $_GET['appointment_id'];

// Fetch appointment details (full name + description)
$query = "SELECT full_name, description FROM appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    die("No appointment found.");
}

// Ensure this is a prenatal record
if ($appointment['description'] !== 'Prenatal') {
    die("This is not a prenatal appointment.");
}

$appointment_type = 'Prenatal';

// Check if a medical record already exists for this appointment
$query = "SELECT * FROM medical_records WHERE appointment_id = ? AND appointment_type = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $appointment_id, $appointment_type);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
$hasRecord = !empty($record);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $notes = $_POST['notes'] ?? '';
    $file_path = $record['file_path'] ?? ''; // Preserve existing file if not updated

    // File upload handling
    if (!empty($_FILES["record_file"]["name"])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["record_file"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["pdf", "doc", "docx", "jpg", "png"];

        if (in_array($file_type, $allowed_types) && move_uploaded_file($_FILES["record_file"]["tmp_name"], $target_file)) {
            $file_path = $target_file;
        } else {
            echo "<script>alert('Invalid file type or upload failed. Allowed: PDF, DOC, DOCX, JPG, PNG');</script>";
        }
    }

    if ($hasRecord) {
        // Update existing record
        $updateQuery = "UPDATE medical_records SET diagnosis = ?, prescription = ?, notes = ?, file_path = ? 
                        WHERE appointment_id = ? AND appointment_type = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssis", $diagnosis, $prescription, $notes, $file_path, $appointment_id, $appointment_type);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO medical_records (appointment_id, appointment_type, diagnosis, prescription, notes, file_path, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isssss", $appointment_id, $appointment_type, $diagnosis, $prescription, $notes, $file_path);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Prenatal record saved successfully!'); window.location.href='prenatmed.php?appointment_id=$appointment_id';</script>";
    } else {
        echo "Error saving record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hasRecord ? "Update" : "Create"; ?> Prenatal Record</title>
    <link rel="stylesheet" href="../CSS/medical_record.css">
</head>
<body>

<div class="container">
    <h2><?php echo $hasRecord ? "Update" : "Create"; ?> Prenatal Record for <?php echo htmlspecialchars($appointment['full_name']); ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Diagnosis:</label>
        <textarea name="diagnosis" required><?php echo htmlspecialchars($record['diagnosis'] ?? ''); ?></textarea>

        <label>Prescription:</label>
        <textarea name="prescription" required><?php echo htmlspecialchars($record['prescription'] ?? ''); ?></textarea>

        <label>Additional Notes:</label>
        <textarea name="notes"><?php echo htmlspecialchars($record['notes'] ?? ''); ?></textarea>

        <label for="record_file"><strong>Upload Prenatal Record (PDF, DOC, DOCX, JPG, PNG):</strong></label>
        <input type="file" name="record_file" id="record_file">
        <?php if (!empty($record['file_path'])): ?>
            <p>Current File: <a href="<?php echo htmlspecialchars($record['file_path']); ?>" target="_blank">View File</a></p>
        <?php endif; ?>

        <button type="submit"><?php echo $hasRecord ? "Update" : "Save"; ?> Record</button>
    </form>

    <a href="prenatmed.php" class="back-button">Back to Prenatal Dashboard</a>
</div>

<style>
    .back-button, button {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 15px;
        background-color:#2c3e50;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        border: none;
        cursor: pointer;
    }

    .back-button:hover, button:hover {
        background-color: #0056b3;
    }
</style>

</body>
</html>
