<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<?php
		if(isset($_SESSION['biNovo'])){
			$bi = $_SESSION['biNovo'];
		}
		?>
		<script type="text/javascript">
			jQuery(function($) {
				var bi = "<?php echo $bi; ?>";
				document.getElementById('bi').value = bi;
			});

		</script>
		<h1>Novo Registo</h1>
		<div id="formEditarRegisto">
			<form action="novoRegisto.inc.php" method="post" id="editarRegisto_socio">
				<input type="text" placeholder="Nome Completo" name="nome" size="50" id="nome" />
				<span class="labels2">Inserir nome completo</span><br/>
				<input type="email" placeholder="Email - Opcional" size="50" name="email" id="email"/>
				<span class="labels2">Inserir o Email - Campo Opcional</span><br/>
				<input type="text" placeholder="Bi/CC" size="50" name="bi" id="bi" />
				<span class="labels2">Inserir Bilhete Identidade ou Cartão de Cidadão</span><br/>
				<input type="text" placeholder="País" size="50" name="pais" id="pais" />
				<span class="labels2">Inserir o País</span><br/>
				<input type="text" placeholder="Região" size="50" name="regiao" id="regiao" />
				<span class="labels2">Inserir a Região</span><br/>
				<input type="text" placeholder="Morada" size="50" name="morada" id="morada" />
				<span class="labels2">Inserir a Morada</span><br/>
				<input type="text" placeholder="Código Postal" size="50" name="cod_postal" id="cod_postal" />
				<span class="labels2">Inserir Código Postal</span><br/>
				<input type="text" placeholder="Localidade" size="50" name="Localidade" id="Localidade" />
				<span class="labels2">Inserir a Localidade</span><br/>
				<input type="text" placeholder="Telefone - Opcional" size="50" name="telefone1" id="telefone1" />
				<span class="labels2">Inserir Telefone - Campo Opcional</span><br/>
				<input type="text" placeholder="Telemóvel" size="50" name="telefone2" id="telefone2" />
				<span class="labels2">Inserir Telemóvel</span><br/>
				<input type="submit" value="Inserir Novo Registo"/>
			</form>
		</div>
	</div>
<?php endif;?>

<?php include ("footer.php"); ?>