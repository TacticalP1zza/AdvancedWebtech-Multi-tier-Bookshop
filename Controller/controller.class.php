<?php
#does not return .PHP
class Controller
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function home()
    {
        return 'Pages/home';
   

    }

    public function login()
    {
        $captcha = $this->model->getRandomCaptcha();

        if ($captcha) {
            $_SESSION['login_captcha_id'] = $captcha['id'];
            $_SESSION['login_captcha_image'] = $captcha['imageName'];
        }

        return "auth/login";
    }
    
    public function register()
    {
        return "auth/register";
    }

    public function checkEmailExistController()
    {
        header('Content-Type: application/json');
    
        $email = isset($_GET['email']) ? trim($_GET['email']) : '';
    
        if ($email === '') {
            echo json_encode(['exists' => false]);
            exit;
        }
    
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['exists' => false]);
            exit;
        }
    
        $exists = $this->model->checkEmailExistsModel($email);
    
        echo json_encode(['exists' => $exists]);
        exit;
    }

//https://www.w3schools.com/php/func_filter_var.asp
//todo Add stronger sanity checking
    public function registerSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=register");
            exit;
        }

        $userName = trim($_POST['userName'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $confirmEmail = trim($_POST['confirmEmail'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirmPassword'] ?? '');

        $errors = [];

        if ($userName === '' || !preg_match('/^[A-Za-z0-9_ ]{3,30}$/', $userName)) {
            $errors[] = "Invalid username";
        }

        if ($phone === '' || !preg_match('/^[0-9]{10}$/', $phone)) {
            $errors[] = "Invalid phone number";
        }

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $confirmEmail = filter_var($confirmEmail, FILTER_SANITIZE_EMAIL);

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address";
        }

        if ($confirmEmail === '' || !filter_var($confirmEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid confirmation email address";
        }

        if ($email !== $confirmEmail) {
            $errors[] = "Emails do not match";
        }

        if ($this->model->checkEmailExistsModel($email)) {
            $errors[] = "Email address already exists";
        }

        if ($password === '') {
            $errors[] = "Password is required";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match";
        }

        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            header("Location: index.php?action=register");
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $success = $this->model->insertUser($userName, $phone, $email, $hashedPassword);

        if ($success) {
            $_SESSION["register_success"] = "Registration successful. Please log in.";
            header("Location: index.php?action=login");
            exit;
        }

        $_SESSION['register_errors'] = ["Registration failed. Please try again."];
        header("Location: index.php?action=register");
        exit;
    }

        //Change to email inline with coursework? or add both intergration using regex
        public function loginSubmit(){
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                header("Location: index.php?action=login");
                exit;
            }
    
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $captchaAnswer = trim($_POST['captchaAnswer'] ?? '');
            $captchaId = $_SESSION['login_captcha_id'] ?? '';

            $errors = [];
            //https://www.w3schools.com/php/func_filter_var.asp
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = "Invalid email";
            }

            if($password === ''){
                $errors[] = "Passwords is Required";
            }

            if ($captchaAnswer === '') {
                $errors[] = "CAPTCHA is required";
            } elseif (!$this->model->captchaMatches($captchaId, $captchaAnswer)) {
                $errors[] = "CAPTCHA image doesn’t match with the entered information";
            }

            if(!empty($errors)) {
                $_SESSION['login_errors'] = $errors;
                header("location: index.php?action=login");
                exit;
                }

            $user = $this->model->getUserByEmail($email);
            if(!$user){
                $_SESSION['login_errors'] = ["Email not Found"];
                header("Location: index.php?action=login");
                exit;
                }

            if(password_verify($password, $user['password'])){
                session_regenerate_id(true);
                $_SESSION['id'] = session_id();
                $_SESSION['account_id'] = $user['id'];
                $_SESSION['username'] = $user['userName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['admin'] = $user['admin'];
                $_SESSION['loggedIn'] = True;
                unset($_SESSION['login_captcha_id']);
                unset($_SESSION['login_captcha_image']);
                header("Location: index.php?action=home");
                exit;
            }else{
                $_SESSION['login_errors'] = ["Incorrect password"];
                $captcha = $this->model->getRandomCaptcha();
                $_SESSION['login_captcha_id'] = $captcha['id'];
                $_SESSION['login_captcha_image'] = $captcha['imageName'];
                header("Location: index.php?action=login");
                exit;
             }

    
            $_SESSION['login_errors'] = ["Edge Case Detected: Please Report Bug"];
            header("Location: index.php?action=login");
            exit;
            }

        public function logout(){
            $_SESSION = [];
            session_destroy();
            header("Location: index.php?action=login");
            exit;
        }
        public function getBooksAjax()
        {
            header('Content-Type: application/json');
        
            $category = isset($_GET['category']) ? trim($_GET['category']) : '';
            $subcategory = isset($_GET['subcategory']) ? trim($_GET['subcategory']) : '';
        
            $books = $this->model->getBooks($category, $subcategory);
        
            echo json_encode($books);
            exit;
        }

        
        public function orderPage()
        {
            if (empty($_SESSION['loggedIn']) || empty($_SESSION['account_id'])) {
                $_SESSION['login_errors'] = ["Please login before placing an order."];
                header("Location: index.php?action=login");
                exit;
            }
        
            if (!empty($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $_SESSION['order_errors'] = ["Admin accounts cannot place customer orders."];
                header("Location: index.php?action=adminDashboard");
                exit;
            }
        
            $productId = $_GET['product_id'] ?? '';
        
            if ($productId === '' || !is_numeric($productId)) {
                $_SESSION['order_errors'] = ["Invalid product selected."];
                header("Location: index.php?action=home");
                exit;
            }
        
            $product = $this->model->getProductById((int)$productId);
        
            if (!$product) {
                $_SESSION['order_errors'] = ["Product not found."];
                header("Location: index.php?action=home");
                exit;
            }
        
            $_SESSION['order_product'] = $product;
        
            return "Pages/order";
        }

        public function submitOrder()
        {
        if (empty($_SESSION['loggedIn']) || empty($_SESSION['account_id'])) {
            $_SESSION['login_errors'] = ["Please login first"];
            header("Location: index.php?action=login");
            exit;
        }

        if (!empty($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            $_SESSION['order_errors'] = ["Admin accounts cannot place customer orders."];
            header("Location: index.php?action=adminDashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=home");
            exit;
        }

        $accountId = $_SESSION['account_id'];
        $productId = $_POST['product_id'] ?? '';
        $price = $_POST['price'] ?? '';

        if (!is_numeric($productId) || !is_numeric($price)) {
            $_SESSION['order_errors'] = ["Invalid order data"];
            header("Location: index.php?action=home");
            exit;
        }

        $success = $this->model->insertOrder(
            (int)$accountId,
            (int)$productId,
            (float)$price
        );

        if ($success) {
            unset($_SESSION['order_product']);
            $_SESSION['order_success'] = "Order placed successfully!";
            header("Location: index.php?action=orderHistory");
            exit;
        }

        $_SESSION['order_errors'] = ["Order failed. Try again."];
        header("Location: index.php?action=home");
        exit;
    }

    public function orderHistory()
    {
        if (empty($_SESSION['loggedIn']) || empty($_SESSION['account_id'])) {
            $_SESSION['login_errors'] = ["Please login to view your order history."];
            header("Location: index.php?action=login");
            exit;
        }

        return "Pages/orderHistory";
    }

    public function adminDashboard()
    {
        require_once 'secure-admin.php';
        return 'Pages/adminDashboard';
    }

    public function adminOrders()
    {
        require_once 'secure-admin.php';
        return 'Pages/adminOrders';
    }

    public function getOrderApi()
{
    header('Content-Type: application/json');

    if (empty($_SESSION['loggedIn']) || empty($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        echo json_encode([
            "success" => false,
            "message" => "Admin access required"
        ]);
        exit;
    }

    $orderId = isset($_GET['id']) ? $_GET['id'] : '';

    if ($orderId === '' || !is_numeric($orderId)) {
        echo json_encode([
            "success" => false,
            "message" => "Valid order ID required"
        ]);
        exit;
    }

    $order = $this->model->getOrderById((int)$orderId);

    if (!$order) {
        echo json_encode([
            "success" => false,
            "message" => "Order not found"
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "order" => $order
    ]);
    exit;
}

    
}

