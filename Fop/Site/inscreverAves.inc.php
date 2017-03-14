<?php 
include_once '../mysql_config.php';
include_once 'functions.php';
sec_session_start(); 

if(isset($_POST['clubeInscreverAves'],$_POST['stamInscreverAves'])){
    echo $_POST['clubeInscreverAves'];
    echo "</br>";
    echo$_POST['stamInscreverAves'];
    echo "</br>";
}



if(isset($_SESSION["aves"])){
    $aves = $_SESSION['aves'];
    $avesLenght = count($aves);
    for($i = 0; $i< $avesLenght; $i++){
        echo "linha $i ------------------------</br>";
        echo $aves[$i][0];
        echo "</br>";
        echo $aves[$i][1];
        echo "</br>";
        echo $aves[$i][2];
        echo "</br>";
        echo $aves[$i][3];
        echo "</br>";
        echo $aves[$i][4];
        echo "</br>";
    }
}


?>

<script type="text/javascript">
    console.log("deu daqui");
</script>
