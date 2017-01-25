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
		$row= $_SESSION['anilhasUser'];
		$stam = $row['stam'];
		$nome = $row['nome'];
		$email = $row['email'];
		$bi = $row['bi'];
		$pais = $row['pais'];
		$regiao= $row['regiao'];
		$morada = $row['morada'];
		$cod_postal = $row['cod_postal'];
		$Localidade = $row['Localidade'];
		$telefone1 = $row['telefone1'];
		$telefone2 = $row['telefone2'];

		?>
		<script type="text/javascript"> 
			jQuery(function($) {
				var stam = "<?php echo $stam; ?>";
				var nome = "<?php echo $nome; ?>";
				var email = "<?php echo $email; ?>";
				var bi = "<?php echo $bi; ?>";
				var pais = "<?php echo $pais; ?>";
				var regiao = "<?php echo $regiao; ?>";
				var morada = "<?php echo $morada; ?>";
				var cod_postal = "<?php echo $cod_postal; ?>";
				var Localidade = "<?php echo $Localidade; ?>";
				var telefone1 = "<?php echo $telefone1; ?>";
				var telefone2 = "<?php echo $telefone2; ?>";

				document.getElementById('stam').value = stam;
				document.getElementById('nome').value = nome;
				document.getElementById('email').value = email;
				document.getElementById('bi').value = bi;
				document.getElementById('pais').value = pais;
				document.getElementById('regiao').value = regiao;
				document.getElementById('morada').value = morada;
				document.getElementById('cod_postal').value = cod_postal;
				document.getElementById('Localidade').value = Localidade;
				document.getElementById('telefone1').value = telefone1;
				document.getElementById('telefone2').value = telefone2;
			});


		</script>
		<?php

		unset($_SESSION['anilhasUser']);

		?>
		<h1>Editar Registo</h1>
		<div id="formEditarRegisto">
			<form action="editarRegistoSocio.inc.php" method="post" id="editarRegisto_socio">
				<input type="text" placeholder="Stam" size="50" name="stam" id="stam" readonly="readonly" /><br/>
				<input type="text" placeholder="Nome Completo" name="nome" size="50" id="nome" />
				<span class="labels2">Inserir nome completo</span><br/>
				<input type="email" placeholder="Email - Campo Opcional" size="50" name="email" id="email"/>
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
				<input type="text" placeholder="Telefone - Campo Opcional" size="50" name="telefone1" id="telefone1" />
				<span class="labels2">Inserir Telefone - Campo Opcional</span><br/>
				<input type="text" placeholder="Telemóvel" size="50" name="telefone2" id="telefone2" />
				<span class="labels2">Inserir Telemóvel</span><br/>
				<input type="submit" value="Actualizar Registo"/>
			</form>
		</div>
	</div>
<?php endif;?>

<?php include ("footer.php"); ?>