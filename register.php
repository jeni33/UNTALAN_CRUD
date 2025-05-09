<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css"> 
    <title>Register User</title>
</head>
<body>
    <form action="core/handleForms.php" method="POST">
         <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        if ($_SESSION['status'] == "200") {
            echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";
        } else {
            echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";    
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
    }
    ?>
        <h1>Register as a User</h1>
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <input type="submit" name="registerUserBtn" value="Register">
        </p>

        <p>You already have an account? You may login <a href="login.php">here</a>.</p>
</body>
    </form>
    
</html>