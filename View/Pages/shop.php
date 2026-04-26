<link rel="stylesheet" href="Public/CSS/shop.css">

<main class="shop-page">
    <section aria-label="Book catalogue">
        <div id="book-list" class="book-grid"></div>
        <div id="book-message" aria-live="polite"></div>
    </section>
</main>

<script>
window.isLoggedIn = <?php echo !empty($_SESSION['isLoggedIn']) ? 'true' : 'false'; ?>;

let currentCategory = "";
let currentSubcategory = "";

document.addEventListener("DOMContentLoaded", function () {
    bindBookFilters();
    loadBooks();
});

function bindBookFilters() {
    const filterLinks = document.querySelectorAll(".book-filter-link");

    filterLinks.forEach(function (filterLink) {
        filterLink.addEventListener("click", function (event) {
            event.preventDefault();

            currentCategory = this.getAttribute("data-category") || "";
            currentSubcategory = this.getAttribute("data-subcategory") || "";

            loadBooks(currentCategory, currentSubcategory);
        });
    });
}

function loadBooks(category, subcategory) {
    if (typeof category === "undefined") {
        category = currentCategory;
    }

    if (typeof subcategory === "undefined") {
        subcategory = currentSubcategory;
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

        bookCard.innerHTML =
            '<div class="book-image">' +
                '<img src="Public/Images/book.jpg" width="150" alt="' + title + '">' +
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

function showBookMessage(message) {
    const messageElement = document.getElementById("book-message");

    if (message === "") {
        messageElement.innerHTML = "";
        return;
    }

    messageElement.innerHTML = "<p>" + escapeHtml(message) + "</p>";
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