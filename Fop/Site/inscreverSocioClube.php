<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Inscrever um associado noutro Clube</h1>
		<div id='inscreverDadosSocio'>
			<?php
			$query = "SELECT validoDurante from validarCartaoFop where id = 1";
			$validadeCartaoFop = 0;
			if($stmt = @mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($stmt);
				$validadeCartaoFop =  $row['validoDurante'];
			}


			$stam = $_SESSION['stamExistente'];
			$query = "SELECT socios.stam, socios.nome, socios.email, socios.bi,
			socios.pais, socios.regiao, socios.morada, socios.cod_postal,
			socios.Localidade, socios.telefone1, socios.telefone2,socios.cartaoFop
			FROM socios
			WHERE socios.stam = '$stam'
			Limit 1";
			if($stmt = @mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($stmt);
				if($row['stam']!=''){
					echo "<div id=\"divDadosSocio\"> ";
					echo "<h2>Dados do Socio</h2>";
					echo "<table>";
					echo "<tr><th>Stam</th><td>" . $row['stam'] . "</td></tr>";
					echo "<tr><th>Nome</th><td>" . $row['nome'] . "</td></tr>";
					echo "<tr><th>Email</th><td>" . $row['email'] . "</td></tr>";
					echo "<tr><th>Bi/CC</th><td>" . $row['bi'] . "</td></tr>";
					echo "<tr><th>País</th><td>" . $row['pais'] . "</td></tr>";
					echo "<tr><th>Região</th><td>" . $row['regiao'] . "</td></tr>";
					echo "<tr><th>Morada</th><td>" . $row['morada'] . "</td></tr>";
					echo "<tr><th>Código Postal</th><td>" . $row['cod_postal'] . "</td></tr>";
					echo "<tr><th>Localidade</th><td>" . $row['Localidade'] . "</td></tr>";
					echo "<tr><th>Telefone 1</th><td>" . $row['telefone1'] . "</td></tr>";
					echo "<tr><th>Telefone 2</th><td>" . $row['telefone2'] . "</td></tr>";
					echo "</table><br/>";

					$cartaoSocio = $row['cartaoFop'];
					$cartaoSocioInicioValidade = $cartaoSocio - $validadeCartaoFop;

					if($cartaoSocioInicioValidade <= 0){
						echo "<table id='tableCartaoFop'><tr><th>Cartao FOP</th><td>Novo associado sem cartão FOP";
					}
					else {
						echo "<table id='tableCartaoFop'><tr><th>Cartao FOP</th><td>Validade " . $cartaoSocioInicioValidade. " / " . $row['cartaoFop'];

						if (validarCartao($dbc, $cartaoSocio)) {
							echo " - Necessita de Renovação";
						}else {
							echo " - Em dia"; 
						}
					}
					echo"</td></tr></table>";
					echo "<input type='button'value='Voltar' onclick=\"document.location.href='home.php'\"/>";
					echo "</div>";
				}
			}
			?>
		</div>
		<div id="sociosDiv">
			<?php if( login_fop_check($dbc) == true) :?>
				<form action="inscreverSocioClube.inc.php" method="POST">
					<h2>Clube a inscrever o associado: </h2>
					<select name="campoClube" id="campoClube">
						<?php getClubes($dbc)?>	
					</select>
					<input type='hidden' value=<?php echo "'".$row['stam']."'";?> name="stamExistente" id="stamExistente">
					<input type="submit" value="Inscrever Associoado no Clube" name"pesquiSocio"/>
				</form>
				
			<?php else :?>
				<form action="inscreverSocioClube.inc.php" method="POST">
					<?php echo $_SESSION['clube'];?>
					<input type='hidden' value=<?php echo "'".$row['stam']."'";?> name="stamExistente" id="stamExistente">
					<input type="submit" value="Inscrever Associado no Clube" name="pesquiSocio"/>
				</form>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>

<?php include ("footer.php"); ?>