<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$counter = $_POST['source1'];
	$query = "SELECT idFicha, nomeFicha FROM fichasJulgamento ORDER BY idFicha ASC LIMIT $counter,20";
	$max = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		
		while($row = mysqli_fetch_array($stmt)) {
			echo "<div class='fichaQuadrado'>";
			echo "<p class='id_ficha'>". $row['idFicha'] ."</p>";
			echo "<ul>";
			echo "<li>". $row['nomeFicha'] ."</li>";
			echo "</ul>";
			echo "</div>";
		}
		
	}
	else{
		echo "nao funcionou";
	}
}
else {
	echo "nao deu";
}
?>
