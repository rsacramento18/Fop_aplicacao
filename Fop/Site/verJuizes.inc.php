<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$counter = $_POST['source1'];

	$query = "SELECT idJuiz, nome from juizes
	ORDER BY idJuiz ASC LIMIT $counter,20";
	$max = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		
		while($row = mysqli_fetch_array($stmt)) {
			echo "<div class='juizQuadrado'>";
			echo "<p class='id_juiz'>". $row['idJuiz'] ."</p>";
			echo "<ul>";
			echo "<li>". $row['nome'] ."</li>";
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
