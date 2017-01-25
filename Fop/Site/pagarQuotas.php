<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p> " . $_SESSION['user'] . " - " . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<script type="text/javascript">
			function mostrarPagarQuotasDiv(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'pagarQuotasDetalhado.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#pagarQuotasDiv").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
		</script>
		<h1>Pagar Quotas</h1>
		<div id="divGestaoQuotas">
			<div id="pagarQuotasDiv">
				
			</div>
			<div id='aPagarQuotas'>
				<?php

				$clube = $_SESSION['clube'];

				$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num, novaQuotas.dataAte FROM socios INNER JOIN socios_clubes on socios.stam=socios_clubes.stam INNER JOIN (select * from quotas ORDER BY stam, idQuota DESC) as novaQuotas on novaQuotas.stam = socios_clubes.stam WHERE socios_clubes.clube = '$clube' AND (novaQuotas.valido = 'Actual' OR novaQuotas.valido = 'Joia') Group by socios.stam";

				$validarQuota = date('Y-m');

				if($stmt = @mysqli_query($dbc, $query)) {
					while($row = mysqli_fetch_array($stmt)){

						$dataSocio = $row['dataAte'];

						$dataAte = date("Y-m",strtotime($dataSocio));

						if($validarQuota == $dataAte){
							echo "<div class='associadoQuadrado' style='border: 2px solid #B3AB00;'>";
							echo "<p class='num_membro'>". $row['membro_num'] ."</p>";
							echo "<ul>";
							echo "<li>". $row['stam'] ."</li>";
							echo "<li>". $row['nome'] ."</li>";
							echo "</ul>";
							echo "</div>";
						}
						else if($validarQuota > $dataAte){
							echo "<div class='associadoQuadrado' style='border: 2px solid #810101;'>";
							echo "<p class='num_membro'>". $row['membro_num'] ."</p>";
							echo "<ul>";
							echo "<li>". $row['stam'] ."</li>";
							echo "<li>". $row['nome'] ."</li>";
							echo "</ul>";
							echo "</div>";
						}
					}
				}


				?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('#aPagarQuotas').on("click", ".associadoQuadrado", function(){
			var quadrado = this.getElementsByTagName('ul')[0];
			var membro = quadrado.getElementsByTagName('li')[0];
			document.getElementById('pagarQuotasDiv').style.borderBottom = '1px solid #810101'; 
			mostrarPagarQuotasDiv(membro.innerHTML);
			$('html, body').animate({scrollTop: $("#loggado").offset().top}, 1000);
		});

	</script>

<?php endif;?>

<?php include ("footer.php");