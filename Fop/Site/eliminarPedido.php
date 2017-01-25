<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_SESSION['anilhasUser'])){

	$row = $_SESSION['anilhasUser'];
	$stam = $row['stam'];
	$query = "SELECT pedidoNum from pedidoEmVigor where id = 1";
	$cartaoFopPago = 'Não';
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$pedidoEmVigor =  $row['pedidoNum'];
	}

	$query = "SELECT cartaoFopPago from encomendasAnilhas Where stam = '$stam' and vagaNum = '$pedidoEmVigor'";
	$cartaoFopPago = 'Não';
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$cartaoFopPago =  $row['cartaoFopPago'];
	}

	$query = "DELETE FROM encomendasAnilhas 
	Where stam = '$stam' and vagaNum = '$pedidoEmVigor'";
	if($stmt = @mysqli_query($dbc, $query)) {
		if($cartaoFopPago == 'Sim'){
			$query = "UPDATE socios SET cartaoFop = '0000'
		  			WHERE stam = '$stam'";
		  	if($stmt = @mysqli_query($dbc, $query)) {
		  		header('Location: encomendarAnilhasFase1.php');
		  	}
		}
		header('Location: encomendarAnilhasFase1.php');
	}
}
?>