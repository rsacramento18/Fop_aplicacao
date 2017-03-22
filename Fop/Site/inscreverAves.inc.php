<?php 
include_once '../mysql_config.php';
include_once 'functions.php';
sec_session_start(); 

if(isset($_POST['clubeInscreverAves'],$_POST['stamInscreverAves'], $_POST['idExposicaoInscreverAves'])){
    $stam = $_POST['stamInscreverAves'];
    $stam = strtoupper (  $stam );
    $clube = $_POST['clubeInscreverAves'];
    $idExposicao = $_POST['idExposicaoInscreverAves'];
}

$query = "INSERT INTO inscreverAves (idExposicao, stam, clube, seccao, classe, anilhaNum, ano, preco) values ";



if(isset($_SESSION["aves"])){
    $aves = $_SESSION['aves'];
    $avesLenght = count($aves);
    for($i = 0; $i< $avesLenght; $i++){
        $query .= '('. $idExposicao . ',"' . $stam . '", "' . $clube . '", "' . $aves[$i][0] . '", ' . $aves[$i][1] . ', ' . $aves[$i][2] . ', ' . $aves[$i][3];

        if($aves[$i][4] != 'NaN'){
            $query .= "," . $aves[$i][4];
        }
        else{
            $query .= ", NULL"; 
        }

        $query .= ') ';
        
        if($i < $avesLenght - 1){
            $query .= ",";
        }


    }
}


if($stmt = @mysqli_query($dbc, $query)) {
    

	unset($_SESSION['aves']);
	unset($_SESSION['tableAves']);


    ?>
    <script type="text/javascript">location.href = 'registoSucesso.php';</script>
    <?php
}

else {
	echo "nao deu insercao";
}


?>

<script type="text/javascript">
    console.log("deu daqui");
</script>
