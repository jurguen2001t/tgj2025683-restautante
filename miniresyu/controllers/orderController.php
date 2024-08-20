<?php
include '../includes/db.php';
include '../models/Order.php';

session_start();

if (isset($_POST['place_order'])) {
    // Deserializar el carrito de productos
    $cart = unserialize($_POST['cart']);
    $amount_paid = $_POST['amount_paid'];

    // Llamar al modelo para colocar la orden
    $order_id = Order::placeOrder($conn, $cart, $amount_paid);

    // Redirigir a la página de recibo
    header("Location: ../pages/receipt.php");
    exit();
}
