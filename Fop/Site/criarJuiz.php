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
			<span>Nome Conta</span><input type="text" name="userJuiz" id="userJuiz" size="48" placeholder="User"/><br/>
			<span>Nome Juiz</span><input type="text" name="nomeJuiz" id="nomeJuiz" size="50" placeholder="Nome"/><br/>
			<span>Foto </span><input type="file" name="foto" id="foto"/><br/> 
			<span>Email </span><input type="email" name="emailJuiz" id="emailJuiz" size="48" placeholder="Email"/><br/>
			<span>Bi/CC</span><input type="number" name="biJuiz" id="biJuiz" size="48" placeholder="BI/CC"/><br/>
			<span>Pais </span><input type="text" name="paisJuiz" id="paisJuiz" size="48" placeholder="Pais"/><br/>
			<span>Regiao </span><input type="text" name="regiaoJuiz" id="regiaoJuiz" size="48" placeholder="Regiao"/><br/>
			<span>Morada </span><input type="text" name="moradaJuiz" id="moradaJuiz" size="48" placeholder="Morada"/><br/>
			<span>Codigo Postal</span><input type="text" name="cod_postalJuiz" id="cod_postalJuiz" size="48" placeholder="Codigo Postal"/><br/>
			<span>Localidade </span><input type="text" name="LocalidadeJuiz" id="LocalidadeJuiz" size="48" placeholder="Localidade"/><br/>
			<span>Telefone 1</span><input type="number" name="telefone1Juiz" id="telefone1Juiz" size="48" placeholder="Telefone 1"/><br/>
			<span>Telefone 2</span><input type="number" name="telefone2Juiz" id="telefone2Juiz" size="48" placeholder="Telefone 2"/><br/>
            <span>Password</span><input type="text" name="password" size="30"  id="password" placeholder="Password" /><br/>
			<span>Confirmar Pass</span><input type="text" name="confirmpwd" id="confirmpwd" size="30"  placeholder="Confirm Password" /><br />
                    
    
            <input type="button" name="BtCriarJuiz" id="BtCriarJuiz" value="Criar Juiz" onclick="return regformhashJuiz(this.form,
						this.form.userJuiz,
						this.form.nomeJuiz,
						this.form.emailJuiz,
						this.form.biJuiz,
						this.form.paisJuiz,
						this.form.regiaoJuiz,
						this.form.moradaJuiz,
						this.form.cod_postalJuiz,
						this.form.LocalidadeJuiz,
						this.form.telefone1Juiz,
						this.form.telefone2Juiz,
						this.form.password,
						this.form.confirmpwd,
						this.form.privilegio,
						this.form.clubes);"/> 

		</form>
	</div>
	<script type="text/javascript">

	</script>

<?php endif;?>
<?php include ("footer.php"); ?>
