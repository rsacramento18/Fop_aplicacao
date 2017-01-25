<?php include ("header.php"); ?>
<?php
if (login_check($dbc) == true) : ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<h1>Definições Anilhas</h1>
	<div id="precosAnilhas">
		<?php 
		$row = 0;

		$query = "SELECT id, ROUND(preco,2) as preco from anilhasPrecos";
		$stmt = @mysqli_query($dbc, $query);
		if($stmt){
			while($row = mysqli_fetch_array($stmt)) {
				$idPreco = $row['id'];
				$preco = $row['preco'];?>
				<script type="text/javascript">
					$(document).ready(function(){
						var idPreco = "<?php echo $idPreco; ?>";
						var preco = "<?php echo $preco; ?>";
						
						if(idPreco==1){
							document.getElementById('normal').value = preco;
						}
						else if(idPreco == 2){
							document.getElementById('reforcada').value = preco;
						}
						else if(idPreco == 3){
							document.getElementById('aco_inox').value = preco;
						}
						else if(idPreco == 4){
							document.getElementById('cartaoFop').value = preco;
						}
						else if(idPreco == 5){
							document.getElementById('6Pedido').value = preco;
						}

					});
				</script><?php
			}
		}

		$query = "SELECT quantidade from quantidadeMinima where id = 1";
		$quantidadeMinimaNormal = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$quantidadeMinimaNormal =  $row['quantidade'];
		}

		$query = "SELECT quantidade from quantidadeMinima where id = 2";
		$quantidadeMinimaReforcada = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$quantidadeMinimaReforcada =  $row['quantidade'];
		}

		$query = "SELECT quantidade from quantidadeMinima where id = 3";
		$quantidadeMinimaAco = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$quantidadeMinimaAco =  $row['quantidade'];
		}
		?>

		<script type="text/javascript">
			$(document).ready(function(){
				var quantidadeMinimaNormal = "<?php echo $quantidadeMinimaNormal; ?>";
				document.getElementById('quantidadeMinimaNormal').value = quantidadeMinimaNormal;

				var quantidadeMinimaReforcada = "<?php echo $quantidadeMinimaReforcada; ?>";
				document.getElementById('quantidadeMinimaReforcada').value = quantidadeMinimaReforcada;

				var quantidadeMinimaAco = "<?php echo $quantidadeMinimaAco; ?>";
				document.getElementById('quantidadeMinimaAco').value = quantidadeMinimaAco;

				$('#gravarNormal').on('click', function(){
					var validar = true;
					if($('#normal').val() === '' || isNaN($('#normal').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formNormal").submit();
					}
				});

				$('#gravarReforcada').on('click', function(){
					var validar = true;
					if($('#reforcada').val() === '' || isNaN($('#reforcada').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formReforcada").submit();
					}
				});

				$('#gravarAco_inox').on('click', function(){
					var validar = true;
					if($('#aco_inox').val() === '' || isNaN($('#aco_inox').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formAco_inox").submit();
					}
				});

				$('#gravar6Pedido').on('click', function(){
					var validar = true;
					if($('#6Pedido').val() === '' || isNaN($('#6Pedido').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("form6Pedido").submit();
					}
				});

				$('#gravarQuantidadeNormal').on('click', function(){
					var validar = true;
					if($('#quantidadeMinimaNormal').val() === '' || isNaN($('#quantidadeMinimaNormal').val())){
						alert('Valor introduzido na Quantidade Minima Normal está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formQuantidadeNormal").submit();
					}
				});

				$('#gravarQuantidadeReforcada').on('click', function(){
					var validar = true;
					if($('#quantidadeMinimaReforcada').val() === '' || isNaN($('#quantidadeMinimaReforcada').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formQuantidadeReforcada").submit();
					}
				});

				$('#gravarQuantidadeAco').on('click', function(){
					var validar = true;
					if($('#quantidadeMinimaAco').val() === '' || isNaN($('#quantidadeMinimaAco').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formQuantidadeAco").submit();
					}
				});

				$('#gravarCartaoFop').on('click', function(){
					var validar = true;
					if($('#cartaoFop').val() === '' || isNaN($('#cartaoFop').val())){
						alert('Valor introduzido na Quantidade Minima está incorreto')
						validar = false;
					}
					if(validar === true){
						alert("Valor Gravado");
						document.getElementById("formCartaoFop").submit();
					}
				});
			});

		</script>
		<form action="gravarPrecos.php" method="post" id="formNormal">
			<h2>Preco Anilhas Normais</h2><input type="text" name="normal" id="normal"/>
			<input type="button" id="gravarNormal" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formReforcada">
			<h2>Preco Anilhas Reforcadas</h2><input type="text" name="reforcada" id="reforcada"/>
			<input type="button" id="gravarReforcada" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formAco_inox">
			<h2>Preco Anilhas Aço/Inox</h2><input type="text" name="aco_inox" id="aco_inox"/>
			<input type="button" id="gravarAco_inox" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="form6Pedido">
			<h2>Preco Adicional do Pedido 6</h2><input type="text" name="6Pedido" id="6Pedido"/>
			<input type="button" id="gravar6Pedido" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formQuantidadeNormal">
			<h2>Quantidade minima Normal</h2><input type="text" name="quantidadeMinimaNormal" id="quantidadeMinimaNormal"/>
			<input type="button" id="gravarQuantidadeNormal" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formQuantidadeReforcada">
			<h2>Quantidade minima Reforcada</h2><input type="text" name="quantidadeMinimaReforcada" id="quantidadeMinimaReforcada"/>
			<input type="button" id="gravarQuantidadeReforcada" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formQuantidadeAco">
			<h2>Quantidade minima Aço/Inox</h2><input type="text" name="quantidadeMinimaAco" id="quantidadeMinimaAco"/>
			<input type="button" id="gravarQuantidadeAco" value="Gravar">
		</form>
		<form action="gravarPrecos.php" method="post" id="formCartaoFop">
			<h2>Preco Cartao FOP</h2><input type="text" name="cartaoFop" id="cartaoFop"/>
			<input type="button" id="gravarCartaoFop" value="Gravar">
		</form>

	</div>

</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>