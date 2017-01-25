<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p> " . $_SESSION['user'] . " - " . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<?php
		$clube = $_SESSION['clube']; 
		$query = "SELECT count(*) as maxNumber from socios INNER JOIN socios_clubes
		ON socios.stam=socios_clubes.stam 
		WHERE socios_clubes.clube = '$clube'";
		$max = 0;
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$max =  $row['maxNumber'];
		}
		?>
		<script type="text/javascript">
			function getNext(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'gestaoClube.inc.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#divAssociados").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}

			function membroDetalhado(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'pagarQuotasDetalhado.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#membroDetalhado").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
			var max = <?php echo json_encode($max); ?>;
			max = parseInt(max);
		</script>
		<h1>Gestão de Associados</h1>
		<div id="gestaoClube">

			<div id="membroDetalhado">
			</div>
			<div id="buttons">
				<input type='button' value='anterior <' id='btRetroceder'/>
				<input type="text" name="procurarNoClube" id="procurarNoClube" placeholder="Pesquisar"/>
				<input type='button' value='> seguinte' id='btAvancar'/>
			</div>

			<div id="divAssociados">
				<?php
				$clube = $_SESSION['clube']; 
				$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios INNER JOIN socios_clubes
				ON socios.stam=socios_clubes.stam 
				WHERE socios_clubes.clube = '$clube'
				ORDER BY membro_num ASC LIMIT 0,20";
				$max = 0;
				if($stmt = @mysqli_query($dbc, $query)) {
					
					while($row = mysqli_fetch_array($stmt)) {
						echo "<div class='associadoQuadrado'>";
						echo "<p class='num_membro'>". $row['membro_num'] ."</p>";
						echo "<ul>";
						echo "<li>". $row['stam'] ."</li>";
						echo "<li>". $row['nome'] ."</li>";
						echo "</ul>";
						echo "</div>";
					}
					
				}
				else{
					echo "nao funcionou";
				}
				?>
			</div>
		</div>
		<script type="text/javascript">
			var counter = 0;

			var btRetroceder = document.getElementById('btRetroceder');
			var btAvancar = document.getElementById('btAvancar');

			btRetroceder.onclick = function () {
				if(counter >= 20){
					counter -= 20;
					document.getElementById('divAssociados').innerHTML = "";
					getNext(counter);
				}
			};

			btAvancar.onclick = function() {
				if(counter+20 < max){
					counter += 20;
					document.getElementById('divAssociados').innerHTML = "";
					getNext(counter);
				}
				
			};

			$('#divAssociados').on("click", ".associadoQuadrado", function(){
				var quadrado = this.getElementsByTagName('ul')[0];
				var membro = quadrado.getElementsByTagName('li')[0];
				console.log(membro.innerHTML);
				document.getElementById('membroDetalhado').style.borderBottom = '1px solid #810101'; 
				membroDetalhado(membro.innerHTML);
				$('html, body').animate({scrollTop: $("#loggado").offset().top}, 1000);
			});

			$('#buttons').on("input", "#procurarNoClube", function(){
				var divAssociados = document.getElementById('divAssociados');
				divAssociados.innerHTML = '';

				if(this.value ==''){
					<?php

					$inner = "";

					$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios INNER JOIN socios_clubes
					ON socios.stam=socios_clubes.stam 
					WHERE socios_clubes.clube = '$clube'
					ORDER BY membro_num ASC LIMIT 0,20";
					$max = 0;
					if($stmt = @mysqli_query($dbc, $query)) {
						
						while($row = mysqli_fetch_array($stmt)) {
							$inner .= "<div class='associadoQuadrado'>";
							$inner .= "<p class='num_membro'>". $row['membro_num'] ."</p>";
							$inner .= "<ul>";
							$inner .= "<li>". $row['stam'] ."</li>";
							$inner .= "<li>". $row['nome'] ."</li>";
							$inner .= "</ul>";
							$inner .= "</div>";
						}
					}
					else{
						echo "nao funcionou";
					}
					?>
					var inner = "<?php echo "$inner" ?>";
					divAssociados.innerHTML = inner;
				}
				else{
					str1 = this.value;
					$(function() {
				        $.ajax({
				            type: 'post',
				            url: 'procurarAssociadoDinamico.php', //assumes file is in root dir//
				            data: {source1: str1},
				            success: function(response) {
				                $("#divAssociados").html(response); //inserts echoed data into div//
				            }
				        });
				    });
				}
			});

		</script>
	</div>

<?php endif;?>

<?php include ("footer.php");