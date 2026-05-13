<?php

include 'db_connect.php';

$result = false;
try {
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$cat_info = [
    1 => ['label' => 'Beverage',     'class' => 'beverage', 'slug' => 'beverages'],
    2 => ['label' => 'Snack',        'class' => 'snack',    'slug' => 'snacks'],
    3 => ['label' => 'Household',    'class' => 'house',    'slug' => 'household'],
    4 => ['label' => 'Candy',        'class' => 'candy',    'slug' => 'candy'],
    5 => ['label' => 'Personal Care','class' => 'care',     'slug' => 'care'],
    6 => ['label' => 'Canned Goods', 'class' => 'can',      'slug' => 'canned'],
    7 => ['label' => 'Bakery',       'class' => 'bakery',   'slug' => 'bakery'],
    8 => ['label' => 'Frozen',       'class' => 'frozen',   'slug' => 'frozen'],
    9 => ['label' => 'Other',        'class' => 'other',    'slug' => 'other'],
];

?>

<!--
    MAIN PAGE (VIEW PRODUCTS)
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock 'n Track</title>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Bricolage Grotesque' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar" id="top">
    <div class="nav-left">
        <img src="images/logo.png" class="logo">
        <div class="title-group">
            <h1>Stock 'n Track</h1>
            <p>Convenience Store Product Tracker</p>
        </div>
    </div>
    <div class="nav-right">
        <a href="index.php" class="nav-btn-cur">
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
        <h1>Product Inventory</h1>
    </div>

    <div class="container">
        <div class="top-controls">
            <select id="sortSelect">
                <option value="id-asc">Sort by ID (Ascending)</option>
                <option value="id-desc">Sort by ID (Descending)</option>
                <option value="name-asc">Sort by Name (Ascending)</option>
                <option value="name-desc">Sort by Name (Descending)</option>
                <option value="stock-asc">Sort by Stock (Ascending)</option>
                <option value="stock-desc">Sort by Stock (Descending)</option>
            </select>

            <div class="total">
                <span>Total Products: <?php echo mysqli_num_rows($result); ?></span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Modify</th>
                </tr>
            </thead>

            <tbody id="productTable">
                <?php while ($row = mysqli_fetch_assoc($result)):
                    $cat = $cat_info[$row['category_id']] ?? ['label' => 'Other', 'class' => 'other', 'slug' => 'other'];
                ?>
                <tr>
                    <td><?= $row['product_id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><span class="<?= $cat['class'] ?>"><?= $cat['label'] ?></span></td>
                    <td style="color: #00623E">₱<?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['stock_quantity'] ?></td>
                    <td class="edit-del">
                        <form method="POST" action="edit-product.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['product_id'] ?>">
                            <button type="submit" class="edit-btn">
                                <img src="images/edit.png" class="icon3">
                                <span> Edit </span>
                            </button>
                        </form>
                        <form method="POST" action="delete-product.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="id" value="<?= $row['product_id'] ?>">
                            <button type="submit" class="delete-btn">
                                <img src="images/delete.png" class="icon4">
                                <span> Delete </span>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            
        </table>

    </div>

    <footer>
        <p>© 2026 Stock n' Track</p>
        <a href="#top" class="back-to-top">Back to Top</a>
    </footer>
</div>

<script src="script.js"></script>

</body>
</html>
