<?php

require_once __DIR__ . '/MainController.php';

/**
 * AdminController.php
 *
 * Purpose:
 * - Handles administrator-only pages.
 * - Provides REST-style API endpoints for order resources.
 *
 * REST Design:
 * - apiOrder retrieves one order resource by ID.
 * - apiOrders retrieves the order collection.
 * - Responses are JSON and self-descriptive.
 *
 * Security:
 * - All admin pages and API endpoints require administrator authentication.
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
     * Displays the administrator dashboard.
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
     * Displays all customer orders to the administrator.
     *
     * MVC:
     * - Controller retrieves data through the model.
     * - View only renders the provided order data.
     *
     * @return array View response with page and data
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
     * REST-style endpoint:
     * - Retrieves one order resource by ID.
     * - Uses HTTP GET semantics for read-only retrieval.
     * - Returns a self-descriptive JSON representation.
     *
     * Example:
     * index.php?action=apiOrder&id=3
     *
     * @return void JSON response
     */
    public function fetchOrderById()
    {
        $this->requireAdmin();

        $orderId = $this->getInput($_GET, 'id');

        if ($orderId === '' || !is_numeric($orderId)) {
            $this->jsonResponse([
                'status' => 'error',
                'resource' => 'order',
                'message' => 'Valid order ID required.'
            ], 400);
        }

        $order = $this->orderModel->getOrderById((int) $orderId);

        if (!$order) {
            $this->jsonResponse([
                'status' => 'error',
                'resource' => 'order',
                'message' => 'Order not found.'
            ], 404);
        }

        $this->jsonResponse([
            'status' => 'success',
            'resource' => 'order',
            'data' => $order,
            'links' => [
                'self' => 'index.php?action=apiOrder&id=' . (int) $orderId,
                'collection' => 'index.php?action=apiOrders'
            ]
        ]);
    }

    /**
     * fetchAllOrdersApi
     *
     * REST-style endpoint:
     * - Retrieves the order collection.
     * - Returns JSON for administrator/API use.
     *
     * Example:
     * index.php?action=apiOrders
     *
     * @return void JSON response
     */
    public function fetchAllOrdersApi()
    {
        $this->requireAdmin();

        $orders = $this->orderModel->getAllOrders();

        $this->jsonResponse([
            'status' => 'success',
            'resource' => 'orders',
            'count' => count($orders),
            'data' => $orders,
            'links' => [
                'self' => 'index.php?action=apiOrders'
            ]
        ]);
    }
}