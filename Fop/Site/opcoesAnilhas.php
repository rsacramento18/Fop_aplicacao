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
	<h1>Opções Anilhas</h1>
	<?php
	$query = "SELECT dataNum, data
	FROM datasAnilhas";
	$stmt = @mysqli_query($dbc, $query);
	if($stmt){
		while($row = mysqli_fetch_array($stmt)) {
			$dataNum = $row['dataNum'];
			$data = $row['data'];?>
			<script type="text/javascript">
				$(document).ready(function(){
					var dataNum = "<?php echo $dataNum; ?>";
					var data = "<?php echo $data; ?>";
					dataCustumize(dataNum, data);
				});
			</script><?php
		}
	}
	?>
	<div id="opcoesAnilhas">
		<form>
			<h2>Data 1:</h2>
			<input type="text" class ="datepicker" id="data1text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('1',this.form.data1text)"></input>
		</form>
		<form>
			<h2>Data 2:</h2>
			<input type="text" class ="datepicker" id="data2text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('2',
			this.form.data2text)"></input>
		</form>
		<form>
			<h2>Data 3:</h2>
			<input type="text" class ="datepicker" id="data3text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('3',
			this.form.data3text)"></input>
		</form>
		<form>
			<h2>Data 4:</h2>
			<input type="text" class ="datepicker" id="data4text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('4',
			this.form.data4text)"></input>		
		</form>
		<form>
			<h2>Data 5:</h2>
			<input type="text" class ="datepicker" id="data5text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('5',
			this.form.data5text)"></input>
		</form>
		<form>
			<h2>Data 6:</h2>
			<input type="text" class ="datepicker" id="data6text">
			<input type="button" value="Gravar Data" name="pesquiSocio" 
			onclick="gravarDataAnilha('6',
			this.form.data6text)"></input>
		</form>
	</div>
</div>
<?php endif;?>
<?php include ("footer.php"); ?>