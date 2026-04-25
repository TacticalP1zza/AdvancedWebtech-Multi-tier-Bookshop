

<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react/umd/react.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/react-dom/umd/react-dom.development.js"></script>
<script src="/AdvancedWebtech-Multi-tier-Bookshop/Dependencies/node_modules/@babel/standalone/babel.min.js"></script>

<script>
    window.loginErrors = <?php
        echo json_encode($_SESSION['login_errors'] ?? []);
        unset($_SESSION['login_errors']);
    ?>;

    window.loginCaptchaImage = <?php
        echo json_encode($_SESSION['login_captcha_image'] ?? "");
    ?>;

</script>


<link rel="stylesheet" href="View/auth/auth.css">
<div id = "login-root"></div>
<script type="text/babel" src="View/auth/login.js?v=10"></script>