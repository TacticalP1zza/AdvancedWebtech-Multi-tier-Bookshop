<?php

require_once __DIR__ . '/MainController.php';

/**
 * @class AdminController Handles admin order management.
 * @description Controller responsible for administrator-only functionality.
 */
class AdminController extends MainController
{
    private $orderModel;

    /**
     * @param CustomerOrdersModel $orderModel
     */
    public function __construct($orderModel)
    {
        parent::__construct();
        $this->orderModel = $orderModel;
    }

    /**
     * Returns admin dashboard view.
     * @returns string
     */
    public function showAdminDashboard()
    {
        $this->requireAdmin();
        return 'pages/adminDashboard';
    }

    /**
     * outputs all orders for admin view.
     * @returns array
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
     * Outputs single order as JSON.
     * @returns void
     */
    public function fetchOrderById()
    {
        $this->requireAdmin();

        $orderId = $this->getInput($_GET, 'id');

        if ($orderId === '' || !is_numeric($orderId)) {
            $this->jsonResponse([
                'status' => 'error',
                'message' => 'Valid order ID required.'
            ], 400);
        }

        $order = $this->orderModel->getOrderById((int) $orderId);

        if (!$order) {
            $this->jsonResponse([
                'status' => 'error',
                'message' => 'Order not found.'
            ], 404);
        }

        $this->jsonResponse([
            'status' => 'success',
            'data' => $order
        ]);
    }

    /**
     * Outputs all orders as JSON.
     * @returns void
     */
    public function fetchAllOrdersApi()
    {
        $this->requireAdmin();

        $orders = $this->orderModel->getAllOrders();

        $this->jsonResponse([
            'status' => 'success',
            'data' => $orders
        ]);
    }
}