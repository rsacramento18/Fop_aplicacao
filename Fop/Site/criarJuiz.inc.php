<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['nomeJuiz'], $_POST['emailJuiz'],$_POST['biJuiz'], 
    $_POST['paisJuiz'] , $_POST['regiaoJuiz'], $_POST['moradaJuiz'], $_POST['cod_postalJuiz'], $_POST['LocalidadeJuiz'], 
    $_POST['telefone1Juiz'])) {

    $nome = filter_input(INPUT_POST, 'nomeJuiz', FILTER_SANITIZE_STRING);
if($_POST['emailJuiz']!=""){
    $email = filter_input(INPUT_POST, 'emailJuiz', FILTER_SANITIZE_EMAIL);
}
else {
    $email = '';
}

if($_POST['telefone1Juiz']!=""){
    $telefone1 = filter_input(INPUT_POST, 'telefone1Juiz', FILTER_SANITIZE_NUMBER_INT);
    if($telefone1 < 100000000 || $telefone1 > 999999999 ){
        $error_msg .= '<p class="error">Numero de telefone invalido.</p>';
    }
}
else{
    $telefone1 = "NULL";
}

$email = filter_var($email, FILTER_VALIDATE_EMAIL);

$bi = filter_input(INPUT_POST, 'biJuiz', FILTER_SANITIZE_NUMBER_INT);



if($bi > 1000000 && $bi < 9999999999) {
    $query = "SELECT bi FROM juizes WHERE bi LIKE '%$bi%' LIMIT 1";

    if($stmt = @mysqli_query($dbc, $query)){ 

        if($stmt->num_rows == 1 ) {
           $error_msg .= '<p class="error">Um utilizador com este bilhete de identidade já existe.</p>';
           $biVerificar = "true";
       }
       else {
        $biVerificar = "false";
    }

}
}

if($biVerificar == "true"){           
    $query = "SELECT stam from juizes where bi LIKE '%$bi%'";
    $stamExistente = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $stamExistente =  $row['stam'];
    }
    $stmt->close();
    $_SESSION['stamExistente'] = $stamExistente;
    ?><script type="text/javascript">location.href = 'inscreverSocioClube.php';</script><?php
}

$pais = filter_input(INPUT_POST, 'paisJuiz', FILTER_SANITIZE_STRING);

$regiao = filter_input(INPUT_POST, 'regiaoJuiz', FILTER_SANITIZE_STRING);

$morada = filter_input(INPUT_POST, 'moradaJuiz', FILTER_SANITIZE_STRING);

$postalValidador = "^\d{4}(-\d{3})?$";

$cod_postal = filter_input(INPUT_POST, 'cod_postalJuiz', FILTER_SANITIZE_STRING);

$cod_postal = explode(' ', $cod_postal, 2);

if (!preg_match("/^\d{4}(-\d{3})?$/i",$cod_postal[0])){
    $error_msg .= '<p> class="error">O codigo postal nào é valido.</p>';
}

$cod = $cod_postal[0]. " ".$cod_postal[1]; 

$localidade = filter_input(INPUT_POST, 'LocalidadeJuiz', FILTER_SANITIZE_STRING);

$telefone2 = filter_input(INPUT_POST, 'telefone2Juiz', FILTER_SANITIZE_NUMBER_INT);

if($telefone2 < 100000000 || $telefone2 > 999999999 ){
    $error_msg .= '<p class="error">Numero de telemóvel invalido.</p>';
}


if(empty($error_msg)) {
    $query = "INSERT INTO juizes (nome, email, bi, pais, regiao, morada, cod_postal, Localidade, telefone1, telefone2) VALUES ('$nome', '$email', $bi, '$pais',
  ' $regiao', '$morada', '$cod', '$localidade', $telefone1, $telefone2 )";

    if($stmt = @mysqli_query($dbc, $query)) {
        $_SESSION['biJuizInserido'] = $bi;
        header('Location: registoSucessoJuiz.php');
    }
    else{
       header('Location: error.php?err=DataSet failure: Erro ao inserir novo registo.'.$error_msg);
    }
   
}
else{

    header('Location: error.php?err=DataSet failure: Erro ao inserir novo registo1.'.$error_msg);
}
}
else {
    header('Location: error.php?err='.$error_msg);
}


?>
