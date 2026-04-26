<link rel="stylesheet" href="Public/CSS/shop.css">

<main class="shop-page">
    <section aria-label="Book catalogue">
        <div id="book-list" class="book-grid"></div>
        <div id="book-message" aria-live="polite"></div>
    </section>
</main>

<script>
window.isLoggedIn = <?php echo !empty($_SESSION['isLoggedIn']) ? 'true' : 'false'; ?>;
</script>
<script src="Public/JS/shop.js"></script>