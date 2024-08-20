<?php
include '../includes/db.php';
session_start();

// Registro de Usuario
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'customer'; // Default role

    // Preparar y ejecutar la consulta para insertar un nuevo usuario
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: ../pages/login.php?success=1"); // Redirigir al login después del registro
    } else {
        echo "Error registering user: " . $stmt->error;
    }
}

// Inicio de Sesión
if (isset($_POST['login'])) {
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
}

// Cierre de Sesión
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../pages/login.php");
    exit();
}
?>
