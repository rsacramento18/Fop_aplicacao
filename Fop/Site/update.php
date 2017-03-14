<?php
include_once '../mysql_config.php';
include_once 'functions.php';
sec_session_start();
    $_SESSION["tableAves"] = $_POST["tableAves"];
    $_SESSION["idExposicao"] = $_POST["exposicao"];
?>
