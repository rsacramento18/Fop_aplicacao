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
	<h1>Anilhas - Encomendar</h1>
	<?php
	$pedidoEmVigor = $_SESSION['pedidoEmVigor'];
	echo "<h3>O pedido em vigor é $pedidoEmVigor<h3>";
	?>
	<form action="encomendarAnilhasFase2.php" method="post" name="registration_form">
		<p>Inserir dados do sócio</p>
	</br>
	<input type="text" name="input" size="30"  id="input"/>
	<select name="campo">
		<option value="stam">Stam</option>
		<option value="nome">Nome</option>
		<option value="email">email</option>
		<option value="bi">Bi/Cu</option>
	</select>
	<input type="submit" value="Pesquisar Sócio" name"pesquiSocio"></input>
</form>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>