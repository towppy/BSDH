<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $expiration_date = $_POST['expiration_date'];

    $insertQuery = "INSERT INTO medicines (name, category, price, stock, expiration_date) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'ssdis', $name, $category, $price, $stock, $expiration_date);

    if (mysqli_stmt_execute($stmt)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
