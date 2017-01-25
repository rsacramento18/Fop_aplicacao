<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset ($_POST['source1'])){

	$listagem = $_POST['source1'];
	$clube = $_SESSION['clube'];

	if($listagem == '1'){
		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num 
				FROM socios 
				INNER JOIN socios_clubes ON socios.stam = socios_clubes.stam 
				WHERE socios_clubes.clube = '$clube' ORDER BY socios_clubes.membro_num ASC";
		if($stmt = @mysqli_query($dbc, $query)) {
			echo "<table id='listagensClubeTable'>";
			echo "<tr><th>Associado No.</th><th>Nome</th><th>Stam</th></tr>";

			while($row = mysqli_fetch_array($stmt)){
				echo "<tr><td>".$row['membro_num']."</td><td>".$row['nome']."</td><td>".$row['stam']."</td></tr>";
			}
			echo "</table>";
		}

	}
	else if($listagem == '2'){
		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num 
				FROM socios 
				INNER JOIN socios_clubes ON socios.stam = socios_clubes.stam 
				WHERE socios_clubes.clube = '$clube' ORDER BY socios.nome ASC";
		if($stmt = @mysqli_query($dbc, $query)) {
			echo "<table id='listagensClubeTable'>";
			echo "<tr><th>Nome</th><th>Associado No.</th><th>Stam</th></tr>";

			while($row = mysqli_fetch_array($stmt)){
				echo "<tr><td>".$row['nome']."</td><td>".$row['membro_num']."</td><td>".$row['stam']."</td></tr>";
			}
			echo "</table>";
		}

	}
	else if ($listagem == '3'){
		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num, quotas.dataAte
				FROM socios 
				INNER JOIN socios_clubes on socios.stam=socios_clubes.stam
				INNER JOIN quotas on quotas.stam = socios_clubes.stam
				WHERE socios_clubes.clube = '$clube' AND (quotas.valido = 'Actual')";

		$validarQuota = date('Y-m');

		if($stmt = @mysqli_query($dbc, $query)) {

			echo "<table id='listagensClubeTable'>";
			echo "<tr><th>Associado No.</th><th>Nome</th><th>Stam</th></tr>";

			while($row = mysqli_fetch_array($stmt)){

				$dataSocio = $row['dataAte'];

				$dataAte = date("Y-m",strtotime($dataSocio));

				if($validarQuota > $dataAte){
					echo "<tr><td>".$row['membro_num']."</td><td>".$row['nome']."</td><td>".$row['stam']."</td></tr>";
				}
			}
			echo "</table>";
		}
	}
	else if ($listagem == '4'){
		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num, quotas.dataAte
				FROM socios 
				INNER JOIN socios_clubes on socios.stam=socios_clubes.stam
				INNER JOIN quotas on quotas.stam = socios_clubes.stam
				WHERE socios_clubes.clube = '$clube' AND (quotas.valido = 'Actual' OR quotas.valido = 'Joia')";

		$validarQuota = date('Y-m');

		if($stmt = @mysqli_query($dbc, $query)) {

			echo "<table id='listagensClubeTable'>";
			echo "<tr><th>Associado No.</th><th>Nome</th><th>Stam</th></tr>";

			while($row = mysqli_fetch_array($stmt)){

				$dataSocio = $row['dataAte'];

				$dataAte = date("Y-m",strtotime($dataSocio));

				if($validarQuota == $dataAte){
					echo "<tr><td>".$row['membro_num']."</td><td>".$row['nome']."</td><td>".$row['stam']."</td></tr>";
				}
			}
			echo "</table>";
		}
	}
}

?>