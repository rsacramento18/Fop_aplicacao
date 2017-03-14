<?php
include_once '../mysql_config.php';
include_once 'functions.php';
sec_session_start();
    $_SESSION["aves"] = $_POST["avesphp"];

?>
