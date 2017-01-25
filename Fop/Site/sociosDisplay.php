<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1']) && isset($_POST['source2']) && isset($_POST['source3'])){
	$campo = ($_POST['source1']);
	$input = $_POST['source2'];
	$checkbox = $_POST['source3'];
	echo "<p>Pesquisa feita com " . $campo . " - " . $input . "</p></br>";
	if($campo == 'nome'){
		$input = preg_replace('/\s+/', '%', $input);
	}
}

$query = "SELECT validoDurante from validarCartaoFop where id = 1";
$validadeCartaoFop = 0;
if($stmt = @mysqli_query($dbc, $query)) {
	$row = mysqli_fetch_array($stmt);
	$validadeCartaoFop =  $row['validoDurante'];
}

if(isset($_SESSION['privilegio'])){
	$privilegio = $_SESSION['privilegio'];
	if(isset($_SESSION['clube'])){
		$clube = $_SESSION['clube'];
	}
	if($checkbox == 0){
		if($privilegio == "clube"){
			$query = "SELECT socios_clubes.stam, nome, email, bi, pais, regiao, morada, cod_postal, Localidade, cartaoFop, telefone1, telefone2
			FROM socios
			RIGHT JOIN socios_clubes
			ON socios.stam=socios_clubes.stam 
			WHERE socios_clubes.clube = '$clube' 
			AND socios.$campo LIKE '%$input%' 
			LIMIT 1";        
		}
		else {
			$query = "SELECT stam, nome, email, bi, pais, regiao, morada, cod_postal, Localidade, cartaoFop, telefone1, telefone2
			FROM socios
			WHERE socios.$campo LIKE '%$input%' 
			LIMIT 1";
		}
	}
	else {
		if($privilegio == "clube"){
			$query = "SELECT socios_clubes.stam, nome
			FROM socios
			RIGHT JOIN socios_clubes
			ON socios.stam=socios_clubes.stam 
			WHERE socios_clubes.clube = '$clube' 
			AND socios.$campo LIKE '%$input%' ORDER BY $campo asc";        
		}
		else {
			$query = "SELECT stam, nome
			FROM socios
			WHERE socios.$campo LIKE '%$input%' ORDER BY $campo asc"; 
		}

	}

	if($checkbox == 0){
		
		$stmt = @mysqli_query($dbc, $query);
		if($stmt) {

			echo "<table>";

			$row = mysqli_fetch_array($stmt);
			$_SESSION['anilhasUser'] = $row; 

			echo "<tr><th>Stam</th><td>" . $row['stam'] . "</td></tr>";
			echo "<tr><th>Nome</th><td>" . $row['nome'] . "</td></tr>";
			echo "<tr><th>Email</th><td>" . $row['email'] . "</td></tr>";
			echo "<tr><th>Bi/CC</th><td>" . $row['bi'] . "</td></tr>";
			echo "<tr><th>País</th><td>" . $row['pais'] . "</td></tr>";
			echo "<tr><th>Região</th><td>" . $row['regiao'] . "</td></tr>";
			echo "<tr><th>Morada</th><td>" . $row['morada'] . "</td></tr>";
			echo "<tr><th>Código Postal</th><td>" . $row['cod_postal'] . "</td></tr>";
			echo "<tr><th>Localidade</th><td>" . $row['Localidade'] . "</td></tr>";
			echo "<tr><th>Telefone 1</th><td>" . $row['telefone1'] . "</td></tr>";
			echo "<tr><th>Telefone 2</th><td>" . $row['telefone2'] . "</td></tr>";
			
			echo "</table>";

			$cartaoSocio = $row['cartaoFop'];
			$cartaoSocioInicioValidade = $cartaoSocio - $validadeCartaoFop;

			if($cartaoSocioInicioValidade <= 0){
				echo "<table id='tableCartaoFop'><tr><th>Cartao FOP</th><td>Novo associado sem cartão FOP";
			}
			else {
				echo "<table id='tableCartaoFop'><tr><th>Cartao FOP</th><td>Validade " . $cartaoSocioInicioValidade. " / " . $row['cartaoFop'];

				if (validarCartao($dbc, $cartaoSocio)) {
					echo " - Necessita de Renovação";
				}else {
					echo " - Em dia"; 
				}
			}
			echo"</td></tr></table>";

		}
		else {
			echo "nao funcionou";
		}
	}
	else {
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
