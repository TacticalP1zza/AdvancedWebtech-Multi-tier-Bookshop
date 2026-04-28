/**
 * @file adminOrders.js
 * @description Handles admin order filtering and REST API lookup.
 */

document.addEventListener("DOMContentLoaded", function () {

    /** @type {HTMLSelectElement|null} */
    const mainCategory = document.getElementById("mainCategory");

    /** @type {HTMLSelectElement|null} */
    const subCategory = document.getElementById("subCategory");

    /** @type {NodeListOf<HTMLElement>} */
    const orderCards = document.querySelectorAll(".admin-order-card");

    /** @type {HTMLInputElement|null} */
    const restOrderId = document.getElementById("restOrderId");

    /** @type {HTMLElement|null} */
    const restApiResult = document.getElementById("restApiResult");

    /** @type {HTMLButtonElement|null} */
    const restLookupButton = document.getElementById("restLookupButton");

    /** @type {HTMLButtonElement|null} */
    const resetOrdersButton = document.getElementById("resetOrdersButton");

    /**
     * Category → subcategory mapping.
     * @type {Object<string, string[]>}
     */
    const subcategories = {
        Kids: ["Infants", "Junior", "Young"],
        Adults: ["Classic Novels", "Fiction", "Comic", "Crime and Thriller"]
    };

    /**
     * Handle main category change.
     * Updates subcategories and filters orders.
     */
    if (mainCategory) {
        mainCategory.addEventListener("change", function () {
            const selectedCategory = this.value;

            restOrderId.value = "";
            restApiResult.innerHTML = "";

            subCategory.innerHTML = '<option value="">All Subcategories</option>';

            if (subcategories[selectedCategory]) {
                subcategories[selectedCategory].forEach(function (subcategoryName) {
                    const option = document.createElement("option");
                    option.value = subcategoryName;
                    option.textContent = subcategoryName;
                    subCategory.appendChild(option);
                });
            }

            filterOrders();
        });
    }

    /**
     * Handle subcategory change.
     */
    if (subCategory) {
        subCategory.addEventListener("change", function () {
            restOrderId.value = "";
            restApiResult.innerHTML = "";
            filterOrders();
        });
    }

    /**
     * Handle REST API lookup button click.
     */
    if (restLookupButton) {
        restLookupButton.addEventListener("click", function () {
            const orderId = restOrderId.value;

            if (orderId === "") {
                restApiResult.innerHTML = "<div class='admin-error'>Please enter an order ID.</div>";
                return;
            }

            mainCategory.value = "";
            subCategory.innerHTML = '<option value="">All Subcategories</option>';

            restApiResult.innerHTML = "<div class='admin-success'>Loading order data...</div>";

            const request = new XMLHttpRequest();

            /**
             * Handles API response state changes.
             */
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        handleSuccessfulApiResponse(request.responseText);
                    } else {
                        hideAllOrders();
                        restApiResult.innerHTML = "<div class='admin-error'>API request failed.</div>";
                    }
                }
            };

            request.open(
                "GET",
                "index.php?action=apiOrder&id=" + encodeURIComponent(orderId),
                true
            );

            request.send(null);
        });
    }

    /**
     * Handle reset button click.
     * Restores default state and shows all orders.
     */
    if (resetOrdersButton) {
        resetOrdersButton.addEventListener("click", function () {
            restOrderId.value = "";
            restApiResult.innerHTML = "";

            mainCategory.value = "";
            subCategory.innerHTML = '<option value="">All Subcategories</option>';

            orderCards.forEach(function (card) {
                card.style.display = "block";
            });
        });
    }

    /**
     * Parses and handles successful API response.
     * @param {string} responseText
     * @returns {void}
     */
    function handleSuccessfulApiResponse(responseText) {
        try {
            const response = JSON.parse(responseText);

            if (response.status !== "success") {
                hideAllOrders();
                restApiResult.innerHTML =
                    "<div class='admin-error'>" + escapeHtml(response.message) + "</div>";
                return;
            }

            showOnlyOrder(response.data.id);

            restApiResult.innerHTML =
                "<div class='admin-success'>REST API returned order #" +
                escapeHtml(response.data.id) +
                " successfully.</div>";

        } catch (error) {
            hideAllOrders();
            restApiResult.innerHTML = "<div class='admin-error'>Invalid API response.</div>";
        }
    }

    /**
     * Filters order cards by selected category and subcategory.
     * @returns {void}
     */
    function filterOrders() {
        const selectedCategory = mainCategory.value;
        const selectedSubcategory = subCategory.value;

        orderCards.forEach(function (card) {
            const cardCategory = card.getAttribute("data-category");
            const cardSubcategory = card.getAttribute("data-subcategory");

            const categoryMatches = selectedCategory === "" || cardCategory === selectedCategory;
            const subcategoryMatches = selectedSubcategory === "" || cardSubcategory === selectedSubcategory;

            card.style.display = categoryMatches && subcategoryMatches ? "block" : "none";
        });
    }

    /**
     * Displays only the selected order.
     * @param {string|number} orderId
     * @returns {void}
     */
    function showOnlyOrder(orderId) {
        orderCards.forEach(function (card) {
            const cardOrderId = card.getAttribute("data-order-id");
            card.style.display = String(cardOrderId) === String(orderId) ? "block" : "none";
        });
    }

    /**
     * Hides all order cards.
     * @returns {void}
     */
    function hideAllOrders() {
        orderCards.forEach(function (card) {
            card.style.display = "none";
        });
    }

    /**
     * Escapes HTML to prevent XSS.
     * @param {string} value
     * @returns {string}
     */
    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});