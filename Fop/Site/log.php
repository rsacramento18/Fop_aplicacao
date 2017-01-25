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
	<h1>Actividade de Contas</h1>
	<div id="logDiv">
		<?php

		$query = "SELECT * FROM `log` ORDER BY id DESC LIMIT 50";
		$stmt = @mysqli_query($dbc, $query);
		if($stmt) {

			echo "<table>";

			echo "<tr><th>Conta de Utilizador</th><th>Acção</th><th>Data e Hora</th></tr>";

			while($row = mysqli_fetch_array($stmt)) {

				echo "<tr><td>" . $row['user']."</td><td> ". $row['accao']. "</td><td>". $row['dateTime'] . "</td></tr>";
				
			}
			echo "</table>";
		}

		?>
	</div>
</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>