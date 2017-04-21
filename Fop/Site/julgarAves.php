<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$idExposicao= $_POST['source1'];
}

echo "<div id='julgarAvesDiv'>";


$user = $_SESSION['user'];
    if($_SESSION['options'] == 1){
        $query = "SELECT * FROM inscreverAves WHERE idExposicao = '$idExposicao' ORDER BY seccao, classe, stam";
    }
    else {
        $query = "SELECT * FROM inscreverAves WHERE idExposicao = '$idExposicao' ORDER BY seccao, classe, stam";
    }
    $stmt = @mysqli_query($dbc, $query);
    if($stmt) {


        $avesInscritas = array();
        $i = 0;

        while ( $row = mysqli_fetch_array($stmt)){
            $avesInscritas[$i][0] = $row['idAveInscrita'];
            $avesInscritas[$i][1] = $row['idExposicao'];
            $avesInscritas[$i][2] = $row['stam'];
            $avesInscritas[$i][3] = $row['clube'];
            $avesInscritas[$i][4] = $row['seccao'];
            $avesInscritas[$i][5] = $row['classe'];
            $avesInscritas[$i][6] = $row['anilhaNum'];
            $avesInscritas[$i][7] = $row['ano'];
            $avesInscritas[$i][8] = $row['preco'];
            $i++;
        } 
        

        $avesInscritasLenght = count($avesInscritas);

        $j = 0;
        
        if($_SESSION['options']==1){
            $seccao = $avesInscritas[0][4];
            echo "<div class='avesBox' id='box$seccao'>";
                echo "<p>$seccao</p>";
            echo "</div>";
            for ($i = 0; $i < $avesInscritasLenght;  $i++){
                if($seccao != $avesInscritas[$i][4]){
                    $seccao = $avesInscritas[$i][4];
                    echo "<div class='avesBox' id='box$seccao'>";
                        echo "<p>$seccao</p>";
                    echo "</div>";

                }
            }
        }
        
                /* if($avesInscritas[$i][5] % 2 == 0 && $j == 0){ */
                /*     echo "<b>Singular----------------------</b>"; */
                /*     $seccao = $avesInscritas[$i][4]; */
                /*     $classe = $avesInscritas[$i][5]; */
                /*     $anilhaNum = $avesInscritas[$i][6]; */
                /*     $ano = $avesInscritas[$i][7]; */
                /*     $preco = $avesInscritas[$i][8]; */
                /*     echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>"; */
                /* } */
                /* else{ */
                /*     if($j == 0){ */
                /*         echo "<b>Equipa-----------------------</b>"; */
                /*     } */
                /*     $seccao = $avesInscritas[$i][4]; */
                /*     $classe = $avesInscritas[$i][5]; */
                /*     $anilhaNum = $avesInscritas[$i][6]; */
                /*     $ano = $avesInscritas[$i][7]; */
                /*     $preco = $avesInscritas[$i][8]; */
                /*     echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>"; */
                
                /*     $j++; */

                /*     if( $j == 4 ) { */
                /*         $j = 0; */
                /*     } */

                /* } */
            /* } */
            /* } */
        /* } */

    }
    else{
        echo "erro na query";
    }
echo "</div>";

?>

<script type="text/javascript">

$('#todasExposicoes').on("click", ".exposicaoQuadrado", function(){
    

}
	
</script>

