<?php
include_once 'Product.php';

class Order {
    public static function placeOrder($conn, $cart, $amount_paid) {
        if (!is_array($cart) || empty($cart)) {
            die('Cart is empty or invalid.');
        }

        $total_price = 0;

        // Calcular el precio total de todos los productos en el carrito
        foreach ($cart as $item) {
            $product = Product::getProductById($conn, $item['product_id']);
            $total_price += $product['price'] * $item['quantity'];
        }

        $change_amount = $amount_paid - $total_price;

        // Insertar la orden en la tabla `orders`
        $stmt = $conn->prepare("INSERT INTO orders (total_price, amount_paid, change_amount) VALUES (?, ?, ?)");
        $stmt->bind_param("ddd", $total_price, $amount_paid, $change_amount);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Insertar cada producto en la tabla `order_items`
            $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
            foreach ($cart as $item) {
                $stmt_item->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
                $stmt_item->execute();
            }

            // Limpiar el carrito de la sesión
            $_SESSION['cart'] = [];

            return $order_id;
        } else {
            die('Error placing order: ' . $stmt->error);
        }
    }

    public static function getLastOrder($conn) {
        $stmt = $conn->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");

        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        // Obtener los items de la orden
        $stmt_items = $conn->prepare("SELECT order_items.*, products.name AS product_name FROM order_items 
                                      JOIN products ON order_items.product_id = products.id 
                                      WHERE order_id = ?");
        $stmt_items->bind_param("i", $order['id']);
        $stmt_items->execute();
        $order['items'] = $stmt_items->get_result()->fetch_all(MYSQLI_ASSOC);

        return $order;
    }
}
?>
