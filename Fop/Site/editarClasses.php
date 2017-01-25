<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Editar Classes</h1>
		<div id="editarClasses">
			<form id="editarClassesForm">
				
			</form>
		</div>
	</div>

<?php endif;?>
<?php include ("footer.php"); ?>