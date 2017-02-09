<?php include ('header.php'); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Criar Juiz</h1>
		<form method="post" action="criarJuiz.inc.php" id="formCriarJuiz" enctype="multipart/form-data">
			<span>Nome Juiz</span><input type="text" name="nomeJuiz" id="nomeJuiz" size="50"/><br/>
			<span>Foto </span><input type="file" name="foto" id="foto"/><br/> 
			<span>Email </span><input type="email" name="emailJuiz" id="emailJuiz" size="48"/><br/>
			<span>Bi/CC</span><input type="number" name="biJuiz" id="biJuiz" size="48"/><br/>
			<span>Pais </span><input type="text" name="paisJuiz" id="paisJuiz" size="48"/><br/>
			<span>Regiao </span><input type="text" name="regiaoJuiz" id="regiaoJuiz" size="48"/><br/>
			<span>Morada </span><input type="text" name="moradaJuiz" id="moradaJuiz" size="48"/><br/>
			<span>Codigo Postal</span><input type="text" name="cod_postalJuiz" id="cod_postalJuiz" size="48"/><br/>
			<span>Localidade </span><input type="text" name="LocalidadeJuiz" id="LocalidadeJuiz" size="48"/><br/>
			<span>Telefone 1</span><input type="number" name="telefone1Juiz" id="telefone1Juiz" size="48"/><br/>
			<span>Telefone 2</span><input type="number" name="telefone2Juiz" id="telefone2Juiz" size="48"/><br/>
                    
    
            <input type="submit" name="BtCriarJuiz" id="BtCriarJuiz" value="Criar Juiz" /> 

		</form>
	</div>
	<script type="text/javascript">

	</script>

<?php endif;?>
<?php include ("footer.php"); ?>
