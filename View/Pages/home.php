<div id="book-list" class="book-grid"></div>
<div id="book-message"></div>
<link rel="stylesheet" href="View/Pages/displaybooks.css">
<script>
window.loggedIn = <?php echo !empty($_SESSION['loggedIn']) ? 'true' : 'false'; ?>;
var currentCategory = "";
var currentSubcategory = "";

document.addEventListener("DOMContentLoaded", function () {
    bindBookFilters();
    loadBooks();
});

function bindBookFilters() {
    var filterLinks = document.querySelectorAll(".book-filter-link");

    for (var i = 0; i < filterLinks.length; i++) {
        filterLinks[i].addEventListener("click", function (event) {
            event.preventDefault();

            currentCategory = this.getAttribute("data-category") || "";
            currentSubcategory = this.getAttribute("data-subcategory") || "";

            loadBooks(currentCategory, currentSubcategory);
        });
    }
}

function loadBooks(category, subcategory) {
    var httpxml;

    if (typeof category === "undefined") {
        category = currentCategory;
    }

    if (typeof subcategory === "undefined") {
        subcategory = currentSubcategory;
    }

    try {
        httpxml = new XMLHttpRequest();
    } catch (e) {
        try {
            httpxml = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httpxml = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }

    httpxml.onreadystatechange = function () {
        if (httpxml.readyState == 4) {
            if (httpxml.status == 200) {
                try {
                    var books = JSON.parse(httpxml.responseText);
                    displayBooks(books);
                } catch (error) {
                    document.getElementById("book-message").innerHTML =
                        "<p>Error processing book data.</p>";
                    console.error(error);
                }
            } else {
                document.getElementById("book-message").innerHTML =
                    "<p>Error loading books.</p>";
            }
        }
    };

    var url = "index.php?action=getBooksAjax";

    if (category !== "") {
        url += "&category=" + encodeURIComponent(category);
    }

    if (subcategory !== "") {
        url += "&subcategory=" + encodeURIComponent(subcategory);
    }

    httpxml.open("GET", url, true);
    httpxml.send(null);

    document.getElementById("book-message").innerHTML = "<p>Please wait...</p>";
}

function displayBooks(books) {
    var bookList = document.getElementById("book-list");
    var message = document.getElementById("book-message");

    bookList.innerHTML = "";
    message.innerHTML = "";

    if (!books || books.length === 0) {
        message.innerHTML = "<p>No books available.</p>";
        return;
    }

    for (var i = 0; i < books.length; i++) {
        var book = books[i];
        var bookCard = document.createElement("div");

        bookCard.className = "book-card";

        bookCard.innerHTML =
            '<div class="book-image">' +
                '<img src="View/Pages/book.jpg" width="150" alt="Book">' +
            '</div>' +
            '<h3>' + escapeHtml(book.title) + '</h3>' +
            '<p><strong>Author:</strong> ' + escapeHtml(book.author ? book.author : "") + '</p>' +
            '<p><strong>Genre:</strong> ' + escapeHtml(book.genre ? book.genre : "") + '</p>' +
            '<p><strong>Category:</strong> ' + escapeHtml(book.category ? book.category : "") + '</p>' +
            '<p><strong>Subcategory:</strong> ' + escapeHtml(book.subcategory ? book.subcategory : "") + '</p>' +
            '<p class="price">£' + escapeHtml(book.price ? book.price : "") + '</p>' +

            (
            window.loggedIn
            ? '<a class="order-button" href="index.php?action=orderPage&product_id=' + escapeHtml(book.id) + '">' +
                'Order Now' +
                '</a>'
            : '<a class="order-button" href="index.php?action=login">Login to Order</a>'
            );

        bookList.appendChild(bookCard);
    }
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