<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>

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