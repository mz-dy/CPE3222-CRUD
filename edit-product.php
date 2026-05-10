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

            <label>Product Name</label>
            <input type="text" name="product_name" id="pnamef" required>
            
            <div style="display: flex; gap: 15px;">
                <div class="form-grp">
                    <label>Category</label>
                    <select class="dropdown-category" name="categories" id="pcatf" required>
                        <option value="" disabled selected>Please choose an option</option>
                        <option value="beverages">Beverages</option>
                        <option value="snacks">Snacks</option>
                        <option value="household">Household</option>
                        <option value="candy">Candy</option>
                        <option value="care">Personal Care</option>
                        <option value="canned">Canned Goods</option>
                        <option value="bakery">Bakery</option>
                        <option value="frozen">Frozen</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-grp">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="ppricef" required>
                </div>
            </div>

            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" id="pstockf" required>
            
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