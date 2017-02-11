<?php include ('header.php'); ?>
<?php if (login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true ) : ?>
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
			            url: 'inscreverAves.php', //assumes file is in root dir//
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
                $stam = $_SESSION['user'];
                
                $query = "SELECT COUNT(*) as counter socios_clubes WHERE stam = '$stam'";
                $maxClubes = 0;
                if($stmt = @mysqli_query($dbc, $query)) {
                    $row = mysqli_fetch_array($stmt);
                    $maxClubes = $row['counter'];
                }

                
                $query = "SELECT clube FROM socios_clubes WHERE stam = '$stam' ";
                $queryExposicao = "SELECT * from exposicoes where ( ";
                
                $counter =0;
                if($stmt = @mysqli_query($dbc, $query)) {
					while($row = mysqli_fetch_array($stmt)){
                        $clube = $row['clube'];
                        $queryExposicao .= "(clube1 = '$clube' OR clube2 = '$clube' OR clube3 = '$clube' OR clube4 = '$clube' OR clube5 = '$clube')";
                        if($counter< $maxClubes){
                            $queryExposicao .= "OR";
                        }
                        else{
                            $queryExposicao .= ")";
                        }
                        $counter++;
                    }
                }

				$dataCorrente = date('Y-m-d');

				if($stmt = @mysqli_query($dbc, $queryExposicao)) {
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

                echo "<form action='inscreverAves.php' method='post' id='inscreverAvesForm' name='formInscreverAves'>";
                    echo "<input type='hidden' name='source1' id='hiddenInscreverAves'/>";
                echo "</form>";

				?>
            </div>
            
		</div>

	</div>
	<script type="text/javascript">
		$('#todasExposicoes').on("click", ".exposicaoQuadrado", function(){
			var quadrado = this.getElementsByTagName('div')[1];
			var membro = quadrado.getElementsByTagName('p')[0];
            var form = document.getElementById('inscreverAvesForm');
            var hidden = document.getElementById('hiddenInscreverAves');
            hidden .value = membro.innerHTML;
            form.submit();

		});

	</script>

<?php endif;?>
<?php include ("footer.php"); ?>
