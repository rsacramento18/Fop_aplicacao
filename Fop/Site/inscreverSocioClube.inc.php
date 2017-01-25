<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();
if(isset($_POST['stamExistente'])){

	$stam = $_POST['stamExistente'];
	if(isset($_POST['campoClube'])){
		$clube = $_POST['campoClube'];
	}
	else{
		$clube = $_SESSION['clube'];
	}


	$query = "SELECT MAX(membro_num) as membroNum FROM socios_clubes WHERE clube = '$clube'";
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$membro = $row['membroNum'] + 1;
	}
	$dataCurrente = date("Y-m-d");

	$query = "SELECT count(*) as count from socios_clubes where stam='$stam' AND clube = '$clube'";
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$count =  $row['count'];
	}

	if($count == 0){

		$query = "INSERT INTO socios_clubes (stam, clube, membro_num, data_adesao) 
		VALUES ('$stam', '$clube', $membro, '$dataCurrente')";
		if($stmt = @mysqli_query($dbc, $query)) {
			$_SESSION['stamInserido'] = $stam; 
			?><script type="text/javascript">location.href = 'registoSucesso.php';</script><?php
		}
		else {
			echo "nao deu insercao";
		}
	}
	else{
		header('Location: error.php?err=O associado já existe no clube.');
	}
}
?>