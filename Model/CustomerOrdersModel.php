<?php

require_once __DIR__ . '/DB_Connection.php';

/**
 * CustomerOrdersModel.php
 *
 * Handles customer and administrator order operations.
 */

class CustomerOrdersModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB_Connection::getConnection();
    }

    /**
     * Create a new order.
     */
    public function createOrder($userId, $bookId, $price)
    {
        $quantity = 1;

        $sql = "INSERT INTO orders (account_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("createOrder prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("iiid", $userId, $bookId, $quantity, $price);

        $success = $stmt->execute();

        if (!$success) {
            error_log("createOrder execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $success;
    }

    /**
     * Retrieve all orders for one user.
     */
    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT 
                    orders.id,
                    orders.quantity,
                    orders.price,
                    orders.order_date,
                    products.title,
                    products.author,
                    products.genre,
                    products.category,
                    products.subcategory
                FROM orders
                INNER JOIN products ON orders.product_id = products.id
                WHERE orders.account_id = ?
                ORDER BY orders.order_date DESC";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getOrdersByUserId prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();

        return $orders;
    }

    /**
     * Retrieve all orders for administrator view.
     */
    public function getAllOrders()
    {
        $sql = "SELECT 
                    orders.id,
                    orders.quantity,
                    orders.price,
                    orders.order_date,
                    products.title,
                    products.author,
                    products.genre,
                    products.category,
                    products.subcategory,
                    Accounts.user_name,
                    Accounts.email,
                    Accounts.phone
                FROM orders
                INNER JOIN products ON orders.product_id = products.id
                INNER JOIN Accounts ON orders.account_id = Accounts.id
                ORDER BY orders.order_date DESC";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getAllOrders prepare failed: " . $this->connection->error);
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $stmt->close();

        return $orders;
    }

    /**
     * Retrieve one order by ID for REST-style API access.
     */
    public function getOrderById($orderId)
    {
        $sql = "SELECT 
                    orders.id,
                    orders.quantity,
                    orders.price,
                    orders.order_date,
                    Accounts.user_name,
                    Accounts.email,
                    Accounts.phone,
                    products.title,
                    products.author,
                    products.genre,
                    products.category,
                    products.subcategory
                FROM orders
                INNER JOIN Accounts ON orders.account_id = Accounts.id
                INNER JOIN products ON orders.product_id = products.id
                WHERE orders.id = ?
                LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getOrderById prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        $result = $stmt->get_result();
        $order = $result->fetch_assoc();

        $stmt->close();

        return $order ?: false;
    }
}