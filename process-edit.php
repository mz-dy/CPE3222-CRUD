<?php

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int) $_POST['id'] ?? 0;
    $product_name = trim(htmlspecialchars(strip_tags($_POST['product_name'])));
    $price = (float) $_POST['price'];
    $stock_quantity = (int) $_POST['stock_quantity'];

    $category_map = [
        'beverages' => 1, 'snacks' => 2, 'household' => 3, 'candy' => 4,
        'care' => 5, 'canned' => 6, 'bakery' => 7, 'frozen' => 8, 'other' => 9
    ];
    $category_id = $category_map[$_POST['categories']] ?? null;

    if ($product_id && $product_name && $category_id && $price >= 0 && $stock_quantity >= 0) {
        $stmt = mysqli_prepare($conn,
            "UPDATE products SET product_name = ?, category_id = ?, price = ?, stock_quantity = ? WHERE product_id = ?");

        mysqli_stmt_bind_param($stmt, "sidii", $product_name, $category_id, $price, $stock_quantity, $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php');
        exit();
    } else {
        header('Location: edit-product.php?pid=' . $product_id . '&error=invalid_input');
        exit();
    }
}

?>
