
<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css"> 
    <title>login</title>
</head>
<body>
    <form action="core/handleForms.php" method="POST">
        <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

        if ($_SESSION['status'] == "200") {
            echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
        }

        else {
            echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>"; 
        }

    }
    unset($_SESSION['message']);
    unset($_SESSION['status']);
    ?>

        <h1>Login Now!</h1>
        <p>
            <label for="username">Username</label>
            <input type="text" name="username">
        </p>
        <p>
            <label for="username">Password</label>
            <input type="password" name="password">
            <input type="submit" name="loginUserBtn">
        </p>

        <p>Don't have an account? You may register <a href="register.php">here</a></p>
    </form>
    
</body>
</html>