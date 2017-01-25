<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_SESSION['privilegio'])){
	$privilegio = $_SESSION['privilegio'];
	if(isset($_SESSION['clube'])){
		$clube = $_SESSION['clube'];
	}
	if(isset($_POST['source1'])){
		$counter = $_POST['source1'];
		
		if($privilegio == "clube"){
			$query = "SELECT *
			FROM socios
			INNER JOIN socios_clubes
			ON socios.stam=socios_clubes.stam 
			WHERE socios_clubes.clube = '$clube' ORDER BY socios.stam asc 
			LIMIT $counter,20"; 
				//LIMIT o primeiro a aparecer, quantidade(20)       
		}
		
		$stmt = @mysqli_query($dbc, $query);
		if($stmt) {

			echo "<table>";

			while($row = mysqli_fetch_array($stmt)) {

				echo "<tr><th>" . $row['stam'] . "</th>";
				echo "<td>" . $row['nome'] . "</td></tr>";
			}
			echo "</table>";
		}
		else {
			echo "nao funcionou com counter";
		}
	}
	else {
		if($privilegio == "clube"){
			$query = "SELECT *
			FROM socios
			INNER JOIN socios_clubes
			ON socios.stam=socios_clubes.stam 
			WHERE socios_clubes.clube = '$clube' ORDER BY socios.stam asc 
			LIMIT 0,20"; 
				//LIMIT o primeiro a aparecer, quantidade(20)       
		}
		
		$stmt = @mysqli_query($dbc, $query);
		if($stmt) {

			echo "<table>";

			while($row = mysqli_fetch_array($stmt)) {

				echo "<tr><th>" . $row['stam'] . "</th>";
				echo "<td>" . $row['nome'] . "</td></tr>";
			}
			echo "</table>";
		}
		else {
			echo "nao funcionou";
		}
	}
}
?>
