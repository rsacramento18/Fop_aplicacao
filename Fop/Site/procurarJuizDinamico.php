<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

  if(isset($_POST['source1'])){
	$input = $_POST['source1'];

	if(preg_match('/\s/',$input) > 0){
		$input = explode(' ', $input);

		$query = "SELECT idJuiz, nome from juizes 
			  WHERE  (idJuiz = '$input[0]' 
			  OR (nome LIKE  '%$input[0]%' AND nome LIKE '%$input[1]%'))
			  ORDER BY idJuiz ASC LIMIT 0,20";
	}
	else{
		$query = "SELECT idJuiz, nome from juizes 
			  WHERE (idJuiz = '$input' 
			  OR nome LIKE  '%$input%')
			  ORDER BY idJuiz ASC LIMIT 0,20";
	}
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
	  echo "nao deu";
	}

  }
  else{
	echo "nao deu nada";
  }

?>
