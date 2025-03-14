<?php

$host = 'localhost'; 
$dbname = 'bsdh'; 
$username = 'root'; 
$password = ''; 


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Prevent redeclaring the function
if (!function_exists('closeDB')) {
    function closeDB() {
        global $conn;
        $conn->close();
    }
}
