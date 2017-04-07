<?php
include_once '../mysql_config.php';
include_once 'functions.php';

sec_session_start();
if(isset($_POST['username'], $_POST['p'])) {
	$username = $_POST['username'];
	$password = $_POST['p'];
	if(login($username, $password, $dbc) == 'true'){
		if($username != 'admin' && $username != 'admin2'){
			$query2 = "INSERT INTO log ( user, accao ) 
			VALUES ( '$username', 'Entrada')";
			if($stmt2 = @mysqli_query($dbc, $query2)) {

				header('Location: home.php');
			}
		}
		else {
			header('Location: home.php');
		}
	}
	else if(login($username, $password, $dbc) == 'contaBlock'){
		header('Location: contaBloqueadaError.php?err= Este utilizador encontra-se bloqueado por razão de divida à fop.Para mais informações contactar a tesouraria.');
	}
    else if(login_socio($username, $password, $dbc)== 'true') {
        header('Location: home.php');
    }
    else if(login_socioEstrangeiro($username, $password, $dbc)== 'true') {
        header('Location: home.php');
    }
    else if(login_juiz($username, $password, $dbc)== 'true') {
        header('Location: home.php');
    }
	else {
		header('Location: login.php?error=1');
	}		
}
else {
	echo 'Invalid Request';
}
?>
