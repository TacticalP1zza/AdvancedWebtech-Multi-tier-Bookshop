<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>

<script>
    window.registerErrors = <?php
        echo json_encode($_SESSION['registerErrors'] ?? []);
        unset($_SESSION['registerErrors']);
    ?>;

    window.registerSuccess = <?php
        echo json_encode($_SESSION['registerSuccess'] ?? "");
        unset($_SESSION['registerSuccess']);
    ?>;
</script>

<link rel="stylesheet" href="Public/CSS/authentication.css">
<div id="register-root"></div>
<script type="text/babel" src="Public/JS/register.js?v=6"></script>