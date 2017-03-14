<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();   

if(isset($_POST['selectJuizes'], $_POST['idExposicao'])){
    $idJuiz = $_POST['selectJuizes'];
    $idExposicao = $_POST['idExposicao'];

    $query = "INSERT INTO juizes_exposicao (exposicao, juiz) values( '$idExposicao', '$idJuiz')";

    if($stmt = @mysqli_query($dbc, $query)) {
        header('Location: todasExposicoes.php');
    }
    else {
        echo "nao inseriu";}
}
else {
    echo "nao deu";
}
