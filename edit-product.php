<?php
include 'db_connect.php';

// Get product ID from POST data
$pid = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($pid <= 0) {
    header('Location: index.php');
    exit();
}

// Fetch product details using prepared statement
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE product_id = ?");
mysqli_stmt_bind_param($stmt, "i", $pid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    header('Location: index.php');
    exit();
}

$cat_slug = [
    1 => 'beverages', 2 => 'snacks',  3 => 'household', 4 => 'candy',
    5 => 'care',      6 => 'canned',  7 => 'bakery',     8 => 'frozen', 9 => 'other'
];
$selected_cat = $cat_slug[$product['category_id']] ?? 'other';
?>

<!--
    EDIT PRODUCT PAGE
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Bricolage Grotesque' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">

    <!-- LEFT SIDE -->
    <div class="nav-left">

        <img src="images/logo.png" class="logo">

        <div class="title-group">
            <h1>Stock 'n Track</h1>
            <p>Convenience Store Product Tracker</p>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="nav-right">
        <a href="index.php" class="nav-btn">
            <img src="images/list.png" class="icon1">
            <span> View Product List </span>
        </a>
        
        
        
        <a href="add-product.php" class="nav-btn">
            <img src="images/addprod.png" class="icon2">
            <span> Add Product </span>
        </a>
        
        

    </div>

</nav>

<div class="main">
    
    <div class="caption">
        <h1>Edit Product Information</h1>
        <p>Change the details below to edit product information.</p>
    </div>

    <div class="form-container">
        <div class="form-title">
            <h2>Product Information</h2>
        </div>
        <form action="process-edit.php" method="POST">

            <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

            <label>Product Name</label>
            <input type="text" name="product_name" id="pnamef" value="<?= htmlspecialchars($product['product_name']) ?>" required>

            <div style="display: flex; gap: 15px;">
                <div class="form-grp">
                    <label>Category</label>
                    <select class="dropdown-category" name="categories" id="pcatf" required>
                        <option value="beverages" <?= $selected_cat === 'beverages' ? 'selected' : '' ?>>Beverages</option>
                        <option value="snacks"    <?= $selected_cat === 'snacks'    ? 'selected' : '' ?>>Snacks</option>
                        <option value="household" <?= $selected_cat === 'household' ? 'selected' : '' ?>>Household</option>
                        <option value="candy"     <?= $selected_cat === 'candy'     ? 'selected' : '' ?>>Candy</option>
                        <option value="care"      <?= $selected_cat === 'care'      ? 'selected' : '' ?>>Personal Care</option>
                        <option value="canned"    <?= $selected_cat === 'canned'    ? 'selected' : '' ?>>Canned Goods</option>
                        <option value="bakery"    <?= $selected_cat === 'bakery'    ? 'selected' : '' ?>>Bakery</option>
                        <option value="frozen"    <?= $selected_cat === 'frozen'    ? 'selected' : '' ?>>Frozen</option>
                        <option value="other"     <?= $selected_cat === 'other'     ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="form-grp">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="ppricef" value="<?= $product['price'] ?>" required>
                </div>
            </div>

            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" id="pstockf" value="<?= $product['stock_quantity'] ?>" required>
            
            <div class="save-container">
                <button class="save" type="submit">
                    <img src="images/save.png" class="icon5">
                    Save Product
                </button>
            </div>

        </form>
    </div>

    <footer>
        <p>© 2026 Stock n' Track</p>
    </footer>

</div>

<script src="script.js"></script>

</body>
</html>
