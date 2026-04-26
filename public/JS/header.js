/**
 * header.js
 *
 * Purpose:
 * - Handles responsive navigation behaviour.
 * - Controls category dropdown visibility.
 *
 * Design:
 * - Keeps JavaScript separate from header.php.
 * - Uses class-based behaviour instead of inline styling.
 * - Avoids hardcoded dropdown indexes by using semantic CSS classes.
 */

document.addEventListener("DOMContentLoaded", function () {
    const navToggle = document.getElementById("navToggle");
    const navMenu = document.getElementById("navMenu");

    if (navToggle && navMenu) {
        navToggle.addEventListener("click", function () {
            navMenu.classList.toggle("active");

            const expanded = navToggle.getAttribute("aria-expanded") === "true";
            navToggle.setAttribute("aria-expanded", String(!expanded));
        });
    }

    const params = new URLSearchParams(window.location.search);
    const action = params.get("action");

    const isHome = !action;
    const isShop = action === "shop";

    const shopOnlyDropdowns = document.querySelectorAll(".shop-only");

    shopOnlyDropdowns.forEach(function (dropdown) {
        if (!(isHome || isShop)) {
            dropdown.classList.add("hidden");
        }
    });
});