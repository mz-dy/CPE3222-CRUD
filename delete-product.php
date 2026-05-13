<?php

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = (int) $_POST['id'] ?? 0;

    if ($pid > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE product_id = ?");
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $pid);
        if (!mysqli_stmt_execute($stmt)) {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Invalid product ID");
    }
}

header('Location: index.php');
exit();
