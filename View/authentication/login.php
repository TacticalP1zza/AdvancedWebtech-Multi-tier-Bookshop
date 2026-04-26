<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>

<script>
    window.loginErrors = <?php
        echo json_encode($_SESSION['loginErrors'] ?? []);
        unset($_SESSION['loginErrors']);
    ?>;

    window.loginCaptchaImage = <?php
        echo json_encode($_SESSION['loginCaptchaImage'] ?? "");
    ?>;
</script>

<link rel="stylesheet" href="Public/CSS/authentication.css">

<div id="login-root"></div>

<script type="text/babel" src="Public/JS/login.js?v=10"></script>