<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_SESSION['clube'], $_POST['source1'])){
	$counter = $_POST['source1'];
	$clube = $_SESSION['clube']; 
	$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios INNER JOIN socios_clubes
	ON socios.stam=socios_clubes.stam 
	WHERE socios_clubes.clube = '$clube'
	ORDER BY membro_num ASC LIMIT $counter,20";
	$max = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		
		while($row = mysqli_fetch_array($stmt)) {
			echo "<div class='associadoQuadrado'>";
			echo "<p class='num_membro'>". $row['membro_num'] ."</p>";
			echo "<ul>";
			echo "<li>". $row['stam'] ."</li>";
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