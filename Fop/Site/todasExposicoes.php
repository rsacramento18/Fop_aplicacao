<?php include ('header.php'); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<script type="text/javascript">
			function exposicaoSelecionadaFunction(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'exposicaoDetalhada.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#exposicaoSelecionada").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
		</script>

		<h1>Ver Exposições</h1>

		<div id="exposicoes">
			<div id="exposicaoSelecionada">
				
			</div>
			<div id='todasExposicoes'>
				<?php

				$clube = $_SESSION['clube'];

				if( login_fop_check($dbc) == true) {
					$query = "SELECT * from exposicoes";
				}
				else {
					$query = "SELECT * from exposicoes where (clube1 = '$clube' OR clube2 = '$clube'
					OR clube3 = '$clube' OR clube4 = '$clube' OR clube5 = '$clube') ";
				}
				

				$dataCorrente = date('Y-m-d');

				if($stmt = @mysqli_query($dbc, $query)) {
					while($row = mysqli_fetch_array($stmt)){

						$dataFim = $row['dataFim'];

						if($dataCorrente < $dataFim || $dataFim == '0000-00-00'){
							echo "<div class='exposicaoQuadrado'>";
								echo "<div id='imgExposicao'>";
									echo "<img src=".$row['logo']. " alt='logo' height='120' width='120'/>";
								echo "</div>";

								echo "<div id='conteudoExposicao'>";
									echo "<p style='display: none'>" . $row['idExposicao'] . "</p>";
									echo "<p class='titulo'>". $row['titulo'] ."</p>";
									echo "<ul>";
									echo "<li>Morada&nbsp;&nbsp;&nbsp;". $row['morada'] ."</li>";
									echo "<li id='dataInicio'>Inicio&nbsp;&nbsp;&nbsp;". $row['datainicio'] ."</li>";
									echo "<li id='dataFim'>Fim&nbsp;&nbsp;&nbsp;". $row['dataFim'] ."</li>";
									echo "<li>Tipo Exposição&nbsp;&nbsp;&nbsp;". $row['tipoExposicao'] ."</li>";
									echo "</ul>";
								echo "</div>";
							echo "</div>";
						}
					}
				}


				?>
			</div>
		</div>

	</div>
	<script type="text/javascript">
		$('#todasExposicoes').on("click", ".exposicaoQuadrado", function(){
			var quadrado = this.getElementsByTagName('div')[1];
			var membro = quadrado.getElementsByTagName('p')[0];
			document.getElementById('exposicaoSelecionada').style.borderBottom = '1px solid #810101'; 
			exposicaoSelecionadaFunction(membro.innerHTML);
			$('html, body').animate({scrollTop: $("#loggado").offset().top}, 1000);
		});

	</script>

<?php endif;?>
<?php include ("footer.php"); ?>
