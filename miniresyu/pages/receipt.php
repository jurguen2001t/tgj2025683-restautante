<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 
include '../models/Order.php'; 

session_start();

$lastOrder = Order::getLastOrder($conn);
?>

<h2>Your Receipt</h2>
<section id="receiptDetails">
    <?php
    if ($lastOrder) {
        echo "<p>Order ID: {$lastOrder['id']}</p>
              <p>Total: \${$lastOrder['total_price']}</p>
              <p>Amount Paid: \${$lastOrder['amount_paid']}</p>
              <p>Change: \${$lastOrder['change_amount']}</p>
              <h3>Order Items:</h3>";

        echo "<ul>";
        foreach ($lastOrder['items'] as $item) {
            echo "<li>{$item['product_name']} - Quantity: {$item['quantity']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No recent orders found.</p>";
    }
    ?>
</section>

<?php include '../includes/footer.php'; ?>
