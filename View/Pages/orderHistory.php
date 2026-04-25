<?php
$orders = $this->model->getOrdersByAccountId($_SESSION['account_id']);
?>

<link rel="stylesheet" href="View/Pages/orderHistory.css">

<div class="orders-page">
    <h1>Order History</h1>

    <?php if (empty($orders)): ?>
        <p class="no-orders">You have not placed any orders yet.</p>
        <a class="continue-shopping" href="index.php?action=shop">Continue Shopping</a>
    <?php else: ?>
        <div class="orders-grid">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <h2><?php echo htmlentities($order['title'], ENT_QUOTES, 'UTF-8'); ?></h2>

                    <p><strong>Order ID:</strong> <?php echo htmlentities($order['id'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Author:</strong> <?php echo htmlentities($order['author'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Genre:</strong> <?php echo htmlentities($order['genre'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlentities($order['category'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Subcategory:</strong> <?php echo htmlentities($order['subcategory'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Quantity:</strong> <?php echo htmlentities($order['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Price:</strong> £<?php echo htmlentities($order['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Ordered:</strong> <?php echo htmlentities($order['order_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <a class="continue-shopping" href="index.php?action=shop">Continue Shopping</a>
    <?php endif; ?>
</div>