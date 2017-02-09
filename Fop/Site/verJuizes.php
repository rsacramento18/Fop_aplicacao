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
		$query = "SELECT count(*) as maxNumber from juizes ";
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
			            url: 'verJuizes.inc.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#divJuizes").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}

			function juizDetalhado(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'juizDetalhado.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#juizDetalhado").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
			var max = <?php echo json_encode($max); ?>;
			max = parseInt(max);
		</script>
		<h1>Ver Juizes</h1>
		<div id="gestaoJuiz">

			<div id="juizDetalhado">
			</div>
			<div id="buttons">
				<input type='button' value='anterior <' id='btRetroceder'/>
				<input type="text" name="procurarJuiz" id="procurarJuiz" placeholder="Pesquisar"/>
				<input type='button' value='> seguinte' id='btAvancar'/>
			</div>

			<div id="divJuizes">
				<?php
				$query = "SELECT  nome, idJuiz from juizes ORDER BY idJuiz ASC LIMIT 0,20";
				$max = 0;
				if($stmt = @mysqli_query($dbc, $query)) {
					
					while($row = mysqli_fetch_array($stmt)) {
						echo "<div class='juizQuadrado'>";
						echo "<p class='id_juiz'>". $row['idJuiz'] ."</p>";
						echo "<ul>";
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
					document.getElementById('divJuizes').innerHTML = "";
					getNext(counter);
				}
			};

			btAvancar.onclick = function() {
				if(counter+20 < max){
					counter += 20;
					document.getElementById('divJuizes').innerHTML = "";
					getNext(counter);
				}
				
			};

			$('#divJuizes').on("click", ".juizQuadrado", function(){
				var quadrado = this.getElementsByTagName('ul')[0];
				var juiz = this.getElementsByTagName('p')[0];
				console.log(juiz.innerHTML);
				document.getElementById('juizDetalhado').style.borderBottom = '1px solid #810101'; 
				juizDetalhado(juiz.innerHTML);
				$('html, body').animate({scrollTop: $("#loggado").offset().top}, 1000);
			});

			$('#buttons').on("input", "#procurarJuiz", function(){
				var divJuizes = document.getElementById('divJuizes');
				divJuizes.innerHTML = '';

				if(this.value ==''){
					<?php

					$inner = "";

					$query = "SELECT nome, idJuiz from juizes ORDER BY idJuiz ASC LIMIT 0,20";
					$max = 0;
					if($stmt = @mysqli_query($dbc, $query)) {
						
						while($row = mysqli_fetch_array($stmt)) {
							$inner .= "<div class='juizQuadrado'>";
							$inner .= "<p class='id_juiz'>". $row['idJuiz'] ."</p>";
							$inner .= "<ul>";
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
					divJuizes.innerHTML = inner;
				}
				else{
					str1 = this.value;
					$(function() {
				        $.ajax({
				            type: 'post',
				            url: 'procurarJuizDinamico.php', //assumes file is in root dir//
				            data: {source1: str1},
				            success: function(response) {
                                $("#divJuizes").html(response); //inserts echoed data into div//
				            }
				        });
				    });
				}
			});

		</script>
	</div>

<?php endif;?>

<?php include ("footer.php");
