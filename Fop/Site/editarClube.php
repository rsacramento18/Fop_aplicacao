<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$clubeEscolhido = ($_POST['source1']);

	$query = "SELECT nome_clube, sigla, morada, imagem, site, email FROM clubes WHERE nome_clube = '$clubeEscolhido'";

	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		
		
		echo "<img style='width:160px; height:200px; ' src=".$row['imagem']. " alt='".$row['sigla']."'/>";
		echo "<div id='divEditarClube'>";
		echo "<table id='editarClubeTable'>";				
		echo "<tr><th>Sigla</th><td>".$row['sigla']."</td></tr>";
		echo "<tr><th>Nome Clube</th><td>".$row['nome_clube']."</td></tr>";
		echo "<tr><th>Morada</th><td>".$row['morada']."</td></tr>"; 
		echo "<tr><th>Site</th><td>".$row['site']."</td></tr>";
		echo "<tr><th>Email</th><td>".$row['email']."</td></tr>";
		echo "</table>";
		echo "</div>";
	}

}
else {
	echo "nao deu";
}


?>
