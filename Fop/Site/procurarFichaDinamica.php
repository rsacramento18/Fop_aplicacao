<?php
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

  if(isset($_POST['source1'])){
	$input = $_POST['source1'];
    
	if(preg_match('/\s/',$input) > 0){
		$input = explode(' ', $input);

		$query = "SELECT idFicha,nomeFicha FROM fichasJulgamento 
			  WHERE idFicha = '$input' 
			  OR (nomeFicha LIKE  '%$input[0]%' AND nomeFicha LIKE '%$input[1]%') 
			  ORDER BY idFicha ASC LIMIT 0,20";
	}
	else{
		$query = "SELECT idFicha,nomeFicha FROM fichasJulgamento 
			  WHERE (idFicha = '$input' 
			  OR nomeFicha LIKE  '%$input%')
			  ORDER BY idFicha ASC LIMIT 0,20";
	}
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
	  echo "nao deu";
	}

  }
  else{
	echo "nao deu nada";
  }

?>
