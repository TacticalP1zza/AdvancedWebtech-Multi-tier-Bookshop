<?php

require_once __DIR__ . '/MainController.php';

/**
 * CustomerOrdersController.php
 *
 * Handles:
 * - Order page display
 * - Order submission
 * - Customer order history
 *
 * Design:
 * - Uses orderModel for database operations
 * - Uses bookModel for product lookup
 * - Returns structured responses for View (page + data)
 *
 * Security:
 * - Requires login for all actions
 * - Prevents admin users from placing orders
 * - Validates all inputs before processing
 */

class CustomerOrdersController extends MainController
{
    private $orderModel;
    private $bookModel;

    public function __construct($orderModel, $bookModel)
    {
        parent::__construct();

        $this->orderModel = $orderModel;
        $this->bookModel = $bookModel;
    }

    /**
     * showOrderPage
     *
     * - Displays selected product before confirmation.
     */
    public function showOrderPage()
    {
        $this->requireLogin();
        $this->blockAdminOrdering();

        $productId = $this->getInput($_GET, 'product_id');

        if ($productId === '' || !is_numeric($productId)) {
            $_SESSION['orderErrors'] = ["Invalid product selected."];
            $this->redirectTo('shop');
        }

        $product = $this->bookModel->getBookById((int) $productId);

        if (!$product) {
            $_SESSION['orderErrors'] = ["Product not found."];
            $this->redirectTo('shop');
        }

        $_SESSION['orderProduct'] = $product;

        return 'pages/order';
    }

    /**
     * handleOrderSubmit
     *
     * - Processes order submission.
     */
    public function handleOrderSubmit()
    {
        $this->requireLogin();
        $this->blockAdminOrdering();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('shop');
        }

        $userId = $_SESSION['userId'];
        $productId = $this->getInput($_POST, 'product_id');

        if ($productId === '' || !is_numeric($productId)) {
            $_SESSION['orderErrors'] = ["Invalid product selected."];
            $this->redirectTo('shop');
        }

        $product = $this->bookModel->getBookById((int) $productId);

        if (!$product) {
            $_SESSION['orderErrors'] = ["Product not found."];
            $this->redirectTo('shop');
        }

        if ((int) $product['stock'] <= 0) {
            $_SESSION['orderErrors'] = ["This product is out of stock."];
            $this->redirectTo('shop');
        }

        $success = $this->orderModel->createOrder(
            (int) $userId,
            (int) $productId,
            (float) $product['price']
        );

        if ($success) {
            unset($_SESSION['orderProduct']);

            $_SESSION['orderSuccess'] = "Order placed successfully.";
            $this->redirectTo('orderHistory');
        }

        $_SESSION['orderErrors'] = ["Order failed. Please try again."];
        $this->redirectTo('shop');
    }

    /**
     * showOrderHistory
     *
     * - Displays logged-in user's order history.
     */
    public function showOrderHistory()
    {
        $this->requireLogin();

        $orders = $this->orderModel->getOrdersByUserId(
            (int) $_SESSION['userId']
        );

        return [
            'page' => 'pages/orderHistory',
            'data' => [
                'orders' => $orders
            ]
        ];
    }
}