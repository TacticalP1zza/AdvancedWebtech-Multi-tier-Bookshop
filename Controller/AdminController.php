<?php

require_once __DIR__ . '/MainController.php';

/**
 * AdminController.php
 *
 * - Handles administrator-only functionality within the system
 * - Provide REST-style API endpoints for order data
 */

class AdminController extends MainController
{
    private $orderModel;

    public function __construct($orderModel)
    {
        parent::__construct();
        $this->orderModel = $orderModel;
    }

    /**
     * showAdminDashboard
     *
     * - Displays the administrator dashboard page
     * - Only authenticated admin users can access this page
     *
     * @return string View path
     */
    public function showAdminDashboard()
    {
        $this->requireAdmin();

        return 'pages/adminDashboard';
    }

    /**
     * showAdminOrders
     *
     * - Displays all customer orders to the administrator
     * 
     * @return string View path
     */
    public function showAdminOrders()
{
    $this->requireAdmin();

    $orders = $this->orderModel->getAllOrders();

    return [
        'page' => 'pages/adminOrders',
        'data' => [
            'orders' => $orders
        ]
    ];
}

    /**
     * fetchOrderById
     *
     * - Retrieves a specific order by ID
     *
     * - Returns JSON response for AJAX/API usage
     * - Follows REST principles
     *
     * - Only accessible by authenticated admin users
     * 
     * @return void JSON response
     */
    public function fetchOrderById()
    {
        $this->requireAdmin();

        $orderId = $this->getInput($_GET, 'id');

        // Prevent invalid or malicious input (e.g., arrays or strings)
        if ($orderId === '' || !is_numeric($orderId)) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Valid order ID required.'
            ], 400);
        }

        $order = $this->orderModel->getOrderById((int) $orderId);

        if (!$order) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $order
        ]);
    }
}