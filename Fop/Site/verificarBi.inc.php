<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

$error_msg = "";
if(isset($_POST['bi'])) {
    
    $bi = $_POST['bi'];
    $bi = filter_input(INPUT_POST, 'bi', FILTER_SANITIZE_NUMBER_INT);
    

    if($bi > 1000000 && $bi < 9999999999) {
        $query = "SELECT bi FROM socios WHERE bi LIKE '%$bi%' LIMIT 1";

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
else {
    $_SESSION['biNovo'] = $bi;
    ?><script type="text/javascript">location.href = 'verificarBi.process2.php';</script><?php
}

}
else{
    ?><script type="text/javascript">location.href = 'verificarBi.php';</script><?php
}   
?>