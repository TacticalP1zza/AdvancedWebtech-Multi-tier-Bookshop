<link rel="stylesheet" href="Public/CSS/adminOrders.css">

<main class="admin-page">
    <h1>Manager Orders</h1>

    <section class="admin-top-row" aria-label="Admin order tools">
        <div class="rest-api-panel">
            <h2>REST Order Lookup</h2>
            <p class="panel-tip">
                Enter an order ID to retrieve one order resource through the REST-style API.
            </p>

            <div class="rest-api-form">
                <label for="restOrderId">Order ID</label>
                <input type="number" id="restOrderId" placeholder="Enter Order ID">

                <button type="button" id="restLookupButton">Lookup Order</button>
                <button type="button" id="resetOrdersButton">Reset</button>
            </div>

            <div id="restApiResult" class="rest-api-result" aria-live="polite"></div>
        </div>

        <div class="admin-filter-panel">
            <h2>Filter Orders by Book Category</h2>

            <div class="admin-filter-row">
                <div class="admin-filter-group">
                    <label for="mainCategory">Main Category</label>
                    <select id="mainCategory">
                        <option value="">All Categories</option>
                        <option value="Kids">Kids</option>
                        <option value="Adults">Adults</option>
                    </select>
                </div>

                <div class="admin-filter-group">
                    <label for="subCategory">Subcategory</label>
                    <select id="subCategory">
                        <option value="">All Subcategories</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <?php if (empty($orders)): ?>
        <p class="admin-empty">No orders found.</p>
    <?php else: ?>

        <section class="admin-orders-grid" aria-label="Customer orders">
            <?php foreach ($orders as $order): ?>
                <article
                    class="admin-order-card"
                    data-order-id="<?php echo htmlentities($order['id'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-category="<?php echo htmlentities($order['category'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-subcategory="<?php echo htmlentities($order['subcategory'], ENT_QUOTES, 'UTF-8'); ?>"
                >
                    <h3><?php echo htmlentities($order['title'], ENT_QUOTES, 'UTF-8'); ?></h3>

                    <p><strong>Order ID:</strong> <?php echo htmlentities($order['id'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>User:</strong> <?php echo htmlentities($order['userName'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlentities($order['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlentities($order['phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlentities($order['category'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Subcategory:</strong> <?php echo htmlentities($order['subcategory'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Quantity:</strong> <?php echo htmlentities($order['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Price:</strong> £<?php echo htmlentities($order['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlentities($order['order_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                </article>
            <?php endforeach; ?>
        </section>

    <?php endif; ?>

    <a href="index.php?action=adminDashboard" class="order-button">Back</a>
</main>

<script src="Public/JS/adminOrders.js"></script>