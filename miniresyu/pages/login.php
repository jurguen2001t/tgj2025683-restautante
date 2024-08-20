<?php include '../includes/header.php'; ?>

<h2>Login</h2>
<form action="../controllers/userController.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit" name="login">Login</button>
</form>

<?php include '../includes/footer.php'; ?>
