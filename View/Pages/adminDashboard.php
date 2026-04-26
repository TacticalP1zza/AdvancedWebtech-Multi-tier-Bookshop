<link rel="stylesheet" href="Public/CSS/adminDashboard.css">

<main class="admin-page">
    <h1>Admin Dashboard</h1>

    <?php if (!empty($_SESSION['orderErrors'])): ?>
        <section class="admin-error" aria-label="Order error messages">
            <?php foreach ($_SESSION['orderErrors'] as $error): ?>
                <p><?php echo htmlentities($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </section>

        <?php unset($_SESSION['orderErrors']); ?>
    <?php endif; ?>

    <section class="admin-grid" aria-label="Admin actions">
        <a href="index.php?action=adminOrders" class="admin-card">
            <h2>View Orders</h2>
            <p>See all customer orders and search for orders using the RESTful API.</p>
        </a>

        <a href="index.php?action=shop" class="admin-card">
            <h2>View Bookstore</h2>
            <p>Browse the public bookstore page as an administrator.</p>
        </a>
    </section>
</main>