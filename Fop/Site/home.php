<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true || login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Esta e a Home Page</h1>
	</div>

<?php endif;?>
<?php include ("footer.php"); ?>
