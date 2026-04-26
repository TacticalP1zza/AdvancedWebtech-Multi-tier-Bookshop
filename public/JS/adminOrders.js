/**
 * adminOrders.js
 *
 * Purpose:
 * - Handles administrator order filtering.
 * - Retrieves one order through the REST-style API endpoint.
 *
 * REST API:
 * - Uses GET index.php?action=apiOrder&id=ORDER_ID
 * - Receives a self-descriptive JSON response:
 *   {
 *      status: "success",
 *      resource: "order",
 *      data: {...}
 *   }
 *
 * Security:
 * - The server validates admin access before returning order data.
 */

document.addEventListener("DOMContentLoaded", function () {
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

    if (subCategory) {
        subCategory.addEventListener("change", function () {
            restOrderId.value = "";
            restApiResult.innerHTML = "";
            filterOrders();
        });
    }

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
});