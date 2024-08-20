<?php
include '../includes/db.php';
include '../includes/header.php';
include '../models/Product.php';
include '../models/Order.php';

session_start();

// Verificar si el carrito ya existe en la sesión
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Si se envía un nuevo plato al carrito
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    // Agregar el producto y la cantidad al carrito de la sesión
    $_SESSION['cart'][] = ['product_id' => $product_id, 'quantity' => $quantity];
}

// Obtener todos los productos para mostrarlos en la página
$products = Product::getAllProducts($conn);
?>

<h2>Order Products</h2>

<!-- Formulario para seleccionar y agregar productos al carrito -->
<form action="order.php" method="POST">
    <label for="product_id">Select Product:</label>
    <select id="product_id" name="product_id">
        <?php foreach ($products as $product) : ?>
            <option value="<?= $product['id'] ?>"><?= $product['name'] ?> - $<?= $product['price'] ?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="1" min="1">
    
    <!-- Botón para agregar el producto al carrito -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>

<!-- Mostrar el contenido del carrito -->
<h3>Your Cart</h3>
<ul>
    <?php foreach ($_SESSION['cart'] as $item) : 
        $product = Product::getProductById($conn, $item['product_id']);
    ?>
        <li><?= $product['name'] ?> - Quantity: <?= $item['quantity'] ?></li>
    <?php endforeach; ?>
</ul>

<!-- Formulario para proceder al pago -->
<form action="../controllers/orderController.php" method="POST">
    <label for="amount_paid">Amount Paid:</label>
    <input type="number" id="amount_paid" name="amount_paid" step="0.01" required>
    
    <!-- Campo oculto para pasar el carrito -->
    <input type="hidden" name="cart" value="<?= htmlspecialchars(serialize($_SESSION['cart'])) ?>">
    
    <!-- Botón para proceder al pago -->
    <button type="submit" name="place_order">Place Order</button>
</form>

<?php include '../includes/footer.php'; ?>
