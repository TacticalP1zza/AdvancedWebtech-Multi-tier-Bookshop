

<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>

<?php
if (!empty($_SESSION['login_errors'])) {
    foreach ($_SESSION['login_errors'] as $error) {
        echo '<p style="color: red;">' . htmlentities($error, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    unset($_SESSION['login_errors']);
}
?>

<link rel="stylesheet" href="View/auth/auth.css">
<div id = "login-root"></div>
<script type="text/babel" src="View/auth/login.js?v=10></script>