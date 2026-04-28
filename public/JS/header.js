/**
 * @file header.js
 * @description Handles responsive navigation and shop-only dropdown visibility.
 */

document.addEventListener("DOMContentLoaded", function () {
    /** @type {HTMLElement|null} */
    const navToggle = document.getElementById("navToggle");

    /** @type {HTMLElement|null} */
    const navMenu = document.getElementById("navMenu");

    /**
     * Toggles mobile navigation menu.
     */
    if (navToggle && navMenu) {
        navToggle.addEventListener("click", function () {
            navMenu.classList.toggle("active");

            const expanded = navToggle.getAttribute("aria-expanded") === "true";
            navToggle.setAttribute("aria-expanded", String(!expanded));
        });
    }

    /** @type {URLSearchParams} */
    const params = new URLSearchParams(window.location.search);

    /** @type {string|null} */
    const action = params.get("action");

    /** @type {boolean} */
    const isHome = !action;

    /** @type {boolean} */
    const isShop = action === "shop";

    /** @type {NodeListOf<HTMLElement>} */
    const shopOnlyDropdowns = document.querySelectorAll(".shop-only");

    /**
     * Hides shop-only dropdowns outside home and shop pages.
     */
    shopOnlyDropdowns.forEach(function (dropdown) {
        if (!(isHome || isShop)) {
            dropdown.classList.add("hidden");
        }
    });
});