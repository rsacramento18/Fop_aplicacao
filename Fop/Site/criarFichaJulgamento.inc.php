<?php
require_once '../mysql_config.php';

$error_msg = "";



if(isset($_POST['nomeFicha'], $_POST['counterTopico'])) {

    $nomeFicha = filter_input(INPUT_POST, 'nomeFicha', FILTER_SANITIZE_STRING);
    $counterTopico = filter_input(INPUT_POST, 'counterTopico', FILTER_SANITIZE_NUMBER_INT);
    
    $topicosNome = array();
    $topicosPontuacao = array();
    for($i = 0, $j=1; $i < $counterTopico ; $i++){
        if(isset($_POST['topicoNome'.$j], $_POST['pontuacaoTopico'.$j])){
            $topicosNome[$i] = $_POST['topicoNome'.$j];
            $topicosPontuacao[$i] = $_POST['pontuacaoTopico'.$j];
            
        }
        $j++;
    }

        

    $query = "SELECT nomeFicha FROM fichasJulgamento WHERE nomeFicha = '$nomeFicha' LIMIT 1";
	$nomeFichaExistente = '';
	if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $nomeFichaExistente = $row['nomeFicha'];
        if(!empty($nomeFichaExistente)){
            $nomeFicha .= " Copia";
        }
    }
		/* $stamExistente =  $row['stam']; */
    /*     if($stamExistente != $stamRegistar) $error_msg .= '<p class="error">O stam indicado nao existe na base  de dados. Escolha Outro</p>'; */
    /*     $query = "SELECT stamContaSocio FROM contasSocio WHERE stamContaSocio = '$stamRegistar' LIMIT 1"; */
    /*     if($stmt = @mysqli_query($dbc, $query)) { */
    /*         $row = mysqli_fetch_array($stmt); */
    /*         $stamExistente = $row['stamContaSocio']; */
    /*         if($stamExistente == $stamRegistar) $error_msg .= '<p class="error">O stam indicado ja existe noutra conta Indique outro stam.</p>'; */
    /*     } */
	/* } */


    /* $query = "SELECT bi FROM socios WHERE bi = '$biRegistar' LIMIT 1"; */
	/* $biExistente = ''; */
	/* if($stmt = @mysqli_query($dbc, $query)) { */
		/* $row = mysqli_fetch_array($stmt); */
		/* $biExistente=  $row['bi']; */
    /*     if($biExistente != $biRegistar) $error_msg .= '<p class="error">O bi indicado nao existe na base  de dados. Escolha Outro.</p>'; */
    /*     $query = "SELECT bi FROM contasSocio WHERE bi = '$biRegistar' LIMIT 1"; */
    /*     if($stmt = @mysqli_query($dbc, $query)) { */
    /*         $row = mysqli_fetch_array($stmt); */
    /*         $biExistente= $row['bi']; */
    /*         if($biExistente== $biRegistar) $error_msg .= '<p class="error">O bi indicado ja existe noutra conta Indique outro stam.</p>'; */
    /*     } */
	/* } */

        
    /* echo $error_msg; */
    /* if(empty($error_msg)) { */
    /*     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)); */
      
    /*     $password = hash('sha512', $password . $random_salt); */

    /*     $query = "INSERT INTO contasSocio( stamContaSocio ,bi , password, salt) VALUES ( ?, ?, ?, ?)"; */
    /*     if ($insert_stmt = mysqli_prepare($dbc, $query)){ */
        
    /*         mysqli_stmt_bind_param($insert_stmt, 'ssss', $stamRegistar, $biRegistar, */ 
    /*         $password, $random_salt); */
    /*             // Execute the prepared query. */
    /*         mysqli_stmt_execute($insert_stmt); */
    /*         $affected_rows = mysqli_stmt_affected_rows($insert_stmt); */
    /*         if (! $affected_rows == 1) { */
    /*             header('location: error2.php?err=Houve um erro na insercao dos dados na base de dados. Por favor tente novamente.'); */
    /*         } */
    /*         else{ */
    /*             header('Location: register_success.php'); */
    /*         } */   
    /*     } */
    /* } */
    /* else { */
          
    /*         header('location: error2.php?err='.$error_msg); */
    /* } */
}
else {
    echo "nao deu";
}



?>
