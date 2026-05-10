<?php

/*include 'db_connect.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);*/

?>

<!--
    MAIN PAGE (VIEW PRODUCTS)
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenience Store Product Tracker</title>
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

            <!-- PLACEHOLDER VALUE ======= CHANGE WHEN BACKEND IMPLEMENTATION -->
            <div class="total">
                <span>Total Products: 9</span>
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

            <!-- PLACEHOLDER TABLE DATA ======= CHANGE WHEN BACKEND IMPLEMENTATION -->

            <tbody id="productTable">
                <tr>
                    <td>1</td>
                    <td>Chips</td>
                    <td><span class="snack">Snack</span></td>
                    <td style="color: #00623E">₱10.00</td>
                    <td>100</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Chips&pcat=snacks&pprice=10.00&pstock=100" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Water</td>
                    <td><span class="beverage">Beverage</span></td>
                    <td style="color: #00623E">₱88.50</td>
                    <td>50</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Water&pcat=beverages&pprice=88.50&pstock=50" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>House Item</td>
                    <td><span class="house">Household</span></td>
                    <td style="color: #00623E">₱333.00</td>
                    <td>30</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=House Item&pcat=household&pprice=333.00&pstock=30" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>Mentos</td>
                    <td><span class="candy">Candy</span></td>
                    <td style="color: #00623E">₱60.50</td>
                    <td>36</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Mentos&pcat=candy&pprice=60.50&pstock=36" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>Tissue</td>
                    <td><span class="care">Personal Care</span></td>
                    <td style="color: #00623E">₱102.00</td>
                    <td>27</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Tissue&pcat=care&pprice=102.00&pstock=27" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>6</td>
                    <td>Tuna</td>
                    <td><span class="can">Canned Goods</span></td>
                    <td style="color: #00623E">₱90.00</td>
                    <td>15</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Tuna&pcat=canned&pprice=90.00&pstock=15" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>7</td>
                    <td>Cookies</td>
                    <td><span class="bakery">Bakery</span></td>
                    <td style="color: #00623E">₱53.00</td>
                    <td>45</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Cookies&pcat=bakery&pprice=53.00&pstock=45" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>8</td>
                    <td>Ice Cream</td>
                    <td><span class="frozen">Frozen</span></td>
                    <td style="color: #00623E">₱21.00</td>
                    <td>13</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Ice Cream&pcat=frozen&pprice=21.00&pstock=13" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>9</td>
                    <td>Magazine</td>
                    <td><span class="other">Other</span></td>
                    <td style="color: #00623E">₱33.00</td>
                    <td>27</td>
                    <td class="edit-del">
                        <a href="edit-product.php?pname=Magazine&pcat=other&pprice=33.00&pstock=27" class="edit-btn">
                            <img src="images/edit.png" class="icon3">
                            <span> Edit </span>
                        </a>
                        <a href="delete-product.php" class="delete-btn">    
                            <img src="images/delete.png" class="icon4">
                            <span> Delete </span>
                        </a>
                    </td>
                </tr>
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
