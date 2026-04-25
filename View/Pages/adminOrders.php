<link rel="stylesheet" href="View/Pages/adminOrders.css">

<div class="admin-page">
    <h1>Manager Orders</h1>

    <div class="admin-top-row">
    <div class="rest-api-panel">
        <h2>REST Order Lookup</h2>
        <p class="panel-tip">Enter an order ID to retrieve one order through the RESTful API.</p>

        <div class="rest-api-form">
            <input type="number" id="restOrderId" placeholder="Enter Order ID">
            <button type="button" id="restLookupButton">Lookup Order</button>
            <button type="button" id="resetOrdersButton">Reset</button>
        </div>

        <div id="restApiResult" class="rest-api-result"></div>
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

</div>
    <?php
    $model = new Model();
    $orders = $model->getAllOrders();
    ?>

    <?php if (empty($orders)): ?>
        <p class="admin-empty">No orders found.</p>
    <?php else: ?>

        <div class="admin-orders-grid">
            <?php foreach ($orders as $order): ?>
                <div class="admin-order-card"
                    data-order-id="<?php echo htmlentities($order['id'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-category="<?php echo htmlentities($order['category'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-subcategory="<?php echo htmlentities($order['subcategory'], ENT_QUOTES, 'UTF-8'); ?>">

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
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <a href="index.php?action=adminDashboard" class="order-button">Back</a>
</div>

<script>
const mainCategory = document.getElementById("mainCategory");
const subCategory = document.getElementById("subCategory");
const orderCards = document.querySelectorAll(".admin-order-card");
const restOrderId = document.getElementById("restOrderId");
const restApiResult = document.getElementById("restApiResult");
const restLookupButton = document.getElementById("restLookupButton");
const resetOrdersButton = document.getElementById("resetOrdersButton");

const subcategories = {
    Kids: ["Infants", "Junior", "Young"],
    Adults: ["Classic Novels", "Fiction", "Comic", "Crime and Thriller"]
};

mainCategory.addEventListener("change", function () {
    const selectedCategory = this.value;

    restOrderId.value = "";
    restApiResult.innerHTML = "";

    subCategory.innerHTML = '<option value="">All Subcategories</option>';

    if (subcategories[selectedCategory]) {
        subcategories[selectedCategory].forEach(function (item) {
            const option = document.createElement("option");
            option.value = item;
            option.textContent = item;
            subCategory.appendChild(option);
        });
    }

    filterOrders();
});

subCategory.addEventListener("change", function () {
    restOrderId.value = "";
    restApiResult.innerHTML = "";
    filterOrders();
});

restLookupButton.addEventListener("click", function () {
    const orderId = restOrderId.value;

    if (orderId === "") {
        restApiResult.innerHTML = "<div class='admin-error'>Please enter an order ID.</div>";
        return;
    }

    mainCategory.value = "";
    subCategory.innerHTML = '<option value="">All Subcategories</option>';

    restApiResult.innerHTML = "<div class='admin-success'>Loading order data...</div>";

    const httpxml = new XMLHttpRequest();

    httpxml.onreadystatechange = function () {
        if (httpxml.readyState === 4) {
            if (httpxml.status === 200) {
                try {
                    const data = JSON.parse(httpxml.responseText);

                    if (!data.success) {
                        hideAllOrders();
                        restApiResult.innerHTML = "<div class='admin-error'>" + escapeHtml(data.message) + "</div>";
                        return;
                    }

                    showOnlyOrder(data.order.id);

                    restApiResult.innerHTML =
                        "<div class='admin-success'>REST API returned order #" + escapeHtml(data.order.id) + " successfully.</div>";
                } catch (e) {
                    hideAllOrders();
                    restApiResult.innerHTML = "<div class='admin-error'>Invalid API response.</div>";
                }
            } else {
                hideAllOrders();
                restApiResult.innerHTML = "<div class='admin-error'>API request failed.</div>";
            }
        }
    };

    httpxml.open("GET", "index.php?action=getOrderApi&id=" + encodeURIComponent(orderId), true);
    httpxml.send(null);
});

resetOrdersButton.addEventListener("click", function () {
    restOrderId.value = "";
    restApiResult.innerHTML = "";

    mainCategory.value = "";
    subCategory.innerHTML = '<option value="">All Subcategories</option>';

    orderCards.forEach(function (card) {
        card.style.display = "block";
    });
});

function filterOrders() {
    const selectedCategory = mainCategory.value;
    const selectedSubcategory = subCategory.value;

    orderCards.forEach(function (card) {
        const cardCategory = card.getAttribute("data-category");
        const cardSubcategory = card.getAttribute("data-subcategory");

        const categoryMatch = selectedCategory === "" || cardCategory === selectedCategory;
        const subcategoryMatch = selectedSubcategory === "" || cardSubcategory === selectedSubcategory;

        card.style.display = categoryMatch && subcategoryMatch ? "block" : "none";
    });
}

function showOnlyOrder(orderId) {
    orderCards.forEach(function (card) {
        const cardOrderId = card.getAttribute("data-order-id");
        card.style.display = String(cardOrderId) === String(orderId) ? "block" : "none";
    });
}

function hideAllOrders() {
    orderCards.forEach(function (card) {
        card.style.display = "none";
    });
}

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>