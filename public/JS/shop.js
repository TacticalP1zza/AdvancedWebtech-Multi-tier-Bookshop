/**
 * @file shop.js
 * @description Handles AJAX book loading, filtering, and rendering.
 */

/** @type {string} */
window.currentCategory = "";

/** @type {string} */
window.currentSubcategory = "";

document.addEventListener("DOMContentLoaded", function () {
    bindBookFilters();
    loadBooks();
});

/**
 * Binds category filter links.
 * @returns {void}
 */
function bindBookFilters() {
    const filterLinks = document.querySelectorAll(".book-filter-link");

    filterLinks.forEach(function (filterLink) {
        filterLink.addEventListener("click", function (event) {
            event.preventDefault();

            window.currentCategory = this.getAttribute("data-category") || "";
            window.currentSubcategory = this.getAttribute("data-subcategory") || "";

            loadBooks(window.currentCategory, window.currentSubcategory);
        });
    });
}

/**
 * Loads books with optional filters.
 * @param {string} [category]
 * @param {string} [subcategory]
 * @returns {void}
 */
function loadBooks(category, subcategory) {
    if (typeof category === "undefined") {
        category = window.currentCategory;
    }

    if (typeof subcategory === "undefined") {
        subcategory = window.currentSubcategory;
    }

    const request = new XMLHttpRequest();
    let url = "index.php?action=fetchBooks";

    if (category !== "") {
        url += "&category=" + encodeURIComponent(category);
    }

    if (subcategory !== "") {
        url += "&subcategory=" + encodeURIComponent(subcategory);
    }

    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                try {
                    const response = JSON.parse(request.responseText);

                    if (!response.success) {
                        showBookMessage("Error loading books.");
                        return;
                    }

                    displayBooks(response.data);
                } catch (error) {
                    showBookMessage("Error processing book data.");
                    console.error(error);
                }
            } else {
                showBookMessage("Error loading books.");
            }
        }
    };

    request.open("GET", url, true);
    request.send(null);

    showBookMessage("Please wait...");
}

/**
 * Renders book cards.
 * @param {Array<object>} books
 * @returns {void}
 */
function displayBooks(books) {
    const bookList = document.getElementById("book-list");

    bookList.innerHTML = "";
    showBookMessage("");

    if (!books || books.length === 0) {
        showBookMessage("No books available.");
        return;
    }

    books.forEach(function (book) {
        const bookCard = document.createElement("article");
        bookCard.className = "book-card";

        const bookId = escapeHtml(book.id || "");
        const title = escapeHtml(book.title || "");
        const author = escapeHtml(book.author || "");
        const genre = escapeHtml(book.genre || "");
        const category = escapeHtml(book.category || "");
        const subcategory = escapeHtml(book.subcategory || "");
        const price = escapeHtml(book.price || "");

        const imageSrc = book.image
            ? "Public/Images/" + escapeHtml(book.image)
            : "Public/Images/book.jpg";

        const altText = title && author
            ? "Book cover for " + title + " by " + author
            : "Book cover image";

        bookCard.innerHTML =
            '<div class="book-image">' +
                '<img src="' + imageSrc + '" width="150" height="200" alt="' + altText + '" loading="lazy">' +
            '</div>' +
            '<h3>' + title + '</h3>' +
            '<p><strong>Author:</strong> ' + author + '</p>' +
            '<p><strong>Genre:</strong> ' + genre + '</p>' +
            '<p><strong>Category:</strong> ' + category + '</p>' +
            '<p><strong>Subcategory:</strong> ' + subcategory + '</p>' +
            '<p class="price">£' + price + '</p>' +
            (
                window.isLoggedIn
                    ? '<a class="order-button" href="index.php?action=orderPage&product_id=' + bookId + '">Order Now</a>'
                    : '<a class="order-button" href="index.php?action=login">Login to Order</a>'
            );

        bookList.appendChild(bookCard);
    });
}

/**
 * Displays book status message.
 * @param {string} message
 * @returns {void}
 */
function showBookMessage(message) {
    const messageElement = document.getElementById("book-message");

    if (message === "") {
        messageElement.innerHTML = "";
        return;
    }

    messageElement.innerHTML = "<p>" + escapeHtml(message) + "</p>";
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