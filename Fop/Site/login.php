<?php
include_once '../mysql_config.php';
include_once 'functions.php';

sec_session_start();


if (login_check($dbc) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/form.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/normalize.css" />
    <link rel="stylesheet" href="styles/main.css" />
</head>
<body>
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error">Error Logging In!</p>';
    }
    ?> 
    <div id="login">
        <div class="logo">
            <h1 ><a href="#">Gest_FOP</a></h1>
            <h3>Federação Ornitológica Portuguesa</h3>
        </div>
        <div id="login_form">
            <h3>Bem vindo</h3>
            <form action="process_login.php" method="post" name="login_form">
                <input type="text" name="username" placeholder="username" size="30"  value=""/>
                <input type="password" name="password" id="password" placeholder="Password" size="30"  value=""/>
                <input type="button" value="Entrar" onclick="formhash(this.form, this.form.password);"/>
            </form>
        </div>
    </div>
</body>
</html>