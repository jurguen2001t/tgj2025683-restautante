<?php include '../includes/header.php'; ?>

<h2>Register</h2>
<form action="../controllers/userController.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit" name="register">Register</button>
</form>

<?php include '../includes/footer.php'; ?>
