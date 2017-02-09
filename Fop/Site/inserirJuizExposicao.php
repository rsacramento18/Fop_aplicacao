<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();   

if(isset($_POST['selectJuizes'], $_POST['idExposicao'])){
    $idJuiz = $_POST['selectJuizes'];
    $idExposicao = $_POST['idExposicao'];

    $query = "UPDATE exposicoes SET  idJuiz = '$idJuiz' WHERE idExposicao = '$idExposicao'";

    if($stmt = @mysqli_query($dbc, $query)) {
        header('Location: todasExposicoes.php');
    }
    else {
        echo "nao inseriu";}
}
else {
    echo "nao deu";
}
