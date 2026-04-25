<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>


<script>
    window.registerErrors = <?php
        echo json_encode($_SESSION['register_errors'] ?? []);
        unset($_SESSION['register_errors']);
    ?>;

    window.registerSuccess = <?php
        echo json_encode($_SESSION['register_success'] ?? "");
        unset($_SESSION['register_success']);
    ?>;
</script>


<link rel="stylesheet" href="View/auth/auth.css">
<div id = "register-root"></div>
<script type="text/babel" src="View/auth/register.js?v=6"></script>
