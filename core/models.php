<?php
require_once 'dbConfig.php';

// USER FUNCTIONS
function registerUser($username, $password) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $hashedPassword]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

// CUSTOMER FUNCTIONS
function getAllCustomers() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT c.*, u1.username AS created_by_user, u2.username AS updated_by_user
        FROM customers c
        LEFT JOIN users u1 ON c.created_by = u1.id
        LEFT JOIN users u2 ON c.updated_by = u2.id
        ORDER BY c.created_at DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCustomerById($customer_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->execute([$customer_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ORDER FUNCTIONS
function getOrdersByCustomerId($customer_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT o.*, u.username AS created_by_user 
        FROM orders o
        LEFT JOIN users u ON o.created_by = u.id
        WHERE o.customer_id = ?
        ORDER BY o.created_at ASC
    ");
    $stmt->execute([$customer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
