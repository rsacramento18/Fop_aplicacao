<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p> " . $_SESSION['user'] . " - " . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Alterar dados do Clube</h1>
		<div id="alterarDadosClubeDiv">
			<form action="" id="alterarDadosClubeForm" method="POST" >
	        	<input type="text" name="sigla" id="sigla" placeholder="Sigla" value=""></input>
	        	<span class="labels2">Inserir nova sigla para o Clube.</span><br/>
	        	<input type="text" name="nome_clube" id="nome_clube" placeholder="Nome do Clube" value=""></input>
	        	<span class="labels2">Inserir novo nome para o Clube.</span><br/>
	        	<input type="text" name="morada_clube" id="morada_clube" placeholder="Morada do Clube" value=""></input>
	        	<span class="labels2">Inserir nova morada para o Clube.</span><br/>
	        	<input type="email" name="email" id="email" placeholder="Email do Clube" value=""></input>
	        	<span class="labels2">Inserir novo email para o clube.</span><br/>
	        	<input type="file" name="image" />
	        	<input type="submit"/>
	    	</form>		
		</div>
	</div>

<?php endif;?>

<?php include ("footer.php"); ?>