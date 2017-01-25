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

		$query = "SELECT COUNT(*) as count FROM quotas WHERE stam = '$stam' AND clube = '$clube'";
		if( $stmt = @mysqli_query($dbc, $query)){
			$row = mysqli_fetch_array($stmt);
			$rowCount = $row['count'];
			if($rowCount > 1){

				$query = "DELETE FROM quotas
							Where stam = '$stam' and clube= '$clube' AND valido = 'Actual'";
				if($stmt = @mysqli_query($dbc, $query)) {

					$query = "SELECT idQuota FROM quotas 
							WHERE stam = '$stam' AND clube = '$clube' ORDER BY idQuota DESC LIMIT 1";
					if($stmt = @mysqli_query($dbc, $query)){
						$row = mysqli_fetch_array($stmt);
						$idQuota = $row['idQuota'];

						if($rowCount > 2){
							$query = "UPDATE quotas SET valido = 'Actual' WHERE idQuota = '$idQuota'";
							if( $stmt = @mysqli_query($dbc, $query)){

								echo "<h1>Quota removida com sucesso</h1>";

							}
							else{
								echo "<h1>Erro 3</h1>";
							}
						}
						else{
							echo "<h1>Quota removida com sucesso</h1>";
						}
					}
					else{
						echo "<h1>Erro 2</h1>";
					}
				}
				else{
					echo "<h1>Erro 1</h1>";
				}
			}
			else if ($rowCount == 1){
				$query = "DELETE FROM quotas
							Where stam = '$stam' and clube= '$clube' AND valido = 'Joia'";
				if($stmt = @mysqli_query($dbc, $query)) {
					echo "<h1>Quota removida com sucesso</h1>";
				}
				else{
					echo "<h1>Erro 4</h1>";
				}
			}
		}
	}
	else{
		echo "<h1>Não há quotas para eliminar.</h1>";
	}
	?>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>
