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
	<?php
	if(isset($_POST['stam'], $_POST['clube'])){
		$stam = $_POST['stam'];
		$clube = $_POST['clube'];
		
		$query = "DELETE FROM socios_clubes
					Where stam = '$stam' AND clube= '$clube'";
		if($stmt = @mysqli_query($dbc, $query)) {
			echo "<h1>Associado removido do clube com sucesso</h1>";
		}
		else{
			echo "<h1>Erro 4</h1>";
		}
	}
	?>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>
