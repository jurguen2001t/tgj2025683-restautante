<?php
include '../includes/db.php';
include '../models/Product.php';

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $result = Product::addProduct($conn, $name, $description, $price);
    if ($result) {
        header("Location: ../admin/manage_products.php");
    } else {
        echo "Failed to add product.";
    }
}
?>
