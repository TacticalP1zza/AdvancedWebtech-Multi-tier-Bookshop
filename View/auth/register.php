<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>

<?php
if (!empty($_SESSION['register_success'])) {
    echo '<p style="color: green;">' . htmlentities($_SESSION['register_success'], ENT_QUOTES, 'UTF-8') . '</p>';
    unset($_SESSION['register_success']);
}
?>


<link rel="stylesheet" href="View/auth/auth.css">
<div id = "register-root"></div>
<script type="text/babel" src="View/auth/register.js?v=1"></script>
