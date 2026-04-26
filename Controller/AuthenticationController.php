<?php

require_once __DIR__ . '/MainController.php';

/**
 * AuthenticationController.php
 *
 * Purpose:
 * - Handles user registration, login, logout, CAPTCHA validation,
 *   and AJAX email availability checking.
 *
 * Responsibilities:
 * - Validate registration and login form input
 * - Authenticate users
 * - Generate and validate CAPTCHA
 *
 *
 */

class AuthenticationController extends MainController
{
    private $userModel;
    private $captchaModel;

    public function __construct($userModel, $captchaModel)
    {
        parent::__construct();

        $this->userModel = $userModel;
        $this->captchaModel = $captchaModel;
    }

    /**
     * showLogin
     *
     * Redirects to the login page and prepares a CAPTCHA challenge.
     *
     * @return string View path
     */
    public function showLogin()
    {
        $captcha = $this->captchaModel->getRandomCaptcha();

        if ($captcha) {
            $_SESSION['loginCaptchaId'] = $captcha['id'];
            $_SESSION['loginCaptchaImage'] = $captcha['imageName'];
        }

        return 'authentication/login';
    }

    /**
     * showRegister
     * 
     * Redirects to the registration page.
     *
     * @return string View path
     */
    public function showRegister()
    {
        return 'authentication/register';
    }

    /**
     * checkEmailExists
     *
     * - Uses AJAX to check if a email is available before they hit register button.
     * - Sanitises and validates the email before querying the model.
     *
     * @return void JSON response
     */
    public function checkEmailExists()
    {
        $email = $this->getInput($_GET, 'email');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['exists' => false]);
        }

        $emailExists = $this->userModel->checkEmailExists($email);

        $this->jsonResponse(['exists' => $emailExists]);
    }

    /**
     * handleRegister
     *
     * Handles the Registration of a user.
     *
     * Practical 7:
     * Implements password_hash() as required in the practical.
     *
     * @return void Redirects to login upon success
     */
    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('register');
        }

        $username = $this->getInput($_POST, 'userName');
        $phone = $this->getInput($_POST, 'phone');
        $email = $this->getInput($_POST, 'email');
        $confirmEmail = $this->getInput($_POST, 'confirmEmail');
        $password = $this->getInput($_POST, 'password');
        $confirmPassword = $this->getInput($_POST, 'confirmPassword');

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $confirmEmail = filter_var($confirmEmail, FILTER_SANITIZE_EMAIL);

        $errors = [];

        if ($username === '' || !preg_match('/^[A-Za-z0-9_ ]{3,30}$/', $username)) {
            $errors[] = "Username must be 3-30 characters and contain only letters, numbers, spaces, or underscores.";
        }

        if ($phone === '' || !preg_match('/^[0-9]{10,11}$/', $phone)) {
            $errors[] = "Phone number must contain 10 or 11 digits.";
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if ($confirmEmail === '' || !filter_var($confirmEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid confirmation email address.";
        }

        if ($email !== $confirmEmail) {
            $errors[] = "Emails do not match.";
        }

        if ($email !== '' && $this->userModel->CheckEmailExists($email)) {
            $errors[] = "Email address already exists.";
        }

        if ($password === '') {
            $errors[] = "Password is required.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
        }

        if (!empty($errors)) {
            $_SESSION['registerErrors'] = $errors;
            $this->redirectTo('register');
        }

        //Practical 7: store only the hashed password, never the plain password.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $success = $this->userModel->createUser(
            $username,
            $phone,
            $email,
            $hashedPassword
        );

        if ($success) {
            $_SESSION['registerSuccess'] = "Registration successful. Please log in.";
            $this->redirectTo('login');
        }

        $_SESSION['registerErrors'] = ["Registration failed. Please try again."];
        $this->redirectTo('register');
    }

    /**
     * handleLogin
     *
     * - Authenticates a user and creates a secure logged-in session.
     *
     * - Validates CAPTCHA before login
     * - Uses password_verify() to compare password with stored hash
     * - Regenerates session ID after successful login to reduce session hijacking risk
     *
     * @return void Redirects to shop upon success
     */
    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('login');
        }

        $email = $this->getInput($_POST, 'email');
        $password = $this->getInput($_POST, 'password');
        $captchaInput = $this->getInput($_POST, 'captchaAnswer');
        $captchaId = $_SESSION['loginCaptchaId'] ?? '';

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $errors = [];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if ($password === '') {
            $errors[] = "Password is required.";
        }

        if ($captchaInput === '') {
            $errors[] = "CAPTCHA is required.";
        } elseif (!$this->captchaModel->captchaMatches($captchaId, $captchaInput)) {
            $errors[] = "CAPTCHA image does not match the entered information.";
        }

        if (!empty($errors)) {
            $_SESSION['loginErrors'] = $errors;
            $this->redirectTo('login');
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['loginErrors'] = ["Incorrect email or password."];

            $captcha = $this->captchaModel->getRandomCaptcha();

            if ($captcha) {
                $_SESSION['loginCaptchaId'] = $captcha['id'];
                $_SESSION['loginCaptchaImage'] = $captcha['imageName'];
            }

            $this->redirectTo('login');
        }

        session_regenerate_id(true);

        $_SESSION['sessionId'] = session_id();
        $_SESSION['userId'] = (int) $user['id'];
        $_SESSION['username'] = $user['userName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['isAdmin'] = (int) $user['admin'];
        $_SESSION['isLoggedIn'] = true;

        unset($_SESSION['loginCaptchaId']);
        unset($_SESSION['loginCaptchaImage']);

        $this->redirectTo('shop');
    }

    /**
     * handleLogout
     *
     * - Logs the user out and destroys the current session.
     * - Clears session variables
     * - Removes the session cookie
     * - Destroys the server-side session
     *
     * @return void Redirects to login page
     */
    public function handleLogout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        $this->redirectTo('login');
    }
}