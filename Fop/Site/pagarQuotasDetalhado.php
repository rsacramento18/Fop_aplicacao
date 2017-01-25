<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'], $_SESSION['clube'])){
	$stam = $_POST['source1'];
	$clube = $_SESSION['clube'];
}

$query = "SELECT * from socios 
INNER JOIN socios_clubes
ON socios.stam=socios_clubes.stam 
WHERE socios.stam = '$stam' AND socios_clubes.clube = '$clube'";

$stmt = @mysqli_query($dbc, $query);
if($stmt) {

	$dadosAssociado = mysqli_fetch_array($stmt);

	echo "<div id='numeroAssociado'>";

	echo "<h2>Associado No. ". $dadosAssociado['membro_num'] ."</h2>";
	echo "<h3>Data de Adesão - ". $dadosAssociado['data_adesao'] ."</h3>";
	echo "</div>";

	$membro_num = $dadosAssociado['membro_num'];
	$data_adesao = $dadosAssociado['data_adesao'];?>

	<script type="text/javascript">
		$(document).ready(function() {
		    $(function(){
		        $.datepicker.setDefaults(
		            $.extend( $.datepicker.regional[ '' ] )
		            );
		        $( '.datepicker2' ).datepicker({
		            dateFormat: "yy-mm-dd"
		        });
		    });
		});
	</script>
	<?php

	echo "<div id='alterarNumeroAssociado' style= 'display:none;'>";

	echo "<form action='alterarDadosAssociadoClube.inc.php' id='formAlterarNumeroAssociado' method='post' name='formAlterarDadosAssociadoClube' >";
	echo "<input type='hidden' name='stam' value='$stam'></input>";
	echo "<input type='hidden' name='clube' value='$clube'></input>";
	echo "<h2>Associado No.<input type='text' name='membroNum' value='$membro_num'></input></h2>";
	echo "<h3>Data de Adesão<input type='text' class ='datepicker2' name='dataAdesao' value='$data_adesao'></input></h3>";
	echo "<input type='submit' id='alterarNumeroBT' value='Alterar Número do Associado'></input>";
	echo "</form>";


	echo "</div>";

	echo "<div id='dadosMembro'>";
	echo "<table id='tableMembroDetalhado'>";

	echo "<tr><th>Stam</th><td>" . $dadosAssociado['stam'] . "</td></tr>";
	echo "<tr><th>Nome</th><td>" . $dadosAssociado['nome'] . "</td></tr>";
	echo "<tr><th>Email</th><td>" . $dadosAssociado['email'] . "</td></tr>";
	echo "<tr><th>Bi/CC</th><td>" . $dadosAssociado['bi'] . "</td></tr>";
	echo "<tr><th>País</th><td>" . $dadosAssociado['pais'] . "</td></tr>";
	echo "<tr><th>Região</th><td>" . $dadosAssociado['regiao'] . "</td></tr>";
	echo "<tr><th>Morada</th><td>" . $dadosAssociado['morada'] . "</td></tr>";
	echo "<tr><th>Código Postal</th><td>" . $dadosAssociado['cod_postal'] . "</td></tr>";
	echo "<tr><th>Localidade</th><td>" . $dadosAssociado['Localidade'] . "</td></tr>";
	echo "<tr><th>Telefone 1</th><td>" . $dadosAssociado['telefone1'] . "</td></tr>";
	echo "<tr><th>Telefone 2</th><td>" . $dadosAssociado['telefone2'] . "</td></tr>";

	echo "</table>";

	echo "</div>";

	$nome = $dadosAssociado['nome'];

	echo "<form id='formAlterarNumeroAssociadoClube'>";
	echo "<input type='button' id='alterarNumeroBT' value='Alterar Número do Associado' onclick='alterarNumeroFunction();'></input>";
	echo "</form>";

	echo "<form id='formAlterarDadosAssociadoClube' action='editarRegistoSocio.php' method='post' name='formAlterarDadosAssociadoClube'>";
	$_SESSION['anilhasUser'] = $dadosAssociado;
	echo "<input type='submit' id='alterarDadosBT' value='Alterar Dados do Associado'></input>";
	echo "</form>";


	echo "<form action='eliminarAssociadoClube.php' id='formEliminarAssociadoClube' method='post' name='formAlterarDadosAssociadoClube'>";
	echo "<input type='hidden' name='stam' value='$stam'></input>";
	echo "<input type='hidden' name='clube' value='$clube'></input>";
	echo "<input type='submit' id='eliminarAssociadoClubeBt' value='Eliminar Associado do Clube'></input>";
	echo "</form>";

	echo "<div id='clubeDiv'>";
	echo "<h2 id='headerClube'>Clube</h2>";
	echo "<table id='membroDetalhadoTable'>";
	echo "<tr><th>Associado No.</th><th>Clube</th><th>Data de Adesão</th></tr>";

	$query = "SELECT * from socios_clubes where stam = '$stam'";
	$stmt = @mysqli_query($dbc, $query);
	if($stmt) {
		while($row = mysqli_fetch_array($stmt)){
			echo "<tr><td>".$row['membro_num']."</td><td>".$row['clube']."</td><td>".$row['data_adesao']."</td></tr>";
		}
	}

	echo "</table>";
	echo "</div>";

	$query = "SELECT * from quotas 
	WHERE stam = '$stam' AND  clube = '$clube' AND valido = 'Actual'";

	$stmt = @mysqli_query($dbc, $query);
	$dataAte="";
	if($stmt) {
		$row = mysqli_fetch_array($stmt);  
		if($row['dataAte']!=""){
			$dataAte = $row['dataAte'];
		}
		else{
			$query = "SELECT * from quotas 
			WHERE stam = '$stam' AND  clube = '$clube' AND valido = 'Joia'";

			$stmt = @mysqli_query($dbc, $query);
			$dataAte="";
			if($stmt) {
				$row = mysqli_fetch_array($stmt);  
				if($row['dataAte']!=""){
					$dataAte = $row['dataAte'];
				}
				else{
					$dataAte = "0000-00-00";
				}
			}
		}
	}

	$query = "SELECT * from quotas 
	WHERE stam = '$stam' AND  clube = '$clube' LIMIT 1 ";

	$stmt = @mysqli_query($dbc, $query);
	$dataDe="";
	if($stmt) {
		$row = mysqli_fetch_array($stmt);  
		if($row['dataDe']!=""){
			$dataDe = $row['dataDe'];
		}
		else{
			$dataDe = "0000-00-00";
		}
	}


	$dataDe = explode('-', $dataDe);

	$dataAte = explode('-', $dataAte);

	$dataCorrente = date("Y");

	echo "<div id='divQuotas'>"; 
	echo "<h2 id='headerClube'>Quotas</h2>";
	echo "<div id='buttonsQuotas'>";     
	echo "<input type='button' value='<' id='btRetrocederQuotas'/>";
	echo "<span id='dataCorrente'></span>";
	echo "<input type='button' value='>' id='btAvancarQuotas'/>";
	echo "</div>";

	$j = 0;
	for ($i=0; $i < 12; $i++) {
		$j = $i+1;
		if($dataCorrente == $dataDe[0] && $dataCorrente == $dataAte[0] ){
			if( $j >= $dataDe[1] && $j <= $dataAte[1]){
				echo "<div style='background-color:#2bc430;'class='quadradoMesQuota' id='mes$i'>";
			}
			else{
				echo "<div style='background-color:white;'class='quadradoMesQuota' id='mes$i'>";
			}
		}
		else if($dataDe[0] == $dataCorrente &&  $dataCorrente < $dataAte[0]){
			if($j >= $dataDe[1]){
				echo "<div style='background-color:#2bc430;'class='quadradoMesQuota' id='mes$i'>";
			}
			else{
				echo "<div style='background-color:white;'class='quadradoMesQuota' id='mes$i'>";
			}
		}
		else if($dataCorrente > $dataDe[0] && $dataCorrente == $dataAte[0] ){
			if($j <= $dataAte[1]){
				echo "<div style='background-color:#2bc430;'class='quadradoMesQuota' id='mes$i'>";
			}
			else{
				echo "<div style='background-color:white;'class='quadradoMesQuota' id='mes$i'>";
			}
		}
		else if($dataCorrente >$dataDe[0] && $dataCorrente < $dataAte[0] ){
			echo "<div style='background-color:#2bc430;'class='quadradoMesQuota' id='mes$i'>";
		}
		else if($dataCorrente < $dataDe[0] ){
			echo "<div style='background-color:white;'class='quadradoMesQuota' id='mes$i'>";
		}
		else if($dataCorrente > $dataDe[0] && $dataCorrente > $dataAte[0] ){
			echo "<div style='background-color:#white;'class='quadradoMesQuota' id='mes$i'>";
		}
		else {
			echo "<div style='background-color:white;'class='quadradoMesQuota' id='mes$i'>";
		}
		echo "<p>".($i+1)."</p>";

		switch ($i) {
			case 0:
			echo "<p>Janeiro</p>";
			break;
			case 1:
			echo "<p>Fevereiro</p>";
			break;
			case 2:
			echo "<p>Março</p>";
			break;
			case 3:
			echo "<p>Abril</p>";
			break;
			case 4:
			echo "<p>Maio</p>";
			break;
			case 5:
			echo "<p>Junho</p>";
			break;
			case 6:
			echo "<p>Julho</p>";
			break;
			case 7:
			echo "<p>Agosto</p>";
			break;
			case 8:
			echo "<p>Setembro</p>";
			break;
			case 9:
			echo "<p>Outubro</p>";
			break;
			case 10:
			echo "<p>Novembro</p>";
			break;
			case 11:
			echo "<p>Dezembro</p>";
			break;
			default:
			break;
		}

		echo "</div>";
	}

	echo "</div>";

	echo "<div id='pagarQuotas'>";
	echo "<h2 id='headerClube'>Pagar Quotas</h2>";


	$_SESSION['clube'] = $clube;
	$_SESSION['stam'] = $stam;
	$_SESSION['nome'] = $nome;
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$(function() {
				$.datepicker.setDefaults(
					$.extend( $.datepicker.regional[ '' ] )
					);
				$( '.datepicker' ).datepicker({
					dateFormat: "yy-mm",
				});
			});
		});

	</script>
	<form id="pagarQuotasForm" action="pagarQuotaDeUtilizador.php" method="post" name="pagarQuota">
		<input type="text" class ="datepicker" id="quotaPagarAte" name="quotaPagarAte"><span> Pagar até </span></input></br>
		<input type="text" id="quotaPagarPreco" name="preco" onkeypress="return isNumberKey(event)" ></input><span> Preço da Quota em Euros </span></br>
		<div id="calculos"></div>
		<input type='button' value='Pagar Quota' name='pagarQuotaBT' onclick="restricoesDados()"></input>
	</form>
	<form id="pagarQuotasFormPrimeiraVez" action="pagarQuotaDeUtilizador.php" method="post" name="pagarQuota" style='display: none;'>
		<input type="text" class ="datepicker" id="quotaPagarDe" name="quotaPagarDe"><span> Pagar de </span></input></br>
		<input type="text" class ="datepicker" id="quotaPagarAtePrimeiraVez" name="quotaPagarAtePrimeiraVez"><span> Pagar até </span></input></br>
		<input type="text" id="quotaPagarPreco2" name="preco" onkeypress="return isNumberKey(event)" ></input><span> Preço da Quota em Euros </span></br>
		<input type="text" id="quotaPagarJoia" name="joia" onkeypress="return isNumberKey(event)" ></input><span> Preço da Joia em Euros </span></br>
		<input type='button' value='Pagar Quota' name='pagarQuotaBT' onclick="restricoesDados2()"></input>
	</form>
	<?php
	echo "</div>";
	echo "</div>";

	echo "<div id='verQuotasAnteriores'>";
	echo "<h2 id='headerClube'>Quotas Anteriores</h2>";

	echo"<table id='tableQuotasAnteriores'>";
	echo "<tr><th>Quota ID</th><th>De</th><th>Ate</th><th>Valor Pago</th><th>Data do Pagamento</th></tr>";
	$query = "SELECT * from quotas where stam='$stam' group by idQuota DESC";
	$stmt = @mysqli_query($dbc, $query);
	if($stmt) {
		while($row = mysqli_fetch_array($stmt)){
			$dataDeAux = $row['dataDe'];
			$dataDeAux = explode('-', $dataDeAux);
			switch($dataDeAux[1]){
				case 1:
				$dataDeExtenso = "Janeiro ".$dataDeAux[0];
				break;
				case 2:
				$dataDeExtenso = "Fevereiro ".$dataDeAux[0];
				break;
				case 3:
				$dataDeExtenso = "Março ".$dataDeAux[0];
				break;
				case 4:
				$dataDeExtenso = "Abril ".$dataDeAux[0];
				break;
				case 5:
				$dataDeExtenso = "Maio ".$dataDeAux[0];
				break;
				case 6:
				$dataDeExtenso = "Junho ".$dataDeAux[0];
				break;
				case 7:
				$dataDeExtenso = "Julho ".$dataDeAux[0];
				break;
				case 8:
				$dataDeExtenso = "Agosto ".$dataDeAux[0];
				break;
				case 9:
				$dataDeExtenso = "Setembro ".$dataDeAux[0];
				break;
				case 10:
				$dataDeExtenso = "Outubro ".$dataDeAux[0];
				break;
				case 11:
				$dataDeExtenso = "Novembro ".$dataDeAux[0];
				break;
				case 12:
				$dataDeExtenso = "Dezembro ".$dataDeAux[0];
				break;
				default:
				break;
			} 

			$dataAteAux = $row['dataAte'];
			$dataAteAux = explode('-', $dataAteAux);
			switch($dataAteAux[1]){
				case 1:
				$dataAteExtenso = "Janeiro ".$dataAteAux[0];
				break;
				case 2:
				$dataAteExtenso = "Fevereiro ".$dataAteAux[0];
				break;
				case 3:
				$dataAteExtenso = "Março ".$dataAteAux[0];
				break;
				case 4:
				$dataAteExtenso = "Abril ".$dataAteAux[0];
				break;
				case 5:
				$dataAteExtenso = "Maio ".$dataAteAux[0];
				break;
				case 6:
				$dataAteExtenso = "Junho ".$dataAteAux[0];
				break;
				case 7:
				$dataAteExtenso = "Julho ".$dataAteAux[0];
				break;
				case 8:
				$dataAteExtenso = "Agosto ".$dataAteAux[0];
				break;
				case 9:
				$dataAteExtenso = "Setembro ".$dataAteAux[0];
				break;
				case 10:
				$dataAteExtenso = "Outubro ".$dataAteAux[0];
				break;
				case 11:
				$dataAteExtenso = "Novembro ".$dataAteAux[0];
				break;
				case 12:
				$dataAteExtenso = "Dezembro ".$dataAteAux[0];
				break;
				default:
				break;
			} 
			echo "<tr><td>".$row['idQuota']."</td><td>".$dataDeExtenso."</td><td>".$dataAteExtenso."</td><td>".$row['valorPago']."€</td><td>".$row['dataDoPagamento']."</td></tr>";
		}
	}

	echo"</table>";

}
else {
	echo "nao funcionou isto";
}

echo "<form action='listagemQuotas2.php' id='verQuotaForm' method='post' name='listagem_form' target='_blank'>";
echo "<input type='hidden' name='idQuota' value=''></input>";
echo "<input type='hidden' name='stam' value='$stam'></input> ";
echo "<input type='hidden' name='clube' value='$clube'></input> ";
echo "</form>";

echo "<form action='eliminarQuota.php' id='eliminarQuotaForm' method='post' name='eliminarQuotaForm' >";
echo "<input type='hidden' name='stam' value='$stam'></input> ";
echo "<input type='hidden' name='clube' value='$clube'></input> ";
echo "<input type='submit' name='eliminarQuotaAnteriorBt' value='Eliminar quota Anterior'></input>";
echo "</form>";

echo "</div>";
?>
<script type="text/javascript">
	addRowHandlers();
	var btRetrocederQuotas = document.getElementById('btRetrocederQuotas');

	var btAvancarQuotas = document.getElementById('btAvancarQuotas');

	var dataCorrente = new Date().getFullYear();

	document.getElementById('dataCorrente').innerHTML = dataCorrente;

	var dataDeAno = <?php echo "$dataDe[0]";?>;

	var dataDeMes = <?php echo "$dataDe[1]";?>;

	var dataAteAno = <?php echo "$dataAte[0]";?>;

	var dataAteMes =<?php echo "$dataAte[1]";?>;

	console.log(dataDeAno);
	console.log(dataDeMes);
	console.log(dataAteAno);
	console.log(dataAteMes);

	if(dataDeAno == "0000" &&  dataDeMes == "00"){
		document.getElementById('pagarQuotasForm').style.display = "none";
		document.getElementById('pagarQuotasFormPrimeiraVez').style.display ="block";
	}



	btRetrocederQuotas.onclick = function() {
		dataCorrente = document.getElementById('dataCorrente').innerHTML;
		dataCorrente = parseInt(dataCorrente) -  1;
		if(dataCorrente<2016){
			dataCorrente = 2016;
		}
		document.getElementById('dataCorrente').innerHTML = dataCorrente;
		var j = 0, i =0;
		for(i = 0; i < 12; i++){
			j = i+1;
			var idNome = 'mes' + i;
			var quadrado = document.getElementById(idNome);
			if(dataCorrente == dataDeAno && dataCorrente == dataAteAno) {
				if(j >= dataDeMes && j <= dataAteMes){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente == dataDeAno && dataCorrente < dataAteAno) {
				if(j >= dataDeMes ){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente > dataDeAno && dataCorrente == dataAteAno) {
				if(j <= dataAteMes ){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente > dataDeAno && dataCorrente < dataAteAno) {
				quadrado.style.backgroundColor = "#2bc430";
			}
			else if(dataCorrente < dataDeAno) {
				quadrado.style.backgroundColor = "white";
			}
			else{
				quadrado.style.backgroundColor="white";
			}
		}
	}

	btAvancarQuotas.onclick = function() {
		dataCorrente = document.getElementById('dataCorrente').innerHTML;
		dataCorrente =  parseInt(dataCorrente) + 1;
		document.getElementById('dataCorrente').innerHTML = dataCorrente;
		var j = 0, i =0;
		for(i = 0; i < 12; i++){
			j = i+1;
			var idNome = 'mes' + i;
			var quadrado = document.getElementById(idNome);
			if(dataCorrente == dataDeAno && dataCorrente == dataAteAno) {
				if(j >= dataDeMes && j <= dataAteMes){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente == dataDeAno && dataCorrente < dataAteAno) {
				if(j >= dataDeMes ){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente > dataDeAno && dataCorrente == dataAteAno) {
				if(j <= dataAteMes ){
					quadrado.style.backgroundColor = "#2bc430";
				}
				else{
					quadrado.style.backgroundColor="white";
				}
			}
			else if(dataCorrente > dataDeAno && dataCorrente < dataAteAno) {
				quadrado.style.backgroundColor = "#2bc430";
			}
			else if(dataCorrente < dataDeAno) {
				quadrado.style.backgroundColor = "white";
			}
			else{
				quadrado.style.backgroundColor="white";
			}
		}

	}

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function addRowHandlers() {
		var table = document.getElementById("tableQuotasAnteriores");
		var rows = table.getElementsByTagName("tr");
		for (i = 0; i < rows.length; i++) {
			var currentRow = table.rows[i];
			var createClickHandler = 
			function(row) 
			{
				return function() { 
					var cell = row.getElementsByTagName("td")[0];
					var idQuota = cell.innerHTML;
					if(idQuota != 'Quota ID'){
						var form = document.getElementById('verQuotaForm');
						form.getElementsByTagName("input")[0].value = idQuota;
						form.submit();
					}
				};
			};

			currentRow.onclick = createClickHandler(currentRow);
		}
	}

	function restricoesDados(){
		var quotaPagarAte = document.getElementById('quotaPagarAte').value;
		var quotaPagarPreco = document.getElementById('quotaPagarPreco').value;
		if(dataAteMes < 10){
			var dataAteAux = dataAteAno + "-0" + dataAteMes;
		}
		else{
			var dataAteAux = dataAteAno + "-" + dataAteMes;
		}
		dataAteAux = Date.parse(dataAteAux);
		if(quotaPagarAte != ''){
			quotaPagarAte = Date.parse(quotaPagarAte);
		}

		console.log('quota de ==' + quotaPagarAte + ' data inserida é =='+ dataAteAux);

		var error ='';

		if(quotaPagarAte == ''){
			error += 'Tem que selecionar uma mês para pagar quotas até.';
		}
		if(quotaPagarAte <= dataAteAux){
			error += '\nO mês selecionado tem que ser superior ao ultimo mês pago.';
		}
		if(quotaPagarPreco == ''){
			error += '\nO Preço nao pode ser nulo.';
		}

		if(error !=''){
			alert(error);
		}
		else{
			var form = document.getElementById('pagarQuotasForm');
			form.submit();
		}
	}
	function restricoesDados2(){
		var quotaPagarDe = document.getElementById('quotaPagarDe').value;
		var quotaPagarAte = document.getElementById('quotaPagarAtePrimeiraVez').value;
		var quotaPagarPreco = document.getElementById('quotaPagarPreco2').value;
		var joia = document.getElementById('quotaPagarJoia').value;
		if(quotaPagarAte != ''){
			quotaPagarAte = Date.parse(quotaPagarAte);
		}
		if(quotaPagarDe != ''){
			quotaPagarDe = Date.parse(quotaPagarDe);
		}
		
		var error = "";

		if(quotaPagarDe == ""){
			error += 'Tem que selecionar um mês para pagar quotas de.';
		}
		if(quotaPagarDe < Date.parse('2016-01')){
			error += '\nTem que selecionar um mês superior a 2016.';
		}
		if(quotaPagarAte == ""){
			error += '\nTem que selecionar um mês para pagar quotas até.';
		}
		if(quotaPagarPreco == ""){
			error += '\nO Preço nao pode ser nulo.';
		}
		if(joia == ""){
			error += '\nA joia não pode ser nula. Se pretender não pagar joia selecione 0.';
		}
		if(quotaPagarAte < quotaPagarDe){
			error += '\nO mes selecionado para pagar quotas até nao pode ser inferior ao mês selecionado para pagar quotas de.';
		}

		if(error !=''){
			alert(error);
		}
		else{
			
			var form = document.getElementById('pagarQuotasFormPrimeiraVez');
			form.submit();
		}
	}

	function alterarNumeroFunction(){
		var numeroAssociado = document.getElementById('numeroAssociado');
		numeroAssociado.style.display = "none";

		var alterarNumeroAssociado = document.getElementById('alterarNumeroAssociado');
		alterarNumeroAssociado.style.display = "block";

		var formAlterarNumeroAssociadoClube = document.getElementById('formAlterarNumeroAssociadoClube');
		formAlterarNumeroAssociadoClube.style.display = "none";

		var formAlterarDadosAssociadoClube = document.getElementById('formAlterarDadosAssociadoClube');
		formAlterarDadosAssociadoClube.style.display = "none";

		var formEliminarAssociadoClube = document.getElementById('formEliminarAssociadoClube');
		formEliminarAssociadoClube.style.display = "none";
	}
</script>
