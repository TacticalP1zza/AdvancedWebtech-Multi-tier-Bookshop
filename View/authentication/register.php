<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>

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