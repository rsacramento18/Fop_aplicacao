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
        while ( $row = mysqli_fetch_array($stmt)){
            $idExposicao = $row['idExposicao'];
            
            $query = "SELECT * FROM exposicoes WHERE idExposicao = '$idExposicao'";
            $nomeExposicao = '';
            $stmt = @mysqli_query($dbc, $query);
            if($stmt) {
                $row2 = mysqli_fetch_array($stmt);
                $nomeExposicao = $row2['titulo'];

            }

            echo "<h2>$nomeExposicao </h2>";

            while($idExposicao == $row['idExposicao']){
                $seccao = $row['seccao'];
                $classe = $row['classe'];
                $anilhaNum = $row['anilhaNum'];
                $ano = $row['ano'];
                $preco = $row['preco'];
                echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>"; 

                $row = mysqli_fetch_array($stmt);
            }

        }
    }


?>



		<script type="text/javascript">
	
	    </script>

<?php endif;?>
<?php include ("footer.php"); ?>
