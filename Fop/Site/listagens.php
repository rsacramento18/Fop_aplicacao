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
		<h1>Listagens dos Pedidos</h1>
		<?php if( login_fop_check($dbc) == true) :?>
			<form action="exportarExel.php" method="post" name="exel_form" target="_blank">
				<h2>Exportar para excel um pedido.</h2>
				<select name="pedidoExportar">
					<option value="1">Pedido 1</option>
					<option value="2">Pedido 2</option>
					<option value="3">Pedido 3</option>
					<option value="4">Pedido 4</option>
					<option value="5">Pedido 5</option>
					<option value="6">Pedido 6</option>
				</select>
				<select name="tipoAnilha">
					<option value="Normal">Normal</option>
					<option value="Reforcada">Reforçada</option>
					<option value="Aco/Inox">Aço/Inox</option>
				</select>
				<input type="submit" value="Exportar Excel" id="exelBt" ></input>
			</form>
			<form action="listagemTodosCartoes.php" method="post" name="listagem_form " target="_blank">
				<h2>Listagens dos Cartões Fop</h2>
				<select name="pedidoExportar">
					<option value="1">Pedido 1</option>
					<option value="2">Pedido 2</option>
					<option value="3">Pedido 3</option>
					<option value="4">Pedido 4</option>
					<option value="5">Pedido 5</option>
					<option value="6">Pedido 6</option>
				</select>
				<input type="submit" value="Tirar Listagem" id="listagemBt" ></input>
			</form>
		<?php else : ?>
			<form action="listagemAnilhas.php" method="post" name="listagem_form" target="_blank">
				<h2>Exportar PDF para Conferência.</h2>
				<select name="pedidoExportar">
					<option value="1">Pedido 1</option>
					<option value="2">Pedido 2</option>
					<option value="3">Pedido 3</option>
					<option value="4">Pedido 4</option>
					<option value="5">Pedido 5</option>
					<option value="6">Pedido 6</option>
				</select>
				<select name="tipoAnilha">
					<option value="Normal">Normal</option>
					<option value="Reforcada">Reforçada</option>
					<option value="Aco/Inox">Aço/Inox</option>
				</select>
				<input type="submit" value="Tirar Listagem" id="listagemBt" ></input>
			</form>
			<form action="listagemCartaoFOP.php" method="post" name="listagem_form" target="_blank">
				<h2>Listagens dos Cartões Fop</h2>
				<select name="pedidoExportar">
					<option value="1">Pedido 1</option>
					<option value="2">Pedido 2</option>
					<option value="3">Pedido 3</option>
					<option value="4">Pedido 4</option>
					<option value="5">Pedido 5</option>
					<option value="6">Pedido 6</option>
				</select>
				<input type="submit" value="Tirar Listagem" id="listagemBt" ></input>
			</form>
			<form action="listagemCompleta.php" method="post" name="listagem_form" target="_blank">
				<h2>Recibos</h2>
				<select name="pedidoExportar">
					<option value="1">Pedido 1</option>
					<option value="2">Pedido 2</option>
					<option value="3">Pedido 3</option>
					<option value="4">Pedido 4</option>
					<option value="5">Pedido 5</option>
					<option value="6">Pedido 6</option>
				</select>
				<input type="submit" value="Tirar Listagem" id="listagemBt" ></input>
			</form>
		<?php endif;?>
	</div>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>