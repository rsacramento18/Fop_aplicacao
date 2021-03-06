<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['titulo'], $_FILES['logo'], $_POST['morada'], $_POST['dataInicio'], $_POST['dataFim'], $_POST['dataInicioInscricao'], $_POST['dataFimInscricao'], $_POST['tipoExposicao'], $_POST['clubes1'], $_POST['clubes2'], $_POST['clubes3'], $_POST['clubes4'], $_POST['clubes5'], $_POST['descricao'])) {


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
		$morada = NULL;
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
		$descricao = NULL;
	}	

	$errors = array();
	$file_name = $_FILES['logo']['name'];
	$file_size =$_FILES['logo']['size'];
	$file_tmp =$_FILES['logo']['tmp_name'];
	$file_type=$_FILES['logo']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['logo']['name'])));

	$expensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$expensions)=== false){
		$errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}

	if($file_size > 2097152){
		$errors[]='File size must be excately 2 MB';
	}

	$pathFile = 'img/img_exposicoes/'.$file_name;


	$file_nameExcel = $_FILES['excel']['name'];
	$file_sizeExcel =$_FILES['excel']['size'];
	$file_tmpExcel =$_FILES['excel']['tmp_name'];
	$file_typeExcel=$_FILES['excel']['type'];
	$file_extExcel=strtolower(end(explode('.',$_FILES['excel']['name'])));

	$expensionsExcel= array("csv");

	if(in_array($file_extExcel,$expensionsExcel)=== false){
		$errors[]="extension not allowed, please choose a xls.";
	}

	if($file_sizeExcel > 2097152){
		$errors[]='File size must be excately 2 MB';
	}

	$pathFileExcel = 'classes/'.$file_nameExcel;

	if(empty($error_msg)) {
		 if(empty($errors)==true){
			move_uploaded_file($file_tmp, $pathFile);
			move_uploaded_file($file_tmpExcelp, $pathFileExcel);
		 }
		 else {
		 	print_r($errors);
		 }

         $query = "INSERT INTO exposicoes (titulo, logo, morada, datainicio, dataFim, dataInicioInscricao, dataFimInscricao, excel, descricao ,tipoExposicao, clube1, clube2, clube3, clube4, clube5 ) VALUES ('$titulo', '$pathFile', '$morada', '$dataInicio', '$dataFim', '$dataInicioInscricao', '$dataFimInscricao', '$pathFileExcel' ,'$descricao', '$tipoExposicao','$clubeEscolhido1','$clubeEscolhido2','$clubeEscolhido3','$clubeEscolhido4','$clubeEscolhido5')";

		if($stmt = @mysqli_query($dbc, $query)) {


			header('Location: exposicaoSucesso.php');
		}
		else {
			header('Location: error.php?err='.$error_msg.$errors);
		}
	}

}
else{
	echo "Erro na insercao dos dados.";
}
?>
