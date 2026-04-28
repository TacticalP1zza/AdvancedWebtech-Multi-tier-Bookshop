<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ===== Meta & SEO ===== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Idea Bookstore is an online bookstore offering children's and adult books including fiction, classics, comics, and crime thrillers." >
    <meta name="keywords" content="online bookstore, kids books, adult books, fiction, classic novels, comics, crime thriller">
    <meta name="author" content="22018575">
    <meta name="robots" content="index, follow">

    <!-- ===== Open Graph (Social Sharing) ===== -->
    <meta property="og:title" content="Idea Bookstore">
    <meta property="og:description" content="Browse children's books, adult fiction, classics, comics, crime and thriller books online.">
    <meta property="og:image" content="Public/Images/mews.webp">
    <meta property="og:type" content="website">
    <meta property="og:url" content="index.php?action=shop">

    <!-- ===== Title & Styles ===== -->
    <title>Idea Bookstore | Kids, Fiction, Classics & Crime Books Online</title>
    <link rel="stylesheet" href="Public/CSS/header.css">
    <link rel="stylesheet" href="Public/CSS/footer.css">

    <!-- ===== Sitemap ===== -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="sitemap.xml">
</head>

<body>

<!-- ===== Header / Navigation ===== -->
<header class="site-header">
    <nav class="navbar" aria-label="Main navigation">

        <!-- ===== Brand / Logo ===== -->
        <div class="navbar-brand">
            <a href="index.php?action=shop" class="brand-link">
                <span class="brand-logo-wrap">
                    <img 
                        class="brand-logo" 
                        src="Public/Images/mews.webp"
                        width="84"
                        height="84"
                        alt="Idea Bookstore logo"
                        fetchpriority="high"
                    >
                </span>
                <span class="brand-text">Idea Bookstore</span>
            </a>
        </div>

        <!-- ===== Mobile Toggle Button ===== -->
        <button 
            class="navbar-toggle" 
            id="navToggle" 
            type="button"
            aria-label="Toggle navigation" 
            aria-expanded="false"
            aria-controls="navMenu"
        >
            <span class="navbar-bar"></span>
            <span class="navbar-bar"></span>
            <span class="navbar-bar"></span>
        </button>

        <!-- ===== Navigation Menu ===== -->
        <div class="navbar-menu" id="navMenu">
            <ul class="navbar-links">

                <!-- ===== Kids Category Dropdown ===== -->
                <li class="nav-dropdown shop-only">
                    <a 
                        href="index.php?action=shop" 
                        class="nav-link nav-dropdown-trigger book-filter-link" 
                        data-category="Kids" 
                        data-subcategory=""
                    >
                        <span>Kids</span>
                        <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"></path>
                        </svg>
                    </a>

                    <div class="dropdown-panel">
                        <!-- Subcategories -->
                        <a href="shop&category=Kids" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Infants">
                            <span class="dropdown-title">Infants</span>
                            <span class="dropdown-desc">Early picture books and baby stories</span>
                        </a>

                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Junior">
                            <span class="dropdown-title">Junior</span>
                            <span class="dropdown-desc">KS1–KS2 style reads and learning books</span>
                        </a>

                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Kids" data-subcategory="Young">
                            <span class="dropdown-title">Young</span>
                            <span class="dropdown-desc">Young readers and teen-friendly titles</span>
                        </a>
                    </div>
                </li>

                <!-- ===== Adults Category Dropdown ===== -->
                <li class="nav-dropdown shop-only">
                    <a 
                        href="index.php?action=shop" 
                        class="nav-link nav-dropdown-trigger book-filter-link" 
                        data-category="Adults" 
                        data-subcategory=""
                    >
                        <span>Adults</span>
                        <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"></path>
                        </svg>
                    </a>

                    <div class="dropdown-panel">
                        <!-- Subcategories -->
                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Classic Novels">
                            <span class="dropdown-title">Classic Novels</span>
                            <span class="dropdown-desc">Timeless literature and essential reads</span>
                        </a>

                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Fiction">
                            <span class="dropdown-title">Fiction</span>
                            <span class="dropdown-desc">Modern fiction and bestselling stories</span>
                        </a>

                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Comic">
                            <span class="dropdown-title">Comic</span>
                            <span class="dropdown-desc">Graphic novels and illustrated stories</span>
                        </a>

                        <a href="index.php?action=shop" class="dropdown-item book-filter-link" data-category="Adults" data-subcategory="Crime and Thriller">
                            <span class="dropdown-title">Crime &amp; Thriller</span>
                            <span class="dropdown-desc">Mystery, suspense, and detective novels</span>
                        </a>
                    </div>
                </li>

                <!-- ===== Shop Link ===== -->
                <li>
                    <a href="index.php?action=shop" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="..."></path>
                        </svg>
                        <span>Shop</span>
                    </a>
                </li>

                <!-- ===== Account Dropdown ===== -->
                <li class="nav-dropdown">
                    <a href="index.php?action=shop" class="nav-link nav-dropdown-trigger">
                        <svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="..."></path>
                        </svg>

                        <!-- Dynamic Username -->
                        <span>
                            <?php if (!empty($_SESSION['isLoggedIn'])): ?>
                                <?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
                            <?php else: ?>
                                Account
                            <?php endif; ?>
                        </span>

                        <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </a>

                    <!-- Account Options -->
                    <div class="dropdown-panel dropdown-panel--right">
                        <?php if (!empty($_SESSION['isLoggedIn'])): ?>

                            <!-- Admin Options -->
                            <?php if (!empty($_SESSION['isAdmin']) && (int) $_SESSION['isAdmin'] === 1): ?>
                                <a href="index.php?action=adminDashboard" class="dropdown-item">
                                    <span class="dropdown-title">Admin Dashboard</span>
                                </a>

                                <a href="index.php?action=adminOrders" class="dropdown-item">
                                    <span class="dropdown-title">Admin Orders</span>
                                </a>

                            <?php else: ?>

                                <!-- Customer Options -->
                                <a href="index.php?action=orderHistory" class="dropdown-item">
                                    <span class="dropdown-title">Order History</span>
                                </a>

                            <?php endif; ?>

                            <!-- Logout -->
                            <a href="index.php?action=logout" class="dropdown-item">
                                <span class="dropdown-title">Sign Out</span>
                            </a>

                        <?php else: ?>

                            <!-- Guest Options -->
                            <a href="index.php?action=login" class="dropdown-item">
                                <span class="dropdown-title">Login</span>
                            </a>

                            <a href="index.php?action=register" class="dropdown-item">
                                <span class="dropdown-title">Register</span>
                            </a>

                        <?php endif; ?>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>

<script src="Public/JS/header.js"></script>