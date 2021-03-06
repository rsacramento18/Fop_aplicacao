<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['idExposicao'],$_POST['titulo'], $_POST['morada'], $_POST['dataInicio'], $_POST['dataFim'], $_POST['dataInicioInscricao'], $_POST['dataFimInscricao'], $_POST['tipoExposicao'], $_POST['clubes1'],$_POST['clubes2'], $_POST['clubes3'], $_POST['clubes4'], $_POST['clubes5'], $_POST['descricao'])) {

	$idExposicao= $_POST['idExposicao'];

	if($_POST['titulo'] != ''){
		$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
	}
	else{
		$error_msg .= '<p class="error">A exposição não tem um titulo.</p>';
	}

	if($_POST['morada'] != ''){
		$morada = filter_input(INPUT_POST, 'morada', FILTER_SANITIZE_STRING);
	}
	else{
		$morada = 'null';
	}

	if($_POST['dataInicio'] != ''){
		$dataInicio = $_POST['dataInicio'];
	}
	else{
		$dataInicio = '';
	}

	if($_POST['dataFim'] != ''){
		$dataFim = $_POST['dataFim'];
	}
	else{
		$dataFim = '';
	}


    if($_POST['dataInicioInscricao'] != ''){
		$dataInicioInscricao = $_POST['dataInicioInscricao'];
	}
	else{
		$dataInicioInscricao = '';
	}

	if($_POST['dataFimInscricao'] != ''){
		$dataFimInscricao = $_POST['dataFimInscricao'];
	}
	else{
		$dataFimInscricao = '';
	}
	
	$tipoExposicao = $_POST['tipoExposicao'];

	$clubeEscolhido1 = $_POST['clubes1'];

	if($_POST['clubes2'] == ''){
		$clubeEscolhido2 = NULL;
	}
	else{
		$clubeEscolhido2 = $_POST['clubes2'];
	}

	if($_POST['clubes3'] == ''){
		$clubeEscolhido3 = NULL;
	}
	else{
		$clubeEscolhido3 = $_POST['clubes3'];
	}

	if($_POST['clubes4'] == ''){
		$clubeEscolhido4 = NULL;
	}
	else{
		$clubeEscolhido4 = $_POST['clubes4'];
	}

	if($_POST['clubes5'] == ''){
		$clubeEscolhido5 = NULL;
	}
	else{
		$clubeEscolhido5 = $_POST['clubes5'];
	}

	if($_POST['descricao'] != ''){
		$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
	}
	else{
		$descricao = 'null';
	}	
    
    
    $pathFile = '';
    $pathFileExcel = '';

    $errors = array();
    if(!empty($_FILES['logo']['name'])){
	    $file_name = $_FILES['logo']['name'];
	    $file_size =$_FILES['logo']['size'];
	    $file_tmp =$_FILES['logo']['tmp_name'];
	    $file_type=$_FILES['logo']['type'];
	    $file_ext=strtolower(end(explode('.',$_FILES['logo']['name'])));

	    $expensions= array("jpeg","jpg","png");

	    if(in_array($file_ext,$expensions)=== false){
		    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	    }

        $pathFile = 'img/img_exposicoes/'.$file_name;
    }
    else {
        $query =  "Select logo from exposicoes where idExposicao = '$idExposicao'";
        if($stmt = @mysqli_query($dbc, $query)) {
		    $row = mysqli_fetch_array($stmt);
            $pathFile = $row['logo'];
        }
    }    
    if(!empty($_FILES['excel']['name'])){
	    $file_nameExcel = $_FILES['excel']['name'];
	    $file_sizeExcel =$_FILES['excel']['size'];
	    $file_tmpExcel =$_FILES['excel']['tmp_name'];
	    $file_typeExcel=$_FILES['excel']['type'];
	    $file_extExcel=strtolower(end(explode('.',$_FILES['excel']['name'])));

	    $expensionsExcel= array("csv");

	    if(in_array($file_extExcel,$expensionsExcel)=== false){
		    $errors[]="extension not allowed, please choose a csv.";
	    }

        $pathFileExcel = 'classes/'.$file_nameExcel;
    }
    else {
        $query =  "Select logo from exposicoes where idExposicao = '$idExposicao'";
        if($stmt = @mysqli_query($dbc, $query)) {
		    $row = mysqli_fetch_array($stmt);
            $pathFileExcel = $row['excel'];
        }
    }

	if(empty($error_msg)) {
		if(empty($errors)==true && !empty($_FILES['logo']['name'])){
		    move_uploaded_file($file_tmp, $pathFile);
		}
        
        
        if(empty($errors)==true && !empty($_FILES['excel']['name'])){
		 	move_uploaded_file($file_tmpExcel, $pathFileExcel);
	    }
		
		$query = "UPDATE exposicoes SET titulo = '$titulo', logo = '$pathFile', morada = '$morada', datainicio = '$dataInicio', dataFim = '$dataFim', dataInicioInscricao = '$dataInicioInscricao', dataFimInscricao = '$dataInicioInscricao', excel= '$pathFileExcel', descricao= '$descricao', tipoExposicao = '$tipoExposicao', clube1= '$clubeEscolhido1', clube2= '$clubeEscolhido2', clube3= '$clubeEscolhido3', clube4= '$clubeEscolhido4', clube5= '$clubeEscolhido5' WHERE idExposicao = '$idExposicao'";

		if($stmt = @mysqli_query($dbc, $query)) {


			header('Location: exposicaoSucesso.php');
		}
		else {
			header('Location: error.php?err='.$error_msg);
		}
	}

}
else{
	echo "Erro na insercao dos dados.";
}
?>
