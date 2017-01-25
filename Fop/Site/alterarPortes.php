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
	<h1>Alterar Portes</h1>
	<div id="divPortes">
		<?php
		if(isset($_POST['portesClube'])){
			$portesPreco = $_POST['portesClube'];
			$clube = $_SESSION['clube'];
			$query = "UPDATE clubes SET precoPortes = '$portesPreco' where nome_clube = '$clube'";
		}
		if($stmt = @mysqli_query($dbc, $query)) {
			echo "<h2>Portes alterados com sucesso!</h2>";
		}

		?>
		<input type='button'value='Voltar' onclick="document.location.href='encomendarAnilhasFase1.php';"/>
	</div>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>