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
	<h1>Anilhas - Encomendar</h1>
	
	<?php

	$query = "SELECT pedidoNum from pedidoEmVigor where id = 1";
	$vagaNum = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$vagaNum =  $row['pedidoNum'];
	}

	$query = "SELECT quantidade from quantidadeMinima where id = 1";
	$quantidadeMinimaNormal = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$quantidadeMinimaNormal =  $row['quantidade'];
	}
	$query = "SELECT quantidade from quantidadeMinima where id = 2";
	$quantidadeMinimaReforcada = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$quantidadeMinimaReforcada =  $row['quantidade'];
	}
	$query = "SELECT quantidade from quantidadeMinima where id = 3";
	$quantidadeMinimaAco = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$quantidadeMinimaAco =  $row['quantidade'];
	}

	$query = "SELECT validoDurante from validarCartaoFop where id = 1";
	$validadeCartaoFop = 0;
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$validadeCartaoFop =  $row['validoDurante'];
	}

	$portesPreco = 0;
	if(login_clube_check($dbc) == true){
		$clube = $_SESSION['clube'];
		$query = "SELECT precoPortes from clubes where nome_clube = '$clube' ";
		
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$portesPreco =  $row['precoPortes'];
		}
	}

	if(isset($_POST['input']) && isset($_POST['campo']) ){

		$src1= $_POST['input'];  
		$src2= $_POST['campo'];
		$privilegio = $_SESSION['privilegio']; 
		if($src2 == 'nome'){
			$src1 = preg_replace('/\s+/', '%', $src1);
		}    

		if(isset($_SESSION['clube'])){
			$clube = $_SESSION['clube'];
			$sigla = "";
			$query ="SELECT sigla from clubes where nome_clube = '$clube'";
			if($stmt = @mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($stmt);
				$sigla =  $row['sigla'];
			}

		}
		if($privilegio == "clube"){
			$query = "SELECT socios.stam, socios.nome, socios.email, socios.bi,
			socios.pais, socios.regiao, socios.morada, socios.cod_postal,
			socios.Localidade, socios.telefone1, socios.telefone2, socios.cartaoFop
			FROM socios
			INNER JOIN socios_clubes
			On socios.stam=socios_clubes.stam
			WHERE socios_clubes.clube = '$clube' 
			AND socios.$src2 LIKE '%$src1%'
			Limit 1";        
		}
		else {
			$query = "SELECT socios.stam, socios.nome, socios.email, socios.bi,
			socios.pais, socios.regiao, socios.morada, socios.cod_postal,
			socios.Localidade, socios.telefone1, socios.telefone2,socios.cartaoFop
			FROM socios
			WHERE socios.$src2 LIKE '%$src1%'
			Limit 1";
		}
		if($stmt = @mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($stmt);
			$_SESSION['anilhasUser'] = $row; 
			if($row['stam']!='' && $row['nome']!='' && $row['bi']!= '' && $row['pais']!='' && $row['regiao']!='' && $row['morada']!='' && $row['Localidade']!='' && $row['telefone2']!='0' && $row['telefone2']!=''){
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
				
				$stam = $row['stam'];

				if(login_fop_check($dbc)==true){
					$query = "SELECT clube from socios_clubes where stam = '$stam'";
					$stmt = @mysqli_query($dbc, $query);

					if($stmt) {

						?><span>O associado pertence a mais que um clube.</span>
						<select id="clubeSelect" name="clubeSelect" id="clubeSelect"><?php
							while($row2 = mysqli_fetch_array($stmt)) {
								?>			
								<option value=<?php echo '"'.$row2['clube'].'"'?>><?php echo $row2['clube'] ?></option>
								<?php
								
							}
							?></select></br><?php
						}

					}
					else {
						echo "<table id='tableCartaoFop'><tr><th>Clube</th><td>" . $_SESSION['clube'].
						"</td></tr></table>";
					}


					echo "<input type='button'value='Voltar' onclick=\"document.location.href='encomendarAnilhasFase1.php'\"/>";
					echo "</div>";

					

					$query = "SELECT Max(numPedido) as numPedido from encomendasAnilhas
					where stam LIKE '%$stam%' and vagaNum = '$vagaNum' ";
					$pedidoNum = 0;
					if($stmt = @mysqli_query($dbc, $query)) {
						$row = mysqli_fetch_array($stmt);
						$pedidoNum =  $row['numPedido'];
					}

					if($row['numPedido'] !=NULL){

						$count = $row['numPedido'];
						

						echo "<div id='divEncomendasSocio'>";
						echo "<h2>Encomendas do Socio</h2>";
						echo "<table>";
						echo "<tr>";
						echo "<th>Opção</th>";
						echo "<th>Medida</th>";
						echo "<th>Quantidade</th>";
						echo "<th>Do Numero</th>";
						echo "<th>Ao Numero</th>";
						echo "<th>Preço</th>";
						echo "</tr>";

						for($x=0 ; $x < $count; $x++){
							$numPedido = $x+1;
							if(login_fop_check($dbc) == true){
								$query="SELECT opcao, medida, quantidade, numInicio, numFim, numPedido, custo 
								FROM encomendasAnilhas 
								WHERE stam LIKE '%$stam%'
								AND  numPedido = '$numPedido'
								AND  vagaNum = '$vagaNum'";
							}
							else {
								$query="SELECT opcao, medida, quantidade, numInicio, numFim, numPedido, custo 
								FROM encomendasAnilhas 
								WHERE stam LIKE '%$stam%'
								AND  clube = '$sigla'
								AND  numPedido = '$numPedido'
								AND  vagaNum = '$vagaNum'";
							}

							if($stmt2 = @mysqli_query($dbc, $query)) {
								$row = mysqli_fetch_array($stmt2);
								if($row['opcao']!=""){
									echo "<tr>"; 
									echo "<td>" . $row['opcao'] . "</td>";
									echo "<td>" . number_format((float)$row['medida'], 1, '.', '')  . "</td>";
									echo "<td>" . $row['quantidade']  . "</td>";
									echo "<td>" . $row['numInicio']  . "</td>";
									echo "<td>" . $row['numFim']  . "</td>";
									echo "<td>" . number_format((float)$row['custo'], 2, '.', '')  . "&euro;</td>";
									echo "</tr>";
								}
							}
							else{
								echo "-->nao deu da segunda vez<br/>";
							}
						}
						echo "</table>";

						$query = "SELECT cartaoFopPago from encomendasAnilhas where stam LIKE '%$stam%'
						and vagaNum = '$vagaNum'";
						$cartaoFopPago = "Não";
						if($stmt = @mysqli_query($dbc, $query)) {
							$row = mysqli_fetch_array($stmt);

							$cartaoFopPago =  $row['cartaoFopPago'];
						}

						$query = "SELECT portesPagos from encomendasAnilhas where stam LIKE '%$stam%'
						and vagaNum = '$vagaNum'";
						$portesPago = "Não";
						if($stmt = @mysqli_query($dbc, $query)) {
							$row = mysqli_fetch_array($stmt);

							$portesPago =  $row['portesPagos'];
						}

						$query = "SELECT preco from anilhasPrecos where id = 4";
						$precoCartaoFop = 0;
						if($stmt = @mysqli_query($dbc, $query)) {
							$row = mysqli_fetch_array($stmt);
							$precoCartaoFop =  number_format((float)$row['preco'], 2, '.', '');
						}
						if(login_fop_check($dbc) == true){
							$query = "SELECT ROUND(SUM(custo),2) as custo FROM encomendasAnilhas 
							WHERE stam LIKE '%$stam%' 
							AND vagaNum = '$vagaNum'";
						}
						else {
							$query = "SELECT ROUND(SUM(custo),2) as custo FROM encomendasAnilhas 
							WHERE stam LIKE '%$stam%' 
							AND vagaNum = '$vagaNum'
							AND clube = '$sigla'";	
						}
						$custoTotal = 0.0;
						if($stmt = @mysqli_query($dbc, $query)) {
							$row = mysqli_fetch_array($stmt);
							$custoTotal =  $row['custo'];
						}

						if($cartaoFopPago == 'Sim'){
							echo "<table id='tableTotalCustos'><tr><th>Cartao FOP</th><td>" . number_format((float)$precoCartaoFop, 2, '.', '') . "&euro;</td></tr>";
						}
						else {
							echo "<table id='tableTotalCustos'>";
						}


						if($portesPago == "Sim"){
							$query = "SELECT portes from clubes where clube = '$clube' LIMIT 1";
							$precoPortes = 0;
							if($stmt = @mysqli_query($dbc, $query)) {
								$row = mysqli_fetch_array($stmt);
								$precoPortes =  $row['portes'];
							}
							echo "<tr><th>Portes</th><td>" . number_format((float)$precoPortes, 2, '.', '') . "&euro;</td></tr>";
						}
						else {
							echo "<table id='tableTotalCustos'>";
						}
						if($vagaNum == 6){
							$query = "SELECT preco from anilhasPrecos where id = 5";
							$preco6Pedido = 0;
							if($stmt = @mysqli_query($dbc, $query)) {
								$row = mysqli_fetch_array($stmt);
								$preco6Pedido =  $row['preco'];
							}			
							echo "<tr><th>Custo adicional pedido 6</th><td>" . number_format((float)$preco6Pedido, 2, '.', '') . "&euro;</td></tr></table><br/>";
						}
						else {
							echo "</table><br/>";
						}

						echo "<table id='tableTotalCustos'><tr><th>Custo Total da Encomenda</th><td>";
						if($cartaoFopPago == 'Sim' && $portesPago == "Sim" && $vagaNum == 6){
							echo $custoTotal+$precoCartaoFop+$precoPortes+$preco6Pedido . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Sim' && $portesPago == "Sim" && $vagaNum == 6){
							echo $custoTotal+$precoCartaoFop+$preco6Pedido . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Sim' && $portesPago == "Sim" && $vagaNum != 6){
							echo $custoTotal+$precoPortes+$precoCartaoFop . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Sim' && $portesPago == "Não" && $vagaNum != 6){
							echo $custoTotal+$precoCartaoFop . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Não' && $portesPago == "Sim" && $vagaNum == 6){
							echo $custoTotal+$precoPortes+$preco6Pedido . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Não' && $portesPago == "Sim" && $vagaNum != 6){
							echo $custoTotal+$precoPortes . "&euro;</td></tr></table>";
						}
						else if($cartaoFopPago == 'Não' && $portesPago == "Não" && $vagaNum == 6){
							echo $custoTotal+$preco6Pedido . "&euro;</td></tr></table>";
						}
						else {
							echo number_format((float)$custoTotal, 2, '.', '') . "&euro;</td></tr></table>";
						}


						
						echo "<input type='button' id='eliminarPedido' value='Eliminar Pedido' onclick= \"self.location='eliminarPedido.php'\"/>";
						echo "</div>";
					}
				}
				else {?>
				<script type="text/javascript">
					var r = confirm("Os dados do associado estão incompletos. Para prosseguir tem que editar a ficha de associado. Deseja editar a ficha de associado agora?");
					if (r == true) {
						window.location.href="editarRegistoSocio.php";
					} else {
						window.location.href="encomendarAnilhasFase1.php";
					}
					

				</script>
				<?php
			}
		}
		else {
			echo "nao funcionou";
		}
	}

	?>
	<script type="text/javascript"> 
		var limit = 10; // Max questions
		window.count = 1;
		jQuery(function($) {
			var form = document.getElementById('anilhasForm');
			var count = document.getElementById('anilhasForm').getElementsByTagName('input').length;

			var medida = {
				'Normal': ['2.0', '2.3', '2.5', '2.7', '2.9', '3.0', '3.2', '3.5', 
				'4.0', '4.2', '4.5', '5.0', '5.2', '5.5', '6.0', '7.0', '8.0', '9.0',
				'10.0', '11.0', '12.0', '13.0', '14.0', '16.0', '19.0', '23.0', '27.0', '29.0'],
				'Reforçada': ['4.5', '5.0', '5.5', '6.0','6.5' ,'7.0', '8.0', '9.0',
				'10.0', '11.0', '12.7','14.0', '16.0', '19.0', '23.0','26.7', '29.0'],
				'Aço/Inox': ['3.5', '4.2', '4.5', '5.0', '6.0', '7.0', '8.0', '9.5', '11.0', '12.5',
				'14.0'],
			};

			
			$('#opcao1').change(function () {
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida1').html(html);
			});

			$('#anilhasForm').on('change', '#opcao2', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida2').html(html);

			});

			$('#anilhasForm').on('change', '#opcao3', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida3').html(html);

			});

			$('#anilhasForm').on('change', '#opcao4', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida4').html(html);

			});

			$('#anilhasForm').on('change', '#opcao5', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida5').html(html);

			});

			$('#anilhasForm').on('change', '#opcao6', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida6').html(html);

			});

			$('#anilhasForm').on('change', '#opcao7', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida7').html(html);

			});

			$('#anilhasForm').on('change', '#opcao8', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida8').html(html);

			});

			$('#anilhasForm').on('change', '#opcao9', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida9').html(html);

			});

			$('#anilhasForm').on('change', '#opcao10', function(){
				var opcao = $(this).val(), lcns = medida[opcao] || [];

				var html = $.map(lcns, function(lcn){
					return '<option value="' + lcn + '">' + lcn + '</option>';
				}).join('');
				$('#medida10').html(html);

			});

			$('#anilhasForm').on('click', '#apagarBt', function(){
				$('#calcularCusto').prev().remove();
				window.count = window.count -1;
			});


			$('#calcularCusto').on('click', function() {
				var validar = true;
				$('select').each(function() {
					if($(this).val() == "Opção") {
						alert($(this).attr('id') + ' não selecionada');
						validar = false;
						
					}
				});
				$('#anilhasForm input[type="text"]').each(function() {
					
					if($(this).parent().children(':first-child').val() == 'Normal'){
						var quantidade = "<?php echo $quantidadeMinimaNormal; ?>";
					}
					else if($(this).parent().children(':first-child').val() == 'Reforçada'){
						var quantidade = "<?php echo $quantidadeMinimaReforcada; ?>";
					}
					else if($(this).parent().children(':first-child').val() == 'Aço/Inox'){
						var quantidade = "<?php echo $quantidadeMinimaAco; ?>";
					}
					if($(this).val() === '') {
						alert($(this).attr('id') + ' está vazia');
						validar = false;    			
					}
					else if (parseInt($(this).val()) < quantidade){
						alert('a quantidade minima para encomendar é ' + quantidade);
						validar = false;
					}
					else if (isNaN($(this).val())===true){
						alert($(this).attr('id') + ' não é um numero');
						validar = false;
					}
					else if($(this).parent().children(':first-child').val() == 'Normal' && $(this).val()%10 != 0){
						alert($(this).attr('id') + ' Não é multiplo de 10');
						validar = false;
					}
					else if( ($(this).parent().children(':first-child').val() == 'Reforçada' ||
						$(this).parent().children(':first-child').val() == 'Aço/Inox') && ($(this).val()%5 != 0 && $(this).val()%5 != 5)){
						alert($(this).attr('id') + ' Não é multiplo de 5');
					validar = false;
				}
			});
				$("#pagamentoPortes").is(':checked') ? $("#pagamentoPortes").val() : "Não";
				if(validar == true){
					form.count.value = window.count;
					document.getElementById("anilhasForm").submit();
				}
				
				
			});

			$('#mostrarPortesClube').on('click', function() {
				document.getElementById('formPortesClubes').style.display = "block";
				
				document.getElementById('portesClube').value = "<?php echo number_format((float)$portesPreco, 2, '.', ''); ?>"; 
			});


			var clubeSelecionado = document.getElementById('clubeSelect').value;
			document.getElementById('clubeSelecionado').value = clubeSelecionado;

			$('#clubeSelect').change(function () {
				var clubeSelecionado = document.getElementById('clubeSelect').value;
				document.getElementById('clubeSelecionado').value = clubeSelecionado;
			});

			


		});
function addRow() {
	var form = document.getElementById('anilhasForm');

	    // Good to do error checking, make sure we managed to get something
	    if (form)
	    {
	    	if (count < limit)
	    	{	
	    		var newDiv = document.createElement('div');
	    		$("#calcularCusto").before(newDiv);
	    		var array2 =["Normal", "Reforçada","Aço/Inox"];
	    		
	    		var newSelect2 = document.createElement('select');
	    		newSelect2.id = 'opcao' + (count + 1);
	    		newSelect2.name = 'opcao' + (count + 1);
	    		newSelect2.className = 'inputClass';

	    		newDiv.appendChild(newSelect2); 

	    		var optionOpcao = document.createElement("option");
	    		optionOpcao.text = 'Opção';
	    		newSelect2.appendChild(optionOpcao); 
	    		for (var i = 0; i < array2.length; i++) {
	    			var option = document.createElement("option");
	    			option.value = array2[i];
	    			option.text = array2[i];
	    			newSelect2.appendChild(option);

	    		}	

	    		var newSelect = document.createElement('select');
	    		newSelect.id = 'medida' + (count + 1);
	    		newSelect.name = 'medida' + (count + 1);
	    		newSelect.className = 'inputClass';

	    		newDiv.appendChild(newSelect); 

	    		var optionMedida = document.createElement("option");
	    		optionMedida.text = 'Medida';
	    		newSelect.appendChild(optionMedida); 

	    		 // Create the new text box
	    		 var newInput = document.createElement('input');
	    		 newInput.type = 'text';
	    		 newInput.id = 'input' + (count + 1);
	    		 newInput.name = 'input' + (count + 1);
	    		 newInput.size = 5;
	    		 newInput.className = 'inputClass';

	    		 newDiv.appendChild(newInput);

	    		 if (window.count < 2) {
	    		 	var newInput2 = document.createElement('input');
	    		 	newInput2.type = 'button';
	    		 	newInput2.id = 'apagarBt';
	    		 	newInput2.className = 'inputClass3';
	    		 	newInput2.value = '-';
	    		 	newDiv.appendChild(newInput2);
	    		 }
	    		 
	    		 
	    		 window.count = window.count +1;
	    		}	
	    		else {
	    			alert('Question limit reached');
	    		}
	    	}
	    }
	    
	    function eliminarPedido(){
	    	$.ajax({
	    		url: 'eliminarPedido.php',
	    		dataType: 'json',
	    		success: function(data){
	            //data returned from php
	        }
	    });
	    }

	</script>
	<div id="divNovaEncomenda">
		<h2>Nova Encomenda</h2>
		<form action="encomendarAnilhasFase3.php" method="post" id="anilhasForm">
			<div>
				<select id="opcao1" name="opcao1" class="inputClass2">
					<option>Opção</option>
					<option value="Normal">Normal</option>
					<option value="Reforçada">Reforçada</option>
					<option value="Aço/Inox">Aço/Inox</option>
				</select>
				<select id="medida1" name="medida1" class="inputClass2">
					<option>Medida</option>
				</select>
				<input type="text" size="5"  id="input1" name="input1" class="inputClass2"/>		
				<input type="button" id="addBt"  size="5" value="+" onclick="javascript: addRow();" /><br/>
			</div>
			<input type="button" size="5" value="Calcular Custo" id="calcularCusto" />
			<?php if( login_clube_check($dbc) == true) :?>
				<!-- Squared TWO -->	
				<div class="squaredTwo">
					<span>Adicionar Portes</span>				
					<input type="checkbox" value="Sim" id="squaredTwo" name="pagamentoPortes" />
					<label for="squaredTwo"></label>
				</div>
			<?php endif?>
			<input type="hidden" name="count" id="count" value="1">	
			<input type="hidden" name="clubeSelecionado" id="clubeSelecionado" value="">		
			<br/>
			<?php if (validarCartao($dbc, $cartaoSocio) == true) :?>
				<input type="hidden" name="pagamentoCartaoFop" id="pagamentoCartaoFop" value="Sim">
			<?php else : ?>
				<input type="hidden" name="pagamentoCartaoFop" id="pagamentoCartaoFop" value="Não">
			<?php endif?>		
		</form>
		<?php if (validarCartao($dbc, $cartaoSocio) == true) :?>
			<p id="mensagemCartaoFop">Irão ser cobrados 
				<?php 
				$query = "SELECT preco from anilhasPrecos where id = 4";
				$precoCartaoFop = 0;
				if($stmt = @mysqli_query($dbc, $query)) {
					$row = mysqli_fetch_array($stmt);
					$precoCartaoFop =  $row['preco'];
				}
				echo $precoCartaoFop;
				?>
				&euro; ao associado devido à renovação do Cartão FOP</p>
			<?php endif?>
			<?php if (validar6Pedido($dbc, $vagaNum) == true) :?>
				<p id="mensagemCartaoFop">Irão ser cobrados 
					<?php 
					$query = "SELECT preco from anilhasPrecos where id = 5";
					$preco6Pedido = 0;
					if($stmt = @mysqli_query($dbc, $query)) {
						$row = mysqli_fetch_array($stmt);
						$preco6Pedido =  $row['preco'];
					}
					echo $preco6Pedido;
					?>
					&euro; ao associado devido ao valor adicional no pedido 6</p>
				<?php endif?>
				<?php if( login_clube_check($dbc) == true) :?>
					<div id="divPortes">
						<input type="button" id="mostrarPortesClube" value="Alterar Portes" />
						<form action="alterarPortes.php" method="post" id="formPortesClubes">
							<span>Alterar o preco dos portes cobrados ao socio.</span>
							<input type="text" name="portesClube" id="portesClube"/>
							<input type="submit" name="gravarPortes" value="Gravar" id="gravarPortes"/>

						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?> 
	<?php include ("footer.php"); ?>
