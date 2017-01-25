<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p> " . $_SESSION['user'] . " - " . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Pesquisar Associado</h1>
		<div id="sociosDiv">
			<form >
				<h2>Pesquisar por: </h2>
				<select name="campo">
					<option value="stam">Stam</option>
					<option value="nome">Nome</option>
					<option value="email">Email</option>
					<option value="bi">Bi/Cu</option>
					<option value="telefone1">Telefone 1</option>
					<option value="telefone2">Telefone 2</option>
				</select>
				<input type="text" name="input" size="30"  id="input"/>
				<input type="hidden" name="count" id="count" value="1"/> 
				<input type="button" value="Pesquisar Sócio" name"pesquiSocio" 
				onclick="showSocios(
					this.form.campo, 
					this.form.input)"/>
					<input type="button" value="Limpar Pesquisa" name"limparDiv" 
					onclick="limparDiv()"/><br/>
					<div class="squaredTwo2">
						<span>Procurar Todos</span>				
						<input type="checkbox" value="1" id="squaredTwo2" name="check" />
						<label for="squaredTwo2"></label>
					</div>
					<input type='button' id='alterarSocioBt' value='Alterar Ficha do Associado' onclick= "self.location='editarRegistoSocio.php'"/>
				</form>
			</div>
			<div id="sociosDisplay">
			</div>
		</div>

	<?php endif;?>

	<?php include ("footer.php"); ?>