<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Listagens Clube</h1>
		<div id='listagensClube'>
			<form method='post' id="formListagensClube">
				<select id="selectListagensClube" name="selectListagensClube">
					<option value="1">Listagem de Todos os Socios Ordenada por Número de Associado.</option>
					<option value="2">Listagem de Todos os Socios Ordenada por Nome.</option>
					<option value="3">Listagem dos Socios com Quotas em atraso.</option>
					<option value="4">Listagem dos Socios com Quotas a acabar.</option>
				</select>
				<input type="button" name="ListagensClubeBt" value="Pesquisar" onclick="buscarListagem(this.form.selectListagensClube)">
			</form>
			
		</div>
		<div id="displayAndForm">
			<div id="displayListagem"></div>

			<form action="listagensClubePdf.php" id="formListagemParaPdf" method="post" name='formListagemParaPdf' target='_blank' style='display:none;'>
				<input type="hidden" name="valorListagem" id="valorListagem" value="">
				<input type="submit" name="btFormListagemParaPdf" id="btFormListagemParaPdf" value="Ver Listagem em PDF">
			</form>
		</div>

		<script type="text/javascript">
			function buscarListagem(str1) {
			    $(function() {
			        $.ajax({
			            type: 'post',
			            url: 'displayListagemClube.php', //assumes file is in root dir//
			            data: {source1: str1.value},
			            success: function(response) {
			                $("#displayListagem").html(response); 
			                var valorListagem = document.getElementById('valorListagem');
			                var formListagemParaPdf = document.getElementById('formListagemParaPdf');
			                formListagemParaPdf.style.display = "block";
			                valorListagem.value = str1.value;

			            }
			        });
			    });
			}

		</script>
		
	</div>
<?php endif;?>

<?php include ("footer.php"); ?>
