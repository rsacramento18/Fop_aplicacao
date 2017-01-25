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
	<?php
	if(isset($_POST['stam'], $_POST['clube'], $_POST['dataDe'], $_POST['dataAte'], $_POST['valorApagar'], $_POST['preco'])){

		$stam = $_POST['stam'];
		$clube = $_POST['clube'];
		$dataDe = $_POST['dataDe'];
		$dataAte = $_POST['dataAte'];
		$valorApagar = $_POST['valorApagar'];
		$preco = $_POST['preco'];

		$dataCorrente = date("Y-m-d");

		$query = "UPDATE quotas SET valido='Passado' WHERE stam = '$stam' AND clube = '$clube' AND valido = 'Actual'";
		if ($update_stmt = mysqli_prepare($dbc, $query)){
			mysqli_stmt_execute($update_stmt);
			$affected_rows = mysqli_stmt_affected_rows($update_stmt);
			if ($affected_rows == 1) {
				$query = "INSERT INTO quotas (stam, clube, dataDe, dataAte, precoQuota, valorPago, dataDoPagamento) VALUES ('$stam', '$clube', '$dataDe', '$dataAte', '$preco', '$valorApagar', '$dataCorrente')";

				if($stmt = @mysqli_query($dbc, $query)) {

					echo "<h1>Quota Paga com sucesso</h1>";
					echo "<form action='listagemQuotas.php' id='listagemFormQuotas' method='post' name='listagem_form' target='_blank'>";
					echo "<input type='hidden' name='stam' value='$stam'></input> ";
					echo "<input type='hidden' name='clube' value='$clube'></input> ";
					echo "<input type='submit' value='Ver Recibo' name='verReciboQuotaBT'></input>";
					echo "</form>";
				}
				else{
					echo "<h1>Houve um problema no pagamento das quotas 2. Tente novamente</h1>";
				}     
			}
			else{
				$query = "INSERT INTO quotas (stam, clube, dataDe, dataAte, precoQuota, valorPago, dataDoPagamento) VALUES ('$stam', '$clube', '$dataDe', '$dataAte', '$preco', '$valorApagar', '$dataCorrente')";

				if($stmt = @mysqli_query($dbc, $query)) {

					echo "<h1>Quota Paga com sucesso</h1>";
					echo "<form action='listagemQuotas.php' id='listagemFormQuotas' method='post' name='listagem_form' target='_blank'>";
					echo "<input type='hidden' name='stam' value='$stam'></input> ";
					echo "<input type='hidden' name='clube' value='$clube'></input> ";
					echo "<input type='submit' value='Ver Recibo' name='verReciboQuotaBT'></input>";
					echo "</form>";
				}
				else{
					echo "<h1>Houve um problema no pagamento das quotas 2. Tente novamente</h1>";
				}     
			} 
		} 

	}
	?>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>