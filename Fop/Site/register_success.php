<?php include ("header.php"); ?>
<?php
if (login_check($dbc) == true) : ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<h1>Registo efectuado com sucesso!</h1>
	<p>Agora pode voltar para a  <a href="home.php">Home Page</a></p>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>