<?php

/**
 *
 * @class MainController
 *
 * @description
 * Base controller that provides shared helper methods for routing,
 * JSON responses, input handling, session authentication, and
 * administrator access control.
 *
 * @security
 * - Starts sessions before accessing session variables.
 * - Adds common HTTP security headers.
 * - Validates session ID, IP address, and user agent.
 *
 * @practical Practical 7
 * @note Replaces authorise.php using isLoggedIn() and requireLogin().
 * @note Replaces secure-admin.php using requireAdmin().
 */
class MainController
{
    /**
     * Starts session and sets security headers.
     * @returns void
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }

    /**
     * Redirects to a route action.
     * @param string $action
     * @returns void
     */
    protected function redirectTo($action)
    {
        header("Location: index.php?action=" . $action);
        exit;
    }

    /**
     * Outputs data as JSON.
     * @param array $data
     * @param int $statusCode
     * @returns void
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Returns trimmed scalar input.
     * @param array $source
     * @param string $key
     * @returns string
     */
    protected function getInput($source, $key)
    {
        if (!isset($source[$key]) || is_array($source[$key])) {
            return '';
        }

        return trim((string) $source[$key]);
    }

    /**
     * Returns current login status.
     * @returns bool
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
     * Redirects unauthenticated users to login.
     * @returns void
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['loginErrors'] = ["Please login first."];
            $this->redirectTo('login');
        }
    }

    /**
     * Redirects non-admin users to shop.
     * @returns void
     */
    protected function requireAdmin()
    {
        $this->requireLogin();

        if (empty($_SESSION['isAdmin']) || (int) $_SESSION['isAdmin'] !== 1) {
            $this->redirectTo('shop');
        }
    }

    /**
     * Blocks admin users from customer ordering.
     * @returns void
     */
    protected function blockAdminOrdering()
    {
        if (!empty($_SESSION['isAdmin']) && (int) $_SESSION['isAdmin'] === 1) {
            $_SESSION['orderErrors'] = ["Admin accounts cannot place customer orders."];
            $this->redirectTo('adminDashboard');
        }
    }
}