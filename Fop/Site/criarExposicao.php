<?php include ('header.php'); ?>
<?php if (login_check($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Criar Exposição</h1>
		<form method="post" action="criarExposicao.inc.php" id="formCriarExposicao" enctype="multipart/form-data">
			<span>Titulo </span><input type="text" name="titulo" id="titulo" size="50"/><br/>
			<span>Logotipo </span><input type="file" name="logo" id="logo"/><br/>
			<span>Morada </span><input type="text" name="morada" id="morada" size="48"/><br/>
			<span>Data Inicio </span><input type="text" name="dataInicio" id="dataInicio" class ="datepicker" size="10"/>
			<span id="dataFimSpan">Data Fim </span><input type="text" name="dataFim" id="dataFim" class ="datepicker" size="10"/><br/>
            <span id='dataInicioInscricaoSpan'>Inicio Inscricao </span><input type='text' name='dataInicioInscricao' id='dataInicioInscricao' class ='datepicker' size="10"/>
            <span id='dataFimInscricaoSpan'>Fim Inscricao</span><input type='text' name='dataFimInscricao' id='dataFimInscricao' class ='datepicker' size="10"/><br/>
            <?php if(login_colegio_check($dbc) == true) : ?>
			<span>Lista Classes</span><input type="file" name="excel" id="excel"/><br/>
            <?php endif;?>
			<span>Tipo Exposiçao </span>
			<select name="tipoExposicao" id="selectCriarExposicao">
  					<option value="Clube">Clube</option>
 					<option value="Todos">Associados/Não Associados</option>
 					<option value="International">Internacional</option>
 					<option value="Mundial">Mundial</option>
 			</select><br/>

            <br/><br/><span id='spanClubes'><h2>Clubes Organizadores</h2> </span>
 			<span id="spanClubes">Clube </span>
 			<select name="clubes1" id="selectClubeCriarExposicao">
						<option></option>	
						<?php getClubes($dbc)?>						
			</select>
			<input type="button" id="addBtExposicao"  size="5" value="+" onclick="addClube();" /><br/>
			<span id="spanClubes2" style="display:none">Clube 2 </span>
			<select name="clubes2" id="selectClubeCriarExposicao2" class="clubesSelect" style="display:none">
				<option></option>
				<?php getClubes($dbc);?>				
			</select>
			<input type="button" id="removeBtExposicao"  size="5" value="-" onclick="removeClube();" style="display:none" /><br/>

			<span id="spanClubes3" style="display:none">Clube 3 </span> 
			<select name="clubes3" id="selectClubeCriarExposicao3" class="clubesSelect" style="display:none">
				<option></option>	
				<?php getClubes($dbc); ?>			
			</select><br/>

			<span id="spanClubes4" style="display:none">Clube 4 </span> 
			<select name="clubes4" id="selectClubeCriarExposicao4" class="clubesSelect" style="display:none">
				<option></option>
				<?php getClubes($dbc); ?>				
			</select><br/>

			<span id="spanClubes5" style="display:none">Clube 5 </span> 
			<select name="clubes5" id="selectClubeCriarExposicao5" class="clubesSelect" style="display:none">	
				<option></option>
				<?php getClubes($dbc); ?>			
			</select><br/>
			<span id="spanDescricao">Descrição </span><textarea name="descricao" id="descricao" cols="47" rows="4"></textarea><br/>
 			<input type="submit" name="BtCriarExposicao" id="BtCriarExposicao" value="Criar Exposição" /> 

		</form>
	</div>
	<script type="text/javascript">

		var selectTipoExposicao = document.getElementById('selectCriarExposicao');

		var spanClubes1 = document.getElementById('spanClubes1');
		var spanClubes2 = document.getElementById('spanClubes2');
		var spanClubes3 = document.getElementById('spanClubes3');
		var spanClubes4 = document.getElementById('spanClubes4');
		var spanClubes5 = document.getElementById('spanClubes5');

		var selectClube2 = document.getElementById('selectClubeCriarExposicao2');
		var selectClube3 = document.getElementById('selectClubeCriarExposicao3');
		var selectClube4 = document.getElementById('selectClubeCriarExposicao4'); 
		var selectClube5 = document.getElementById('selectClubeCriarExposicao5');

		var removeBt = document.getElementById('removeBtExposicao');

		function addClube(){			
			if(spanClubes4.style.display == ''){
				spanClubes5.style.display = '';
				selectClube5.style.display = '';
			}
			if(spanClubes3.style.display == ''){
				spanClubes4.style.display = '';
				selectClube4.style.display = '';
			}
			if(spanClubes2.style.display == ''){
				spanClubes3.style.display = '';
				selectClube3.style.display = '';

			}
			spanClubes2.style.display = '';
			selectClube2.style.display = '';
			removeBt.style.display = '';
		}

		function removeClube(){			
			if(spanClubes3.style.display == 'none'){
				spanClubes2.style.display = 'none';
				selectClube2.style.display = 'none';
				removeBt.style.display = 'none';
			}
			if(spanClubes4.style.display == 'none'){
				spanClubes3.style.display = 'none';
				selectClube3.style.display = 'none';
			}
			if(spanClubes5.style.display == 'none'){
				spanClubes4.style.display = 'none';
				selectClube4.style.display = 'none';

			}
			spanClubes5.style.display = 'none';
			selectClube5.style.display = 'none';
		}
	</script>

<?php endif;?>
<?php include ("footer.php"); ?>
