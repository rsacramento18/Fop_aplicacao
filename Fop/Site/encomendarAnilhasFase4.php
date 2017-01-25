<?php include ("header.php"); ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<h1>Anilhas - Encomendar</h1>    
	<div id="encomendaEfectuada">
		
		<?php
		if(isset($_SESSION['anilhasUser']) && isset($_SESSION['opcao']) && 
			isset($_SESSION['medida']) && isset($_SESSION['quantidade']) && 
			isset($_SESSION['custos']) && isset($_SESSION['count']) && 
			isset($_SESSION['pagamentoCartaoFop']) && isset($_SESSION['pagamentoPortes'])){

			$anilhasUser = $_SESSION['anilhasUser'];
		$count = $_SESSION['count'];
		$opcao = $_SESSION['opcao'];
		$medida = $_SESSION['medida'];
		$quantidade = $_SESSION['quantidade'];
		$custos = $_SESSION['custos'];
		$cartaoFop = $_SESSION['pagamentoCartaoFop'];
		$portes = $_SESSION['pagamentoPortes'];

		$stam = $anilhasUser['stam'];


		$query = "SELECT pedidoNum from pedidoEmVigor where id = 1";
		$vagaNum = 1;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$vagaNum =  $row['pedidoNum'];
		}

		if(isset($_SESSION['clubeSelecionado'])){
			$clubeNomeSocio = $_SESSION['clubeSelecionado'];
		}
		else{
			$clubeNomeSocio = $_SESSION['clube'];
		}

		$query = "SELECT sigla from clubes where nome_clube = '$clubeNomeSocio'";
		$clubeSocio = 1;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$clubeSocio =  $row['sigla'];
		}

		$cartaoFopPrimeiraVez = 1;
		$sucesso = 1;
		for($x=0; $x < $count; $x++){

			$opcaoAux = $opcao[$x];
			$medidaAux = $medida[$x];
			$quantidadeAux = $quantidade[$x];
			$custoAux = $custos[$x];

			$query="SELECT socios.stam, max(encomendasAnilhas.numFim) as numFim, count(encomendasAnilhas.stam) as numPedido 
			FROM socios
			left join encomendasAnilhas ON encomendasAnilhas.stam=socios.stam
			WHERE socios.stam = '$stam' and vagaNum = '$vagaNum'";

			$stmt = @mysqli_query($dbc, $query);

			if($stmt){

				$row = mysqli_fetch_array($stmt);

				
				if($row['numPedido'] >= 1){

					$numInicio = $row['numFim'] + 1;
					$numFim = $numInicio + ($quantidadeAux-1);
					$numPedido = $row['numPedido']+1;

					$query2 = "INSERT INTO encomendasAnilhas ( stam, clube, opcao, medida, quantidade, 
					numInicio, numFim, numPedido, vagaNum, custo, cartaoFopPago, portesPagos) 
					VALUES ( '$stam', '$clubeSocio', '$opcaoAux', '$medidaAux', '$quantidadeAux', '$numInicio', '$numFim',
					'$numPedido', $vagaNum, $custoAux, '$cartaoFop', '$portes')";
					if($stmt2 = @mysqli_query($dbc, $query2)) {
						if($sucesso == 1){
							echo"<h2>Encomenda Efectuada com sucesso!</h2>";
							$sucesso = 0;
						}
						if($cartaoFop=="Sim" && $cartaoFopPrimeiraVez == 1){

							$query = "SELECT validoDurante from validarCartaoFop where id = 1";
							$validade = 0;
							if($stmt = @mysqli_query($dbc, $query)) {
								$row = mysqli_fetch_array($stmt);
								$validade =  $row['validoDurante'];
							}

							$query = "SELECT cartaoFop from socios where stam = '$stam'";
							$data = date("Y");

							$dataUpdate = $data + $validade;
							$query = "UPDATE socios set cartaoFop = '$dataUpdate' 
							where socios.stam = '$stam'";
							if($stmt = @mysqli_query($dbc, $query)) {
								$cartaoFopPrimeiraVez = 0;
							}
							else {
								echo "fail update cartao fop";
							}
						}
					}
					else{
						echo  "nao deu";
					}
				}
				else {
					if($vagaNum>1){
						$vagaAnterior="";
						$query = "SELECT MAX(VagaNum) as vagaAnterior from encomendasanilhas where stam = '$stam' ";
						$stmt = @mysqli_query($dbc, $query);
						if($stmt){
							$row = mysqli_fetch_array($stmt);
							$vagaAnterior = $row['vagaAnterior'];

						}
						$query="SELECT socios.stam, max(encomendasAnilhas.numFim) as numFim, count(encomendasAnilhas.stam) as numPedido 
						FROM socios
						left join encomendasAnilhas ON encomendasAnilhas.stam=socios.stam
						WHERE socios.stam = '$stam' and vagaNum = '$vagaAnterior'";

						$stmt = @mysqli_query($dbc, $query);
						
						if($stmt){
							$row = mysqli_fetch_array($stmt);

							$numInicio = $row['numFim'] + 1;
							$numFim = $numInicio + ($quantidadeAux-1);

						}

						$query2 = "INSERT INTO encomendasAnilhas ( stam, clube, opcao, medida, quantidade, 
						numInicio, numFim, numPedido, vagaNum, custo, cartaoFopPago, portesPagos) 
						VALUES ( '$stam', '$clubeSocio','$opcaoAux', '$medidaAux', '$quantidadeAux', $numInicio, '$numFim',1, $vagaNum, $custoAux, '$cartaoFop', '$portes')";
					}
					else {

						$query2 = "INSERT INTO encomendasAnilhas ( stam, clube, opcao, medida, quantidade, 
						numInicio, numFim, numPedido, vagaNum, custo, cartaoFopPago, portesPagos) 
						VALUES ( '$stam', '$clubeSocio' ,'$opcaoAux', '$medidaAux', '$quantidadeAux', 1, '$quantidadeAux',1, $vagaNum, $custoAux, '$cartaoFop', '$portes')";

					}
					
					if($stmt2 = @mysqli_query($dbc, $query2)) {
						if($sucesso == 1){
							echo"<h2>Encomenda Efectuada com sucesso!</h2>";
							$sucesso = 0;
						}
						if($cartaoFop=="Sim" && $cartaoFopPrimeiraVez == 1){

							$query = "SELECT validoDurante from validarCartaoFop where id = 1";
							$validade = 0;
							if($stmt = @mysqli_query($dbc, $query)) {
								$row = mysqli_fetch_array($stmt);
								$validade =  $row['validoDurante'];
							}

							$data = date("Y");
							$dataUpdate = $data + $validade;
							$query = "UPDATE socios set cartaoFop = '$dataUpdate' 
							where socios.stam = '$stam'";
							if($stmt = @mysqli_query($dbc, $query)) {
								$cartaoFopPrimeiraVez = 0;
							}
							else {
								echo "fail update cartao fop";
							}
						}
					}
					else{
						echo  "nao deu da primeira vez";
					}
				}
				
			}
			else{
				echo "nao deu";
			}
		}
		unset($_SESSION['anilhasUser']);
		unset($_SESSION['count']);
		unset($_SESSION['opcao']);
		unset($_SESSION['medida']);
		unset($_SESSION['quantidade']);
		unset($_SESSION['custos']);
		unset($_SESSION['pagamentoCartaoFop']);
	}
	?>

	<input type='button'value='Voltar' onclick="document.location.href='encomendarAnilhasFase1.php';"/>
</div>
</div>
<?php include ("footer.php"); ?>