<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();   

if(isset($_POST['user'], $_POST['contribuinte'])){
    $stam = $_POST['user'];
    $contribuinte= $_POST['contribuinte'];
    
    $contribuinte = filter_input(INPUT_POST, 'contribuinte', FILTER_SANITIZE_NUMBER_INT);

    if(!($contribuinte > 100000000 && $contribuinte < 999999999)) {
           $error_msg = '<p class="error">Contribuinte Errado</p>';
    }

    $query = "UPDATE socios SET  contribuinte = '$contribuinte' WHERE stam = '$stam'";
    if(empty($error_msg)){
        if($stmt = @mysqli_query($dbc, $query)) {
            header('Location: home.php');
        }   
        else {
            header('location: error2.php?err='.$error_msg);
        }
    }
    else {
            header('location: error2.php?err='.$error_msg);
    }
}
else {
    echo "nao deu";
}
