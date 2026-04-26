<?php
$product = $_SESSION['orderProduct'] ?? null;

if (!$product) {
    header("Location: index.php?action=shop");
    exit;
}
?>

<link rel="stylesheet" href="Public/CSS/order.css">

<main class="orders-page">
    <article class="order-card">
        <h1>Confirm Order</h1>

        <h2><?php echo htmlentities($product['title'], ENT_QUOTES, 'UTF-8'); ?></h2>

        <p><strong>Author:</strong> <?php echo htmlentities($product['author'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Genre:</strong> <?php echo htmlentities($product['genre'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Category:</strong> <?php echo htmlentities($product['category'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Price:</strong> £<?php echo htmlentities($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>

        <hr>

        <p><strong>Customer:</strong> <?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Email:</strong> <?php echo htmlentities($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlentities($_SESSION['phone'], ENT_QUOTES, 'UTF-8'); ?></p>

        <form method="POST" action="index.php?action=handleOrderSubmit">
            <input 
                type="hidden" 
                name="product_id" 
                value="<?php echo htmlentities($product['id'], ENT_QUOTES, 'UTF-8'); ?>"
            >
            <button type="submit" class="order-button">Confirm Order</button>
            <a href="index.php?action=shop" class="continue-shopping">Cancel</a>
        </form>
    </article>
</main>