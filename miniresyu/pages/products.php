<?php 
include '../includes/db.php'; // Asegúrate de incluir db.php antes de cualquier uso de $conn
include '../includes/header.php'; 
include '../models/Product.php'; 
?>

<h2>Our Menu</h2>
<section id="menu">
    <?php
    $products = Product::getAllProducts($conn); // Asegúrate de que $conn está disponible aquí
    foreach ($products as $product) {
        echo "<div class='product'>
                <h3>{$product['name']}</h3>
                <p>{$product['description']}</p>
                <p>Price: \${$product['price']}</p>
              </div>";
    }
    ?>
</section>

<?php include '../includes/footer.php'; ?>
