<?php

/**
 * index.php
 *
 * Front Controller (MVC Entry Point)
 *
 * Responsibilities:
 * - Initialise application (Bootstrap)
 * - Map URL actions to controller methods (routing)
 * - Render views
 *
 * Design Notes:
 * - Centralised routing (required for coursework)
 * - Explicit mapping (prevents unsafe dynamic method calls)
 * - Controllers handle logic, View handles rendering
 */

require_once __DIR__ . '/Bootstrap.php';
require_once __DIR__ . '/View/View.php';

/**
 * Create controllers via Bootstrap (Dependency Injection)
 */
$controllers = Bootstrap::createControllers();

$authenticationController = $controllers['authentication'];
$bookController = $controllers['book'];
$customerOrdersController = $controllers['customerOrders'];
$adminController = $controllers['admin'];

/**
 * Initialise View
 */
$view = new View();

/**
 * Get requested action (default = shop)
 */
$action = $_GET['action'] ?? 'shop';

/**
 * Routing Table (explicit mapping = secure + scalable)
 */
$routes = [

    // Authentication
    'login' => fn() => $authenticationController->showLogin(),
    'handleLogin' => fn() => $authenticationController->handleLogin(),
    'register' => fn() => $authenticationController->showRegister(),
    'handleRegister' => fn() => $authenticationController->handleRegister(),
    'logout' => fn() => $authenticationController->handleLogout(),
    'checkEmailExists' => fn() => $authenticationController->checkEmailExists(),

    //Books
    'shop' => fn() => $bookController->showShop(),
    'fetchBooks' => fn() => $bookController->fetchBooks(),

    //Customer Orders
    'orderPage' => fn() => $customerOrdersController->showOrderPage(),
    'handleOrderSubmit' => fn() => $customerOrdersController->handleOrderSubmit(),
    'orderHistory' => fn() => $customerOrdersController->showOrderHistory(),

    //Admin
    'adminDashboard' => fn() => $adminController->showAdminDashboard(),
    'adminOrders' => fn() => $adminController->showAdminOrders(),
    'fetchOrderById' => fn() => $adminController->fetchOrderById(),
];

/**
 * Execute route
 */
if (!isset($routes[$action])) {
    $action = 'shop'; // fallback
}

$page = $routes[$action]();

/**
 * Important:
 * Controllers handling POST/JSON usually exit().
 * Only normal page requests reach this line.
 */
echo $view->output($page);
?>