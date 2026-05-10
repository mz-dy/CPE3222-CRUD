<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "product_db";

try {
    $conn = mysqli_connect($host, $username, $password, $database);
} catch (Exception $e) {
    die("Connection Failed: " . $e->getMessage());
}