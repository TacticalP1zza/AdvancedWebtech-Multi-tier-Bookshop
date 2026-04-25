<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Not logged in
if (empty($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: index.php?action=login");
    exit;
}

// Session hijack protection
if (!isset($_SESSION['id']) || $_SESSION['id'] !== session_id()) {
    session_destroy();
    header("Location: index.php?action=login");
    exit;
}
?>