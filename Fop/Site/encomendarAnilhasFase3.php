<?php include ("header.php"); ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<h1>Anilhas - Encomendar</h1>
	<script type="text/javascript">
		var custoTotal= 10;
	</script>
	<?php
	if(isset($_SESSION['anilhasUser'])){

		$row =  $_SESSION['anilhasUser']; 
		$stam = $row['stam'];
		echo "<div id=\"divDadosSocio\"> ";
		echo "<h2>Dados do Socio</h2>";
		echo "<table>";
		echo "<tr><th>Stam</th><td>" . $row['stam'] . "</td></tr>";
		echo "<tr><th>Nome</th><td>" . $row['nome'] . "</td></tr>";
		echo "<tr><th>Email</th><td>" . $row['email'] . "</td></tr>";
		echo "<tr><th>Bi/Cu</th><td>" . $row['bi'] . "</td></tr>";
		echo "<tr><th>País</th><td>" . $row['pais'] . "</td></tr>";
		echo "<tr><th>Região</th><td>" . $row['regiao'] . "</td></tr>";
		echo "<tr><th>Morada</th><td>" . $row['morada'] . "</td></tr>";
		echo "<tr><th>Código Postal</th><td>" . $row['cod_postal'] . "</td></tr>";
		echo "<tr><th>Localidade</th><td>" . $row['Localidade'] . "</td></tr>";
		echo "<tr><th>Telefone 1</th><td>" . $row['telefone1'] . "</td></tr>";
		echo "<tr><th>Telefone 2</th><td>" . $row['telefone2'] . "</td></tr>";
		echo "</table></br>";
		

		if($_POST['clubeSelecionado']!=""){
			echo "<table id='tableCartaoFop'><tr><th>Clube</th><td>" . $_POST['clubeSelecionado'].
			"</td></tr></table>";
			$_SESSION['clubeSelecionado'] = $_POST['clubeSelecionado'];
		}
		else {
			echo "<table id='tableCartaoFop'><tr><th>Clube</th><td>" . $_SESSION['clube'].
			"</td></tr></table>";
		}
		echo "</div>";
	}
	else {
		echo "nao funcionou";
	}
	if (isset($_POST['count']) && isset($_POST['pagamentoCartaoFop']) ) {
		$count = $_POST['count'];
		$pagamentoCartaoFop = $_POST['pagamentoCartaoFop'];
		
		$query = "SELECT pedidoNum from pedidoEmVigor where id = 1";
		$vagaNum = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$vagaNum =  $row['pedidoNum'];
		}

		$opcao = array();
		$medida = array();
		$quantidade = array();
		$custos = array();
		$num = 1;
		for($x = 0; $x<$count; $x++){
			if(isset($_POST['opcao'.$num])){
				$opcao[$x] = $_POST['opcao'.$num];
				$num++;
			}
			else{
				echo "nao deu";
			}
		}
		$num = 1;
		for($x = 0; $x<$count; $x++){
			if(isset($_POST['medida'.$num])){
				$medida[$x] = $_POST['medida'.$num];
				$num++;
			}
		}
		$num = 1;
		for($x = 0; $x<$count; $x++){
			if(isset($_POST['input'.$num])){
				$quantidade[$x] = filter_input(INPUT_POST, 'input'.$num, FILTER_SANITIZE_NUMBER_INT);
				$num++;
			}
		}
		$_SESSION['opcao'] = $opcao;
		$_SESSION['medida'] = $medida;
		$_SESSION['quantidade'] = $quantidade;

		$custoNormal = 0.40;
		$custoReforçada = 0.55;
		$custoAco_Inox = 0.70;

		$query = "SELECT preco from anilhasPrecos where id = 1";
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$custoNormal =  $row['preco'];
		}

		$query = "SELECT preco from anilhasPrecos where id = 2";
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$custoReforçada =  $row['preco'];
		}

		$query = "SELECT preco from anilhasPrecos where id = 3";
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$custoAco_Inox =  $row['preco'];
		}


		$custoTotal = 0;
		echo "<div id='divEncomendasSocio'>";
		echo "<h2>Encomendas do Socio</h2>";
		echo "<table>";
		echo "<tr><th>Opção</th><th>Medida</th><th>Quantidade</th><th>Custo</th></tr>";
		for($x=0; $x < $count; $x++){
			$opcaoAux = $opcao[$x];
			$medidaAux = $medida[$x];
			$quantidadeAux = $quantidade[$x];
			echo "<tr><td>" . $opcaoAux . "</td>";
			echo "<td>" . number_format((float)$medidaAux, 1, '.', ''). "</td>";
			echo "<td>" . $quantidadeAux . "</td>";
			if($opcaoAux=="Normal"){		
				$custoTotal = $custoTotal + $quantidadeAux * $custoNormal;
				$custos[$x] = $quantidadeAux * $custoNormal;
				$custoAux = $quantidadeAux * $custoNormal;
				$custoAux = number_format((float)$custoAux, 2, '.', '');
				echo "<td>" . $custoAux . "&euro;</td></tr>";
			}
			else if($opcaoAux=="Reforçada"){
				$custoTotal = $custoTotal + $quantidadeAux * $custoReforçada;
				$custos[$x] = $quantidadeAux * $custoReforçada;
				$custoAux = $quantidadeAux * $custoReforçada;
				$custoAux = number_format((float)$custoAux, 2, '.', '');
				echo "<td>" . $custoAux . "&euro;</td></tr>";
			}
			else if($opcaoAux=="Aço/Inox"){
				$custoTotal = $custoTotal + $quantidadeAux * $custoAco_Inox;
				$custos[$x] = $quantidadeAux * $custoAco_Inox;
				$custoAux = $quantidadeAux * $custoAco_Inox;
				$custoAux = number_format((float)$custoAux, 2, '.', '');
				echo "<td>" . $custoAux . "&euro;</td></tr>";			
			}
			echo "<br/>";
		}
		echo "</table><br/>";
		$_SESSION['custos'] = $custos;
		$_SESSION['count'] = $count;
		$_SESSION['pagamentoCartaoFop'] = $pagamentoCartaoFop;
		if(isset($_POST['pagamentoPortes'])){
			$_SESSION['pagamentoPortes']= "Sim";
		}
		else {
			$_SESSION['pagamentoPortes']= "Não";
		}

		$query = "SELECT preco from anilhasPrecos where id = 4";
		$precoCartaoFop = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$precoCartaoFop =  $row['preco'];
		}
		
		if($pagamentoCartaoFop == 'Sim'){
			echo "<table id='tableTotalCustos'><tr><th>Cartao FOP</th><td>" . number_format((float)$precoCartaoFop, 2, '.', '') . "&euro;</td></tr>";
		}
		else {
			echo "<table id='tableTotalCustos'>";
		}

		if(isset($_SESSION['clube'])){
			$clubeSocio = $_SESSION['clube'];
		}
		

		if(isset($_POST['pagamentoPortes'])){
			$query = "SELECT precoPortes from clubes where nome_clube = '$clubeSocio' LIMIT 1";
			$precoPortes = 0;
			if($stmt = @mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($stmt);
				$precoPortes =  $row['precoPortes'];
			}
			echo "<tr><th>Portes</th><td>" . number_format((float)$precoPortes, 2, '.', '') . "&euro;</td></tr>";
		}
		else {
			echo "<table id='tableTotalCustos'>";
		}
		if($vagaNum == 6){
			$query = "SELECT preco from anilhasPrecos where id = 5";
			$preco6Pedido = 0;
			if($stmt = @mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($stmt);
				$preco6Pedido =  $row['preco'];
			}			
			echo "<tr><th>Custo adicional pedido 6</th><td>" . number_format((float)$preco6Pedido, 2, '.', '') . "&euro;</td></tr></table><br/>";
		}
		else {
			echo "</table><br/>";
		}

		echo "<table id='tableTotalCustos'><tr><th>Custo Total da Encomenda</th><td>";
		if($pagamentoCartaoFop == 'Sim' && isset($_POST['pagamentoPortes']) && $vagaNum == 6){
			echo $custoTotal+$precoCartaoFop+$precoPortes+$preco6Pedido . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Sim' && !(isset($_POST['pagamentoPortes'])) && $vagaNum == 6){
			echo $custoTotal+$precoCartaoFop+$preco6Pedido . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Sim' && isset($_POST['pagamentoPortes']) && $vagaNum != 6){
			echo $custoTotal+$precoPortes+$precoCartaoFop . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Sim' && !(isset($_POST['pagamentoPortes'])) && $vagaNum != 6){
			echo $custoTotal+$precoCartaoFop . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Não' && isset($_POST['pagamentoPortes']) && $vagaNum == 6){
			echo $custoTotal+$precoPortes+$preco6Pedido . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Não' && isset($_POST['pagamentoPortes']) && $vagaNum != 6){
			echo $custoTotal+$precoPortes . "&euro;</td></tr></table>";
		}
		else if($pagamentoCartaoFop == 'Não' && !(isset($_POST['pagamentoPortes'])) && $vagaNum == 6){
			echo $custoTotal+$preco6Pedido . "&euro;</td></tr></table>";
		}
		else {
			echo number_format((float)$custoTotal, 2, '.', '') . "&euro;</td></tr></table>";
		}
		echo "</div>";

	}else {
		echo "nao deu";
	}	
	?>
	<div id='encomendarAnilhasBt'>
		<input type="button"  size="5" value="Proceder Encomenda" onclick='window.location="encomendarAnilhasFase4.php";' />
	</div>
</div>
<?php include ("footer.php"); ?>