<?php
include '../includes/db.php';

session_start();

// Recoge los datos del formulario de inicio de sesión
$username = $_POST['username'];
$password = $_POST['password'];

// Preparar y ejecutar la consulta para autenticar al usuario
$stmt = $conn->prepare("SELECT id, username, role FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Iniciar sesión y guardar los datos del usuario
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirigir según el rol del usuario
    if ($user['role'] === 'admin') {
        header("Location: ../pages/add_product.php"); // Página para añadir platos
    } else {
        header("Location: ../pages/order.php"); // Página para hacer pedidos
    }
    exit();
} else {
    echo "Invalid username or password.";
}
?>
