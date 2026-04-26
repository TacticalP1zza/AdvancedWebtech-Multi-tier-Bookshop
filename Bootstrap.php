<?php

/**
 * Bootstrap.php
 *
 * - Sets up models and controllers
 * - Centralises dependency creation
 * - Improves scalability and maintainability
 */

require_once __DIR__ . '/Model/UserAccountsModel.php';
require_once __DIR__ . '/Model/BookModel.php';
require_once __DIR__ . '/Model/CaptchaModel.php';
require_once __DIR__ . '/Model/CustomerOrdersModel.php';

require_once __DIR__ . '/Controller/AuthenticationController.php';
require_once __DIR__ . '/Controller/BookController.php';
require_once __DIR__ . '/Controller/CustomerOrdersController.php';
require_once __DIR__ . '/Controller/AdminController.php';

class Bootstrap
{
    public static function createControllers()
    {
        $userModel = new UserAccountsModel();
        $bookModel = new BookModel();
        $captchaModel = new CaptchaModel();
        $orderModel = new CustomerOrdersModel();

        return [
            'authentication' => new AuthenticationController($userModel, $captchaModel),
            'book' => new BookController($bookModel),
            'customerOrders' => new CustomerOrdersController($orderModel, $bookModel),
            'admin' => new AdminController($orderModel)
        ];
    }
}