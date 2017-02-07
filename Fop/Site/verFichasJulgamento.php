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
		$query = "SELECT count(*) as maxNumber from fichasJulgamento";
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
			                $("#divFichasJulgamento").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}

			function fichaDetalhada(str1) {
				$(function() {
					$.ajax({
						type: 'post',
			            url: 'fichaDetalhada.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#fichaDetalhada").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
			var max = <?php echo json_encode($max); ?>;
			max = parseInt(max);
		</script>
		<h1>Gestão de Fichas de Julgamento</h1>
		<div id="gestaoFichaJulgamento">

			<div id="fichaDetalhada">
			</div>
			<div id="buttons">
				<input type='button' value='anterior <' id='btRetroceder'/>
				<input type="text" name="procurarFichas" id="procurarFichas" placeholder="Pesquisar"/>
				<input type='button' value='> seguinte' id='btAvancar'/>
			</div>

			<div id="divFichasJulgamento">
				<?php
				$query = "SELECT idFicha,nomeFicha FROM fichasJulgamento ORDER BY idFicha ASC LIMIT 0,20";
				$max = 0;
				if($stmt = @mysqli_query($dbc, $query)) {
					
					while($row = mysqli_fetch_array($stmt)) {
						echo "<div class='fichaQuadrado'>";
						echo "<p class='id_ficha'>". $row['idFicha'] ."</p>";
						echo "<ul>";
						echo "<li>". $row['nomeFicha'] ."</li>";
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
					document.getElementById('divFichasJulgamento').innerHTML = "";
					getNext(counter);
				}
			};

			btAvancar.onclick = function() {
				if(counter+20 < max){
					counter += 20;
					document.getElementById('divFichasJulgamento').innerHTML = "";
					getNext(counter);
				}
				
			};

			$('#divFichasJulgamento').on("click", ".fichaQuadrado", function(){
				var quadrado = this.getElementsByTagName('ul')[0];
				var ficha = this.getElementsByTagName('p')[0];
				console.log(ficha.innerHTML);
				document.getElementById('fichaDetalhada').style.borderBottom = '1px solid #810101'; 
				fichaDetalhada(ficha.innerHTML);
				$('html, body').animate({scrollTop: $("#loggado").offset().top}, 1000);
			});

			$('#buttons').on("input", "#procurarFichas", function(){
				var divFichasJulgamento= document.getElementById('divFichasJulgamento');
				divFichasJulgamento.innerHTML = '';

                if(this.value ==''){
					<?php

					$inner = "";

					$query = "SELECT idFicha,nomeFicha FROM fichasJulgamento ORDER BY idFicha ASC LIMIT 0,20";
					$max = 0;
					if($stmt = @mysqli_query($dbc, $query)) {
						
						while($row = mysqli_fetch_array($stmt)) {
							$inner .= "<div class='fichaQuadrado'>";
							$inner .= "<p class='id_ficha'>". $row['idFicha'] ."</p>";
							$inner .= "<ul>";
							$inner .= "<li>". $row['nomeFicha'] ."</li>";
							$inner .= "</ul>";
							$inner .= "</div>";
						}
					}
					else{
						echo "nao funcionou";
					}
					?>
					var inner = "<?php echo "$inner" ?>";
					divFichasJulgamento.innerHTML = inner;
				}
				else{
                    str1 = this.value;
					$(function() {
				        $.ajax({
				            type: 'post',
				            url: 'procurarFichaDinamica.php', //assumes file is in root dir//
				            data: {source1: str1},
				            success: function(response) {
				                $("#divFichasJulgamento").html(response); //inserts echoed data into div//
				            }
				        });
				    });
				}
			});

		</script>
	</div>

<?php endif;?>

<?php include ("footer.php");
