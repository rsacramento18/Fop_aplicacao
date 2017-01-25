<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p> " . $_SESSION['user'] . " - " . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Pesquisar Socios por Clube</h1>
		<div id="sociosDiv">
			<?php if( login_fop_check($dbc) == true) :?>
				<form >
					<h2>Pesquisar por: </h2>
					<select name="campoClube" id="campoClube">
						<?php getClubes($dbc)?>	
					</select>
					<input type="button" value="Ver Clube" name"pesquiSocio" 
					onclick="editarClube(this.form.campoClube)"></input>
				</form>
				
			<?php else : include_once 'editarClube.php';?>

			<?php endif;?>
		</div>
		<div id="sociosClubeDisplay">
		</div>
	</div>

<?php endif;?>

<?php include ("footer.php"); ?>