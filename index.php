<?php
require_once 'core/models.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$customers = getAllCustomers();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
    <title>Customers</title>
</head>
<body>

<h2>
    <span>Welcome, <span class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>!</span>
    <a class="logout" href="core/handleForms.php?logout=1">Logout</a>
</h2>

<!-- CREATE CUSTOMER -->
<h3>Add New Customer</h3>
<form method="POST" action="core/handleForms.php">
    <p><input type="text" name="name" placeholder="Customer Name" required></p>
    <p><input type="text" name="phone" placeholder="Contact Number" required></p>
    <p><input type="text" name="email" placeholder="Email Add" required></p>
    <input type="submit" name="createCustomer" value="Add Customer">
</form>

<hr>

<!-- CUSTOMER LIST -->
<?php foreach ($customers as $customer): ?>
    <div class="customer-box">
        <!-- UPDATE CUSTOMER -->
        <form method="POST" action="core/handleForms.php">
            <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
            <p><input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>"></p>
            <p><input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>"></p>
            <p><input type="text" name="email" value="<?= htmlspecialchars($customer['email']) ?>"></p>
            <p>
                Created by: <?= htmlspecialchars($customer['created_by_user']) ?> |
                Last updated by: <?= htmlspecialchars($customer['updated_by_user']) ?> |
                Updated at: <?= htmlspecialchars($customer['updated_at']) ?>
            </p>
            <div class="button-group">
                <button type="submit" name="updateCustomer" class="btn-update">Update</button>
                <a href="core/handleForms.php?deleteCustomer=<?= $customer['id'] ?>" 
                class="btn-delete" 
                onclick="return confirm('Delete this customer?')">Delete</a>
            </div>
        </form>

        <!-- ORDERS SECTION -->
        <div class="orders">
            <h4>Orders</h4>
            <?php foreach (getOrdersByCustomerId($customer['id']) as $order): ?>
                <p>
                    <?= htmlspecialchars($order['product_name']) ?> — 
                    ₱<?= number_format($order['amount'], 2) ?> — 
                    <small><?= htmlspecialchars($order['created_by_user']) ?> (<?= $order['created_at'] ?>)</small>
                    <!-- Delete button -->
                    <a href="core/handleForms.php?deleteOrder=<?= $order['id'] ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                </p>
            <?php endforeach; ?>

            <!-- ADD ORDER -->
            <form method="POST" action="core/handleForms.php">
                <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
                <p><input type="text" name="product_name" placeholder="Product name..." required></p>
                <p><input type="number" step="0.01" name="amount" placeholder="Amount" required></p>
                <button type="submit" name="addOrder">Add Order</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html> 