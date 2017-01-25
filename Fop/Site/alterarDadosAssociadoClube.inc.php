<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['clube'], $_POST['membroNum'], $_POST['stam'], $_POST['dataAdesao'])) {

	$clube = $_POST['clube'];
	$dataAdesao = $_POST['dataAdesao'];

	$anoCorrente = date('Y');

	$dataAdesao = explode ('-' , $dataAdesao);	

	if(intval($dataAdesao[0]) > $anoCorrente){
		$error_msg .= '<p class="error">Data Incorreta no ano.</p>';
	}
	if(intval($dataAdesao[1]) < 1 || intval($dataAdesao[1]) > 12){
		$error_msg .= '<p class="error">Data Incorreta no mês.</p>';
	}

	switch ($dataAdesao[1]) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				if(intval($dataAdesao[2]) < 1 && intval($dataAdesao[2]) > 31 ){
					$error_msg .= '<p class="error">Data Incorreta no dia.</p>';
				}
				break;
			case 4:
			case 6:
			case 9:
			case 11:
				if(intval($dataAdesao[2]) < 1 && intval($dataAdesao[2]) > 30 ){
					$error_msg .= '<p class="error">Data Incorreta no dia.</p>';
				}
				break;
			case 2:
				if(intval($dataAdesao[2]) < 1 && intval($dataAdesao[2]) > 29 ){
					$error_msg .= '<p class="error">Data Incorreta no dia.</p>';
				}
				break;
			default:
				$error_msg .= '<p class="error">Data Incorreta no dia.</p>';
				break;
		}

	$dataAdesao = implode('-', $dataAdesao);

	$membroNum = filter_input(INPUT_POST, 'membroNum', FILTER_SANITIZE_NUMBER_INT);
	if($membroNum < 1){
		$error_msg .= '<p class="error">Numero de Associado Invalido.</p>';
	}
	$query = "SELECT membroNum from socios_clubes where clube = '$clube' AND membroNum != '$membroNum' LIMIT 1";
	if($stmt = @mysqli_query($dbc, $query)){ 

		if($stmt->num_rows == 1 ) {
			$error_msg .= '<p class="error">Já existe um Associado com este número.</p>';
		}
	}


	$stam = $_POST['stam'];
	$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
	if($_POST['email']!=""){
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		}
	else {
		$email = '';
	}

	
	if(empty($error_msg)) {
		$query = "UPDATE socios_clubes SET membro_num = '$membroNum', data_adesao = '$dataAdesao' WHERE stam = '$stam' AND clube = '$clube'";
		if($update_stmt = mysqli_prepare($dbc, $query)){
			mysqli_stmt_execute($update_stmt);
			$affected_rows = mysqli_stmt_affected_rows($update_stmt);
			if (! $affected_rows == 1) {
		        header('Location: error.php?err=DataSet failure: INSERT Segundo');
		    }
		    else{
		    	$_SESSION['stamInserido'] =$stam;
	    		header('Location: registoSucesso.php');
		    }
		}
		else{
			header('Location: error.php?err=DataSet failure: INSERT Segundo');
		}
	}
	else {
    	header('Location: error.php?err='.$error_msg);
	}

}
?>