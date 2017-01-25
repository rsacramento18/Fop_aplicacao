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
			            url: 'sociosClubeDisplay2.php', //assumes file is in root dir//
			            data: {source1: str1},
			            success: function(response) {
			                $("#sociosClubeDisplay").html(response); //inserts echoed data into div//
			            }
			        });
				});
			}
			var max = <?php echo json_encode($max); ?>;
			max = parseInt(max);
		</script>
		<h1>Pesquisar Socios por Clube</h1>
		<div id="sociosDiv">
			<?php if( login_fop_check($dbc) == true) :?>
				<form >
					<h2>Pesquisar por: </h2>
					<select name="campoClube" id="campoClube">
						<?php getClubes($dbc)?>	
					</select>
					<input type="button" value="Listar Sócios do Clube" name"pesquiSocio" 
					onclick="showSociosClube(
					this.form.campoClube)"></input>
				</form>
				
			<?php else :?>
				<div id="buttons">
					<input type='button' value='anterior <' id='btRetroceder'/>
					<input type='button' value='> seguinte' id='btAvancar'/>
				</div>

				<script type="text/javascript">getNext(0);</script>

			<?php endif;?>
		</div>
		<script type="text/javascript">
			var counter = 0;

			var btRetroceder = document.getElementById('btRetroceder');
			var btAvancar = document.getElementById('btAvancar');

			btRetroceder.onclick = function () {
				if(counter >= 20){
					counter -= 20;
					document.getElementById('sociosClubeDisplay').innerHTML = "";
					getNext(counter); 
				}
			};

			btAvancar.onclick = function() {
				if(counter+20 < max){
					counter += 20;
					document.getElementById('sociosClubeDisplay').innerHTML = "";
					getNext(counter);
				}
				
			};

		</script>
		<div id="sociosClubeDisplay">
		</div>
	</div>

<?php endif;?>

<?php include ("footer.php"); ?>