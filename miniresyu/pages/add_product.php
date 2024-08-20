<?php
include '../includes/db.php';
include '../includes/header.php';

// Verificar si el usuario está autenticado y es un administrador
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php"); // Redirigir al inicio de sesión si no es admin
    exit();
}

// Código para mostrar el formulario de añadir platos y manejar la inserción
?>

<h2>Add New Product</h2>
<form action="../controllers/addProductController.php" method="POST">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01" min="0" required>
    
    <button type="submit" name="add_product">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>
