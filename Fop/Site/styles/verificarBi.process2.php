<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
<div class="wrapper-content">
	<div id="loggado">
	            <?php 
	                echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
	                echo "<p>" . $_SESSION['clube'] . "</p>";
	            ?>
	</div>
	<script type="text/javascript">

		var btVoltar = document.getElementById('botaoVoltar');

		btVoltar.onclick = function(){
			location.href = 'verificarBi.php';
		};

		var btAdicionar = document.getElementById('botaoAdicionar');

		btAdicionar.onclick = function(){
			location.href = 'novoRegisto.php';
		};

	</script>
	<h1>Verificar Bi/CC</h1>
	<div id="formEditarRegisto">
		<h3>Atençao</h3>
		<p>O BI/CC não foi encontrado na base de dados. Se o associado já existir na base dados carregue no botão voltar para tentar novamente. Se tiver a certeza que o associado não consta na na base de dados carregue no botão adicionar novo utilizador.</p>
		<b>Nota: </b><p>Se o numero de BI/CC comecar com um numero diferente de 0 tente outra vez adicionando 0 no início do número. Caso contrário remova o zero e tente novamente</p>

		<input type="button" value="Voltar" id="botaoVoltar" />
		<input type="button" value="Adicionar Novo Utilizador" id="botaoAdicionar"/>
	</div>
</div>
<?php endif;?>

<?php include ("footer.php"); ?>