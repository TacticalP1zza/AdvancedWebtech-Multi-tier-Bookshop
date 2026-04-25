

<link rel="stylesheet" href="View/Pages/adminDashboard.css">

<div class="admin-page">
    <h1>Admin Dashboard</h1>

    <?php if (!empty($_SESSION['order_errors'])): ?>
        <div class="admin-error">
            <?php foreach ($_SESSION['order_errors'] as $error): ?>
                <p><?php echo htmlentities($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['order_errors']); ?>
    <?php endif; ?>

    <div class="admin-grid">
        <a href="index.php?action=adminOrders" class="admin-card">
            <h2>View Orders</h2>
            <p>See all customer orders & Search for orders with Restful API.</p>
        </a>

        <a href="index.php?action=home" class="admin-card">
            <h2>View Bookstore</h2>
            <p>Browse the public bookstore page as an administrator.</p>
        </a>
    </div>
</div>