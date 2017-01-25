<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

  if(isset($_POST['source1'])){
	$input = $_POST['source1'];
	$clube = $_SESSION['clube'];

	if(preg_match('/\s/',$input) > 0){
		$input = explode(' ', $input);

		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios 
			  INNER JOIN socios_clubes
			  ON socios.stam=socios_clubes.stam 
			  WHERE socios_clubes.clube = '$clube' 
			  AND (socios.stam LIKE '%$input[0]%' 
			  OR (socios.nome LIKE  '%$input[0]%' AND socios.nome LIKE '%$input[1]%') 
			  OR socios_clubes.membro_num = '$input[0]' )
			  ORDER BY membro_num ASC LIMIT 0,20";
	}
	else{
		$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios 
			  INNER JOIN socios_clubes
			  ON socios.stam=socios_clubes.stam 
			  WHERE socios_clubes.clube = '$clube' 
			  AND (socios.stam LIKE '%$input%' 
			  OR socios.nome LIKE  '%$input%' 
			  OR socios_clubes.membro_num = '$input' )
			  ORDER BY membro_num ASC LIMIT 0,20";
	}
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
	  echo "nao deu";
	}

  }
  else{
	echo "nao deu nada";
  }

?>