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
        return "Pages/home";
    }

    public function login()
    {
        return "auth/login";
    }
    
    public function register()
    {
        return "auth/register";
    }

   public function checkUserName()
    {
        header('Content-Type: application/json');

        $userName = isset($_GET['userName']) ? trim($_GET['userName']) : '';

    
        if($userName === ''){
            echo json_encode(['exists' => False]);
            exit;
        }

        $exists = $this->model->userNameExists($userName);

        echo json_encode(['exists' => $exists]);
        exit;
    }


    //todo Add stronger sanity checking
    public function registerSubmit(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
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

            if($userName === '' || !preg_match('/^[A-Za-z\s]+$/', $userName)){
                $errors[] = "Invalid Username";
            }

            if($phone === '' || !preg_match('/^[0-9]{11}$/', $phone)){
                $errors[] = "Invalid Phone";
            }

            if($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = "Invalid email address";
            }

            if($email !== $confirmEmail){
                $errors[] = "Emails do not match";
            }

            if($password === ''){
                $errors[] = "Passwords is Required";
            }

            if($password !== $confirmPassword){
                $errors[] = "Passwords do not match";
            }

            if($this->model->userNameExists($userName)){
                $errors[] = "Username Already Exists";
            }

            if(!empty($errors)) {
                $_SESSION['register_errors'] = $errors;
                header("location: index.php?action=register");
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $success = $this->model->insertUser($userName, $phone, $email, $hashedPassword);
 
            
           

            $_SESSION['userName'] = $userName;
            $_SESSION['email'] = $email;
            $_SESSION['loggedIn'] = True;

            header("Location: index.php?action=home");
            exit;
        }

        //Change to email inline with coursework? or add both intergration using regex
        public function loginSubmit(){
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                header("Location: index.php?action=login");
                exit;
            }
    
            $email = trim($_POST['userName'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $errors = [];
    
            if($userName === '' || !preg_match('/^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/', $email)){
                $errors[] = "Invalid email";
            }
            if($password === ''){
                $errors[] = "Passwords is Required";
            }
            if(!empty($errors)) {
                $_SESSION['login_errors'] = $errors;
                header("location: index.php?action=login");
                exit;
                }

            $user = $this->model->getUserByEmail($emai);
            if(!$user){
                $_SESSION['login_errors'] = ["Email not Found"];
                header("Location: index.php?action=login");
                exit;
                }

            if(password_verify($password, $user['password'])){
                session_regenerate_id(true);
                $_SESSION['id'] = $user['id'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['admin'] = $user['admin'];
                $_SESSION['loggedIn'] = True;
                header("Location: index.php?action=home");
                exit;
            }else{
                $_SESSION['login_errors'] = ["Incorrect password"];
                header("Location: index.php?action=login");
                exit;
             }

    
            $_SESSION['login_errors'] = ["Edge Case Detected: Please Report Bug"];
            header("Location: index.php?action=login");
            exit;
            }
    
}

