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
	<div id="listagensPedidos">
		<h1>Exportar Base de Dados Socios</h1>
		<form action="exportarExcelCompleto.php" method="post" name="exel_form">
			<h2>Exportar Base de Doados para excel.</h2></br>
			<input type="submit" value="Exportar Excel" id="exelBt" ></input>
		</form>
	</div>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>