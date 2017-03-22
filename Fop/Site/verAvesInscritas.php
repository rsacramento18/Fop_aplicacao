<?php include ('header.php'); ?>
<?php if (login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true ) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		
		<h1>Aves Inscritas</h1>
        
<?php
    $user = $_SESSION['user'];

    $query = "SELECT * FROM inscreverAves WHERE stam = '$user'";
    
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

        for ($i = 0; $i < $avesInscritasLenght;  $i++){
            $nomeExposicao = '';
            if($i == 0){
                $idExposicao = $avesInscritas[$i][1];
 
                $query2 = "SELECT * FROM exposicoes WHERE idExposicao = '$idExposicao'";
                $stmt = @mysqli_query($dbc, $query2);
                if($stmt) {
                    $row2 = mysqli_fetch_array($stmt);
                    $nomeExposicao = $row2['titulo'];

                }
            }
            else if( $idExposicao != $avesInscritas[$i][1] ){
                 $idExposicao = $avesInscritas[$i][1];
 
                $query2 = "SELECT * FROM exposicoes WHERE idExposicao = '$idExposicao'";
                $stmt = @mysqli_query($dbc, $query2);
                if($stmt) {
                    $row2 = mysqli_fetch_array($stmt);
                    $nomeExposicao = $row2['titulo'];

                }

            }

            echo "<h2>$nomeExposicao</h2>";

            if($avesInscritas[$i][5] % 2 == 0 && $j == 0){
                echo "<b>Singular----------------------</b>";
                $seccao = $avesInscritas[$i][4];
                $classe = $avesInscritas[$i][5];
                $anilhaNum = $avesInscritas[$i][6];
                $ano = $avesInscritas[$i][7];
                $preco = $avesInscritas[$i][8];
                echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>";
            }
            else{
                if($j == 0){
                    echo "<b>Equipa-----------------------</b>";
                }
                $seccao = $avesInscritas[$i][4];
                $classe = $avesInscritas[$i][5];
                $anilhaNum = $avesInscritas[$i][6];
                $ano = $avesInscritas[$i][7];
                $preco = $avesInscritas[$i][8];
                echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>";
                
                $j++;

                if( $j == 4 ) {
                    $j = 0;
                }

            }
        }

    }


?>



		<script type="text/javascript">
	
	    </script>

<?php endif;?>
<?php include ("footer.php"); ?>
