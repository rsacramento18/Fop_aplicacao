<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Registo Inserido com Sucesso</h1>
		<input type='button' value='Voltar' onclick="document.location.href='home.php'"/>

	</div>
<?php endif;?>

<?php include ("footer.php"); ?>