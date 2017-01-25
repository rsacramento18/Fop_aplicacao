<?php
include_once 'functions.php';

sec_session_start();

$username = $_SESSION['user'];

$_SESSION =array();

$params = session_get_cookie_params();

setcookie(session_name(), '', time() - 42000,
	$params["path"],
	$params["domain"],
	$params["secure"],
	$params["httponly"]);
if(login($username, $password, $dbc) == true){
	$query2 = "INSERT INTO log ( user, accao ) 
	VALUES ( '$username', 'Saida')";
	if($stmt2 = @mysqli_query($dbc, $query2)) {

		session_destroy();
		header('Location: login.php');
	}
}
else {
	session_destroy();
	header('Location: login.php');
}
?>