<?php
session_start();
include '../database.php';

if (!isset($_GET['appointment_id'])) {
    die("No appointment selected.");
}

$appointment_id = $_GET['appointment_id'];

$query = "SELECT * FROM medical_records WHERE appointment_id = ? AND appointment_type = 'Prenatal'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prenatal Record</title>
    <link rel="stylesheet" href="../CSS/medical_record.css">
</head>
<body>

<div class="container">
    <h2>Prenatal Record</h2>

    <?php if ($record): ?>
        <p><strong>Diagnosis:</strong> <?php echo nl2br(htmlspecialchars($record['diagnosis'])); ?></p>
        <p><strong>Prescription:</strong> <?php echo nl2br(htmlspecialchars($record['prescription'])); ?></p>
        <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($record['notes'] ?? "No notes available.")); ?></p>
        <p><strong>Created At:</strong> <?php echo $record['created_at']; ?></p>

        <?php if (!empty($record['file_path'])): ?>
            <p><strong>Uploaded Record:</strong> <a href="<?php echo $record['file_path']; ?>" target="_blank">View File</a></p>
        <?php endif; ?>

    <?php else: ?>
        <p style="color: red; font-weight: bold;">No prenatal record found.</p>
        <a href="create_prenatal.php?appointment_id=<?php echo $appointment_id; ?>" class="create-button">Create Record</a>
    <?php endif; ?>

    <a href="prenatmed.php" class="back-button">Back to Dashboard</a>
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
