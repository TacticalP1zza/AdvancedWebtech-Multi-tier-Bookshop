<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Idea Bookstore is an online bookstore offering children's and adult books including fiction, classics, comics, and crime thrillers.">
    <meta name="keywords" content="online bookstore, kids books, adult books, fiction, classic novels, comics, crime thriller">
    <meta name="author" content="22018575">
    <title>Idea Bookstore</title>
    <link rel="stylesheet" href="View/layouts/header.css">
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>
<!-- Below for lab computer above for personal -->
<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
</head>
<header class="site-header">
    <nav class="navbar">
        <div class="navbar__brand">
            <a href="index.php?action=home" class="brand-link">
                <span class="brand-logo-wrap">
                    <img class="brand-logo" src="View/layouts/Images/mews.png" alt="Idea Bookstore logo">
                </span>
                <span class="brand-text">Idea Bookstore</span>
            </a>
        </div>

        <button class="navbar__toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span class="navbar__bar"></span>
            <span class="navbar__bar"></span>
            <span class="navbar__bar"></span>
        </button>

        <div class="navbar__menu" id="navMenu">
            <ul class="navbar__links">
            <li class="nav-dropdown">
            <a href="#" class="nav-link nav-dropdown__trigger">
                <span>Kids</span>
                <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>

            <div class="dropdown-panel">
                <a href="#" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Infants">
                    <span class="dropdown-title">Infants</span>
                    <span class="dropdown-desc">Early picture books and baby stories</span>
                </a>

                <a href="#" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Junior">
                    <span class="dropdown-title">Junior</span>
                    <span class="dropdown-desc">KS1–KS2 style reads and learning books</span>
                </a>

                <a href="#" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Young">
                    <span class="dropdown-title">Young</span>
                    <span class="dropdown-desc">Young readers and teen-friendly titles</span>
                </a>
            </div>
        </li>

        <li class="nav-dropdown">
            <a href="#" class="nav-link nav-dropdown__trigger">
                <span>Adults</span>
                <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>

            <div class="dropdown-panel">
                <a href="#" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Classic Novels">
                    <span class="dropdown-title">Classic Novels</span>
                    <span class="dropdown-desc">Timeless literature and essential reads</span>
                </a>

                <a href="#" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Fiction">
                    <span class="dropdown-title">Fiction</span>
                    <span class="dropdown-desc">Modern fiction and bestselling stories</span>
                </a>

                <a href="#" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Comic">
                    <span class="dropdown-title">Comic</span>
                    <span class="dropdown-desc">Graphic novels and illustrated stories</span>
                </a>

                <a href="#" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Crime and Thriller">
                    <span class="dropdown-title">Crime & Thriller</span>
                    <span class="dropdown-desc">Mystery, suspense, and detective novels</span>
                </a>
            </div>
        </li>

                <li>
                    <a href="index.php?action=shopping" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2 1C1.44772 1 1 1.44772 1 2C1 2.55228 1.44772 3 2 3H3.21922L6.78345 17.2569C5.73276 17.7236 5 18.7762 5 20C5 21.6569 6.34315 23 8 23C9.65685 23 11 21.6569 11 20C11 19.6494 10.9398 19.3128 10.8293 19H15.1707C15.0602 19.3128 15 19.6494 15 20C15 21.6569 16.3431 23 18 23C19.6569 23 21 21.6569 21 20C21 18.3431 19.6569 17 18 17H8.78078L8.28078 15H18C20.0642 15 21.3019 13.6959 21.9887 12.2559C22.6599 10.8487 22.8935 9.16692 22.975 7.94368C23.0884 6.24014 21.6803 5 20.1211 5H5.78078L5.15951 2.51493C4.93692 1.62459 4.13696 1 3.21922 1H2ZM18 13H7.78078L6.28078 7H20.1211C20.6742 7 21.0063 7.40675 20.9794 7.81078C20.9034 8.9522 20.6906 10.3318 20.1836 11.3949C19.6922 12.4251 19.0201 13 18 13ZM18 20.9938C17.4511 20.9938 17.0062 20.5489 17.0062 20C17.0062 19.4511 17.4511 19.0062 18 19.0062C18.5489 19.0062 18.9938 19.4511 18.9938 20C18.9938 20.5489 18.5489 20.9938 18 20.9938ZM7.00617 20C7.00617 20.5489 7.45112 20.9938 8 20.9938C8.54888 20.9938 8.99383 20.5489 8.99383 20C8.99383 19.4511 8.54888 19.0062 8 19.0062C7.45112 19.0062 7.00617 19.4511 7.00617 20Z"
                                fill="currentColor"/>
                        </svg>
                        <span>Shop</span>
                    </a>
                </li>

                <li class="nav-dropdown">
    <a href="#" class="nav-link nav-dropdown__trigger">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="currentColor"/>
            <path d="M12 14C7.58172 14 4 17.134 4 21H20C20 17.134 16.4183 14 12 14Z" fill="currentColor"/>
        </svg>
        <span>
            <?php if (!empty($_SESSION['loggedIn'])): ?>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            <?php else: ?>
                Account
            <?php endif; ?>
        </span>
        <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>

    <div class="dropdown-panel dropdown-panel--right">
    <?php if (!empty($_SESSION['loggedIn'])): ?>

<?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>

    <a href="index.php?action=adminDashboard" class="dropdown-item">
        <span class="dropdown-title">Admin Dashboard</span>
        <span class="dropdown-desc">Manage orders and system</span>
    </a>

<?php else: ?>

    <a href="index.php?action=orderHistory" class="dropdown-item">
        <span class="dropdown-title">Order History</span>
        <span class="dropdown-desc">Review your previous orders</span>
    </a>

<?php endif; ?>

<a href="index.php?action=logout" class="dropdown-item">
    <span class="dropdown-title">Sign Out</span>
    <span class="dropdown-desc">Log out of your account</span>
</a>

<?php else: ?>
            <a href="index.php?action=login" class="dropdown-item">
                <span class="dropdown-title">Login</span>
                <span class="dropdown-desc">Sign in to your bookstore account</span>
            </a>

            <a href="index.php?action=register" class="dropdown-item">
                <span class="dropdown-title">Register</span>
                <span class="dropdown-desc">Create a new customer account</span>
            </a>
        <?php endif; ?>
    </div>
</li>
            </ul>
        </div>
    </nav>
</header>

<script>
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    navToggle.addEventListener('click', function () {
        navMenu.classList.toggle('active');

        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', String(!expanded));
    });
</script>

