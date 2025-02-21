<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once '../systembsdh.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM equipment_inventory WHERE equipment_id = $id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Equipment Deleted Successfully!'); window.location.href='view_equipment.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
