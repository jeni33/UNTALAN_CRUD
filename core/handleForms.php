<?php
require_once 'dbConfig.php';

// REGISTER
if (isset($_POST['registerUserBtn'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        $_SESSION['status'] = "200";
        $_SESSION['message'] = "User Registered Successfully!";
        header("Location: ../register.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['status'] = "500";
        $_SESSION['message'] = "Username already exists.";
        header("Location: ../register.php");
        exit;
    }
}

// LOGIN
if (isset($_POST['loginUserBtn'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['status'] = "200";
        $_SESSION['message'] = "Login Successful!";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['status'] = "500";
        $_SESSION['message'] = "Invalid login credentials.";
        header("Location: ../login.php");
        exit;
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

// CREATE CUSTOMER
if (isset($_POST['createCustomer'])) {
    $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone, created_by, updated_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_SESSION['user']['id'],
        $_SESSION['user']['id']
    ]);
    header("Location: ../index.php");
    exit;
}

// UPDATE CUSTOMER
if (isset($_POST['updateCustomer'])) {
    $stmt = $pdo->prepare("UPDATE customers SET name = ?, email = ?, phone = ?, updated_by = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_SESSION['user']['id'],
        $_POST['customer_id']
    ]);
    header("Location: ../index.php");
    exit;
}

// DELETE CUSTOMER
if (isset($_GET['deleteCustomer'])) {
    $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->execute([$_GET['deleteCustomer']]);
    header("Location: ../index.php");
    exit;
}

// ADD ORDER
if (isset($_POST['addOrder'])) {
    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, product_name, amount, created_by) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['customer_id'],
        $_POST['product_name'],
        $_POST['amount'],
        $_SESSION['user']['id']
    ]);
    header("Location: ../index.php");
    exit;
}

// DELETE ORDER
if (isset($_GET['deleteOrder'])) {
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$_GET['deleteOrder']]);
    header("Location: ../index.php");
    exit;
}