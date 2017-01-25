<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Verificar Bi/CC</h1>
		<div id="formEditarRegisto">
			<form action="verificarBi.inc.php" method="post" id="editarRegisto_socio">
				<input type="text" placeholder="Bi/CC" size="50" name="bi" id="bi" />
				<span class="labels2">Inserir Bilhete Identidade ou Cartão de Cidadão</span><br/>
				<input type="submit" value="Verificar Bi/CC"/>
			</form>
		</div>
	</div>
<?php endif;?>

<?php include ("footer.php"); ?>