<?php

/**
 * MainController.php
 *
 * Purpose:
 * - Provides helper methods.
 *
 * Responsibilities:
 * - Redirect handling
 * - JSON responses
 * - Input validation
 * - Session-based authentication
 * - Administrator access control
 *
 * Practical 7 Note:
 * - Replaces authorise.php using isLoggedIn() and requireLogin()
 * - Replaces secure-admin.php using requireAdmin()
 */

class MainController
{
    public function __construct()
    {
        // Practical 7: start session before reading or writing session variables.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }

    /**
     * redirectTo
     *
     * - Redirects the user to a page based on action variable.
     *
     * @param string $action Route action name
     * @return void
     */
    protected function redirectTo($action)
    {
        header("Location: index.php?action=" . $action);
        exit;
    }

    /**
     * jsonResponse
     *
     * - Sends a structured JSON response.
     *
     * @param array $data Response data
     * @param int $statusCode HTTP response code
     * @return void
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * getInput
     *
     * - Gets data from $_GET or $_POST.
     *
     * Practical 7 / Lecture 14:
     * - Addresses malformed input attacks where attackers submit arrays
     *   instead of expected scalar values.
     *
     * @param array $source Input source, usually $_GET or $_POST
     * @param string $key Input key
     * @return string Sanitised scalar input or empty string
     */
    protected function getInput($source, $key)
    {
        if (!isset($source[$key]) || is_array($source[$key])) {
            return '';
        }
    
        return trim((string) $source[$key]);
    }

    /**
     * isLoggedIn
     *
     * - Checks whether the current session has a valid logged-in user.
     *
     * Security:
     * - Confirms login flag is present.
     * - Confirms stored session ID matches current session ID.
     *
     * Practical 7:
     * - Replaces authorise.php.
     *
     * @return bool True if session is authenticated and valid
     */
    protected function isLoggedIn()
    {
        return !empty($_SESSION['isLoggedIn'])
            && $_SESSION['isLoggedIn'] === true
            && !empty($_SESSION['sessionId'])
            && $_SESSION['sessionId'] === session_id()
            && !empty($_SESSION['sessionIp'])
            && $_SESSION['sessionIp'] === $_SERVER['REMOTE_ADDR']
            && isset($_SESSION['sessionUserAgent'])
            && $_SESSION['sessionUserAgent'] === ($_SERVER['HTTP_USER_AGENT'] ?? '');
    }

    /**
     * requireLogin
     *
     * Purpose:
     * - Protects routes that require authentication.
     *
     * Security:
     * - Redirects unauthenticated or invalid sessions to login.
     *
     * Practical 7:
     * - Replaces authorise.php.
     *
     * @return void
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['loginErrors'] = ["Please login first."];
            $this->redirectTo('login');
        }
    }

    /**
     * requireAdmin
     *
     * Purpose:
     * - Protects routes that require admini privileges.
     *
     * Security:
     * - Calls requireLogin() first.
     * - Checks admin role after authentication.
     *
     * Practical 7
     * - Replaces secure-admin.php.
     *
     * @return void
     */
    protected function requireAdmin()
    {
        $this->requireLogin();

        if (empty($_SESSION['isAdmin']) || (int) $_SESSION['isAdmin'] !== 1) {
            $this->redirectTo('shop');
        }
    }

    /**
     * blockAdminOrdering
     *
     * Purpose:
     * - Prevents admin users from using customer-only features.
     *
     * @return void
     */
    protected function blockAdminOrdering()
    {
        if (!empty($_SESSION['isAdmin']) && (int) $_SESSION['isAdmin'] === 1) {
            $_SESSION['orderErrors'] = ["Admin accounts cannot place customer orders."];
            $this->redirectTo('adminDashboard');
        }
    }
}