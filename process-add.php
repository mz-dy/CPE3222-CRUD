<!--
    PRODUCT ADD PAGE
-->

<?php

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['product_name'];

    if (!empty($name)) {
        // Sanitise inputs
        // Remove whitespace, HTML tags, and special characters
        $product_name = trim(htmlspecialchars(strip_tags($name)));

        // Numeric fields
        $price = (float) $_POST['price'];
        $stock_quantity = (int) $_POST['stock_quantity'];

        // Validate category
        $category_map = [
            'beverages' => 1, 'snacks' => 2, 'household' => 3, 'candy' => 4,
            'care' => 5, 'canned' => 6, 'bakery' => 7, 'frozen' => 8, 'other' => 9
        ];

        $category_id    = $category_map[$_POST['categories']] ?? null;

        if ($product_name && $category_id && $price >= 0 && $stock_quantity >= 0) {
            $stmt = mysqli_prepare($conn,
            "INSERT INTO products (product_name, category_id, price, stock_quantity)
            VALUES (?, ?, ?, ?)");

            // Bind parameters and execute, binding: s = string, i = integer, d = double
            mysqli_stmt_bind_param($stmt, "sidi", $product_name, $category_id, $price, $stock_quantity);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header('Location: index.php');
            exit();
        } else {
            header('Location: add-product.php?error=invalid_input');
            exit();
        }


    } else {
        echo 'Please fill in all required fields.';
    }
}

?>