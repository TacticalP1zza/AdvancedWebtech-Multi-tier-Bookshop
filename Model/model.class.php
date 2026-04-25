<?php
require_once "db_conn.php";
//bindparam vs bind_param, get_result(); bind_result
class Model
{
    private $conn;

    public function __construct()
    {
       $this->conn = getConnection();
    }

    public function checkEmailExistsModel($email)
    {
        $sql = "SELECT id FROM Accounts WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function insertUser($userName, $phone, $email, $hashedPassword){
        $sql = "INSERT INTO Accounts (userName, phone, email, password) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $userName, $phone, $email, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getUserByEmail($email){
        $sql = "SELECT id, userName, phone, email, password, admin FROM Accounts WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $dbUserName, $phone, $dbEmail, $password, $admin);

        if($stmt->fetch()){
            $user = [
                "id" => $id,
                "userName" => $dbUserName,
                "phone" => $phone,
                "email" => $dbEmail,
                "password" => $password,
                "admin" => $admin
            ];

            $stmt->close();
            return $user;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getBooks($category = '', $subcategory = '')
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";

        if ($category !== '') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }

        if ($subcategory !== '') {
            $sql .= " AND subcategory = ?";
            $params[] = $subcategory;
            $types .= "s";
        }

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $books = [];

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        $stmt->close();
        return $books;
    }
    public function getRandomCaptcha()
    {
        $sql = "SELECT id, imageName FROM CaptchaImages ORDER BY RAND() LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $captcha = $result->fetch_assoc();
        $stmt->close();

        return $captcha;
    }

    public function captchaMatches($captchaId, $captchaAnswer)
    {
        $sql = "SELECT id FROM CaptchaImages WHERE id = ? AND captchaText = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $captchaId, $captchaAnswer);
        $stmt->execute();
        $result = $stmt->get_result();
        $matches = $result->num_rows > 0;
        $stmt->close();

        return $matches;
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $stmt->close();

        return $product;
    }

    public function insertOrder($accountId, $productId, $price)
    {
        $quantity = 1;
    
        $sql = "INSERT INTO orders (account_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param("iiid", $accountId, $productId, $quantity, $price);
    
        $success = $stmt->execute();
        $stmt->close();
    
        return $success;
    }

    public function getOrdersByAccountId($accountId)
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

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $accountId);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
    return $orders;
}

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
                Accounts.userName,
                Accounts.email,
                Accounts.phone
            FROM orders
            INNER JOIN products ON orders.product_id = products.id
            INNER JOIN Accounts ON orders.account_id = Accounts.id
            ORDER BY orders.order_date DESC";

    $result = $this->conn->query($sql);

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

public function getOrderById($orderId)
{
    $sql = "SELECT 
                orders.id,
                orders.quantity,
                orders.price,
                orders.order_date,
                Accounts.userName,
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

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $stmt->close();

    return $order;
}

}


