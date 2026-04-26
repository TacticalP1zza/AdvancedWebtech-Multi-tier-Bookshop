<?php

/**
 * index.php
 *
 * Front Controller (MVC Entry Point)
 *
 * Responsibilities:
 * - Initialise application through Bootstrap
 * - Map URL actions to controller methods
 * - Render views
 *
 * Design Notes:
 * - Uses explicit routing instead of unsafe dynamic method calls
 * - Controllers handle business logic
 * - View handles rendering only
 */

require_once __DIR__ . '/Bootstrap.php';
require_once __DIR__ . '/View/View.php';

$controllers = Bootstrap::createControllers();

$authenticationController = $controllers['authentication'];
$bookController = $controllers['book'];
$customerOrdersController = $controllers['customerOrders'];
$adminController = $controllers['admin'];

$view = new View();

$action = $_GET['action'] ?? 'shop';

$routes = [

    // Authentication
    'login' => fn() => $authenticationController->showLogin(),
    'handleLogin' => fn() => $authenticationController->handleLogin(),
    'register' => fn() => $authenticationController->showRegister(),
    'handleRegister' => fn() => $authenticationController->handleRegister(),
    'logout' => fn() => $authenticationController->handleLogout(),
    'checkEmailExists' => fn() => $authenticationController->checkEmailExists(),

    // Books / AJAX
    'shop' => fn() => $bookController->showShop(),
    'fetchBooks' => fn() => $bookController->fetchBooks(),

    // Customer Orders
    'orderPage' => fn() => $customerOrdersController->showOrderPage(),
    'handleOrderSubmit' => fn() => $customerOrdersController->handleOrderSubmit(),
    'orderHistory' => fn() => $customerOrdersController->showOrderHistory(),

    // Admin pages
    'adminDashboard' => fn() => $adminController->showAdminDashboard(),
    'adminOrders' => fn() => $adminController->showAdminOrders(),

    // REST-style API endpoints for manager/order resources
    'apiOrder' => fn() => $adminController->fetchOrderById(),
    'apiOrders' => fn() => $adminController->fetchAllOrdersApi(),

    // Backwards compatibility while refactoring
    'fetchOrderById' => fn() => $adminController->fetchOrderById(),
];

if (!isset($routes[$action])) {
    $action = 'shop';
}

$page = $routes[$action]();

echo $view->output($page);
?>