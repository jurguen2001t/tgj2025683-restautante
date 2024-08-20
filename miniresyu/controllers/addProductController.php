<?php
include '../includes/db.php';
session_start();

// Verificar si el usuario es un administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

// Recoge los datos del formulario de añadir producto
$name = $_POST['name'];
$price = $_POST['price'];

// Preparar y ejecutar la consulta para añadir el nuevo producto
$stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
$stmt->bind_param("sd", $name, $price);

if ($stmt->execute()) {
    header("Location: ../pages/add_product.php?success=1"); // Redirigir después de añadir
} else {
    echo "Error adding product: " . $stmt->error;
}
?>
