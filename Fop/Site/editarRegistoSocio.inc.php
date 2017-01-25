<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['stam'], $_POST['nome'], $_POST['bi'], 
    $_POST['pais'] , $_POST['regiao'], $_POST['morada'], $_POST['cod_postal'], $_POST['Localidade'], $_POST['telefone2'])) {

  $stam = $_POST['stam'];
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
if($_POST['email']!=""){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
}
else {
    $email = '';
}

if($_POST['telefone1']!="0" && $_POST['telefone1']!=''){
    $telefone1 = filter_input(INPUT_POST, 'telefone1', FILTER_SANITIZE_NUMBER_INT);
    if($telefone1 < 100000000 || $telefone1 > 999999999 ){
        $error_msg .= '<p class="error">Numero de telefone invalido.</p>';
    }
}
else{
    $telefone1 = "NULL";
}

$email = filter_var($email, FILTER_VALIDATE_EMAIL);

$bi = $_POST['bi'];



if($bi > 10000000 && $bi < 9999999999) {
    $query = "SELECT bi FROM socios WHERE bi LIKE '%$bi%' AND stam != '$stam'LIMIT 1";

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
    $query = "SELECT stam from socios where bi LIKE '%$bi%'";
    $stamExistente = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $stamExistente =  $row['stam'];
    }
    $stmt->close();
    $_SESSION['stamExistente'] = $stamExistente;
    ?><script type="text/javascript">location.href = 'inscreverSocioClube.php';</script><?php
}

$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);

$regiao = filter_input(INPUT_POST, 'regiao', FILTER_SANITIZE_STRING);

$morada = filter_input(INPUT_POST, 'morada', FILTER_SANITIZE_STRING);

$postalValidador = "^\d{4}(-\d{3})?$";

$cod_postal = filter_input(INPUT_POST, 'cod_postal', FILTER_SANITIZE_STRING);

$cod_postal = explode(' ', $cod_postal, 2);

if (!preg_match("/^\d{4}(-\d{3})?$/i",$cod_postal[0])){
    $error_msg .= '<p> class="error">O codigo postal nào é valido.</p>';
}

$cod = $cod_postal[0]. " ".$cod_postal[1]; 

$localidade = filter_input(INPUT_POST, 'Localidade', FILTER_SANITIZE_STRING);

$telefone2 = filter_input(INPUT_POST, 'telefone2', FILTER_SANITIZE_NUMBER_INT);

if($telefone2 < 100000000 || $telefone2 > 999999999 ){
    $error_msg .= '<p class="error">Numero de telemóvel invalido.</p>';
}

if(empty($error_msg)) {
  $query = "UPDATE socios 
  SET nome='$nome', email = '$email', bi = $bi, pais = '$pais', regiao = '$regiao', 
  morada = '$morada', cod_postal = '$cod', Localidade = '$localidade',
  telefone1 = $telefone1, telefone2 = $telefone2 
  WHERE stam = '$stam'";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
    mysqli_stmt_execute($update_stmt);
    $affected_rows = mysqli_stmt_affected_rows($update_stmt);
    if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: INSERT');
    }
    else{
        $_SESSION['stamInserido'] =$stam;
        header('Location: registoSucesso.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: Erro ao fazer o update');
}
}
else {
    header('Location: error.php?err='.$error_msg);
}
}
else{
}   
?>