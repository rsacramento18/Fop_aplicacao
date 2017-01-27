<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$idExposicao= $_POST['source1'];
}


$query = "SELECT * from exposicoes where idExposicao = '$idExposicao'";

$stmt = @mysqli_query($dbc, $query);
if($stmt) {

	$dadosExposicao= mysqli_fetch_array($stmt);

    $idExposicao = $dadosExposicao['idExposicao'];

    $excel = $dadosExposicao['excel'];
    $dadosExcel = '';
    if($excel != '') {
        $dadosExcel = csv_to_array($dadosExposicao['excel']); 
        utf8_encode_deep($dadosExcel);        
    }

	echo "<div id='exposicaoFormDiv'>";

    echo "<form method='post' action='alterarExposicao.inc.php' id='formAlterarExposicao' enctype='multipart/form-data'>";
        echo "<input type='hidden' value='$idExposicao' name='idExposicao' ";
    	echo "<span>Titulo </span><input type='text' name='titulo' id='titulo' size='50'/><br/>";
        echo "<span>Logotipo </span><input type='file' name='logo' id='logo'/><br/>";
	    echo "<span>Morada </span><input type='text' name='morada' id='morada' size='48'/><br/>";
        echo "<span>Data Inicio </span><input type='text' name='dataInicio' id='dataInicio' class ='datepicker' size='10'/>";
        echo "<span id='dataFimSpan'>Data Fim </span><input type='text' name='dataFim' id='dataFim' class ='datepicker' size='10'/><br/>";
        echo "<span>Excel Classes</span><input type='file' name='excel' id='excel'/><br/>";
	    echo "<span>Tipo Exposiçao </span>";
        echo "<select name='tipoExposicao' id='selectCriarExposicao'>";
        echo "<option value='Clube'>Clube</option>";
        echo "<option value='Todos'>Associados/Não Associados</option>";
 	    echo "<option value='International'>Internacional</option>";
        echo "</select><br/>";
        echo "<span id='spanClubes'>Clube </span>";
        echo "<select name='clubes1' id='selectClubeCriarExposicao'>";
        echo "<option></option>";
		    getClubes($dbc);
        echo "</select>";
        echo "<input type='button' id='addBtExposicao'  size='5' value='+' onclick='addClube();' /><br/>";
        echo "<span id='spanClubes2' style='display:none'>Clube 2 </span>";
        echo "<select name='clubes2' id='selectClubeCriarExposicao2' class='clubesSelect' style='display:none'>";
        echo "<option></option>";
            getClubes($dbc);
        echo "</select>";
        echo "<input type='button' id='removeBtExposicao'  size='5' value='-' onclick='removeClube();' style='display:none' /><br/>";

        echo "<span id='spanClubes3' style='display:none'>Clube 3 </span>";
        echo "<select name='clubes3' id='selectClubeCriarExposicao3' class='clubesSelect' style='display:none'>";
        echo "<option></option>";
            getClubes($dbc); 
        echo "</select><br/>";
        echo "<span id='spanClubes4' style='display:none'>Clube 4 </span> ";
        echo "<select name='clubes4' id='selectClubeCriarExposicao4' class='clubesSelect' style='display:none'>";
        echo "<option></option>";
            getClubes($dbc); 				
	    echo "</select><br/>";

        echo "<span id='spanClubes5' style='display:none'>Clube 5 </span> ";
        echo "<select name='clubes5' id='selectClubeCriarExposicao5' class='clubesSelect' style='display:none'>	";
        echo "<option></option>";
            getClubes($dbc); 			
	    echo "</select><br/>";
        echo "<span id='spanDescricao'>Descrição </span><textarea name='descricao' id='descricao' cols='47' rows='4'></textarea><br/>";
        echo "<input type='submit' name='BtCriarExposicao' id='BtCriarExposicao' value='Alterar Exposição' /> ";

    echo "</form>";
    echo "<div id='imgExposicaoDetalhada'>";
        echo "<img src='$dadosExposicao[logo]' height='300' width='300'/>";
    echo "</div>";

    echo "<div id='verExcelClasses'>";
        echo "<h2>Ver Excel Classes</h2>";
        $ficheiroEscolhido = explode("/", $dadosExposicao['excel']);
        echo "<p id='ficheiroEscolhido'>Ficheiro carregado: $ficheiroEscolhido[1]</p><br/>";
        echo "<span>Seccao</span><select name='secaoSelect' id='secaoSelect'></select><br/>";
        echo "<input type='button' name='btVerClasses' id='btVerClasses' value='Ver Classes' onclick='verClasses()' /> ";
    echo "</div>";

    echo "<div id='myModal' class='modal'> ";
        echo "<div id='conteudoModal' class='modal-content'>";
            echo "<h2 id='tituloModal' ></h2>"; 
            echo "<span id='closeModal' class='close'>&times;</span>";    

        echo"</div>";
    
    echo"</div>";

    echo "</div>";

    
    ?>
	<script type="text/javascript">

		var selectTipoExposicao = document.getElementById('selectCriarExposicao');

        var nomeExposicao = "<?php  echo $dadosExposicao['titulo']; ?>";
        var morada = "<?php  echo $dadosExposicao['morada']; ?>";
        var dataInicio= "<?php  echo $dadosExposicao['datainicio']; ?>";
        var dataFim= "<?php  echo $dadosExposicao['dataFim']; ?>";
        var clube= "<?php  echo $dadosExposicao['clube1']; ?>";
        var clube2= "<?php  echo $dadosExposicao['clube2']; ?>";
        var clube3 = "<?php  echo $dadosExposicao['clube3']; ?>";
        var clube4 = "<?php  echo $dadosExposicao['clube4']; ?>";
        var clube5 = "<?php  echo $dadosExposicao['clube5']; ?>";
        var descricao = "<?php  echo $dadosExposicao['descricao']; ?>";
        
        document.getElementById('titulo').value = nomeExposicao;
        document.getElementById('morada').value =morada;
        document.getElementById('dataInicio').value =dataInicio;
        document.getElementById('dataFim').value =dataFim;
        document.getElementById('selectClubeCriarExposicao').value =clube;
        document.getElementById('selectClubeCriarExposicao2').value =clube2;
        document.getElementById('selectClubeCriarExposicao3').value =clube3;
        document.getElementById('selectClubeCriarExposicao4').value =clube4;
        document.getElementById('selectClubeCriarExposicao5').value =clube5;
        document.getElementById('descricao').value =descricao;
        
        var dadosExcel= <?php echo json_encode($dadosExcel); ?>;         
        
        console.log(dadosExcel);
        
        var resultObject = search("F2",dadosExcel);
        
        var distinct = searchClassesDistinct(dadosExcel);
        console.log(distinct); 
        console.log(resultObject);

        criarOptionSecao();

		var spanClubes1 = document.getElementById('spanClubes1');
		var spanClubes2 = document.getElementById('spanClubes2');
		var spanClubes3 = document.getElementById('spanClubes3');
		var spanClubes4 = document.getElementById('spanClubes4');
		var spanClubes5 = document.getElementById('spanClubes5');

		var selectClube2 = document.getElementById('selectClubeCriarExposicao2');
		var selectClube3 = document.getElementById('selectClubeCriarExposicao3');
		var selectClube4 = document.getElementById('selectClubeCriarExposicao4'); 
		var selectClube5 = document.getElementById('selectClubeCriarExposicao5');

        var modal = document.getElementById('myModal');  
        var span = document.getElementById("closeModal");

        var tituloModal = document.getElementById('tituloModal');

        if(clube2 != ''){
            document.getElementById('spanClubes2').style.display = '';
            document.getElementById('selectClubeCriarExposicao2').style.display = '';
            document.getElementById('removeBtExposicao').style.display = '';
        } 
        
        if(clube3 != ''){
            document.getElementById('spanClubes3').style.display = '';
            document.getElementById('selectClubeCriarExposicao2').style.display = '';
        } 
        
        if(clube4 != ''){
            document.getElementById('spanClubes4').style.display = '';
            document.getElementById('selectClubeCriarExposicao2').style.display = '';
        } 
        
        if(clube5 != ''){
            document.getElementById('spanClubes5').style.display = '';
            document.getElementById('selectClubeCriarExposicao2').style.display = '';
        } 
        
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
				selectClube2.value = '';
				removeBt.style.display = 'none';
			}
			if(spanClubes4.style.display == 'none'){
				spanClubes3.style.display = 'none';
				selectClube3.style.display = 'none';
				selectClube3.value = '';
			}
			if(spanClubes5.style.display == 'none'){
				spanClubes4.style.display = 'none';
				selectClube4.style.display = 'none';
				selectClube4.value = '';

			}
			spanClubes5.style.display = 'none';
			selectClube5.style.display = 'none';
			selectClube5.value = '';
		}

        function search(nameKey, myArray){
            var obj = new Array();
            for (var i=0, j=0; i < myArray.length; i++) {
                if (myArray[i].secao === nameKey) {
                    obj[j] = myArray[i];
                    j++;
                }
            }
            return obj;
        }    


        function searchClassesDistinct(array){
            var flags = [], output = [], l = array.length, i;
            for( i=0; i<l; i++) {
                if( flags[array[i].secao]) continue;
                flags[array[i].secao] = true;
                output.push(array[i].secao);
            } 
            return output;
        }

        function criarOptionSecao() {

            var sesaoSelect = document.getElementById('secaoSelect');
            var opcoes = searchClassesDistinct(dadosExcel);
            for( var i = 0; i < opcoes.length; i++) {
                var optionOpcao = document.createElement("option");
	        	optionOpcao.text = opcoes[i];
                optionOpcao.value= opcoes[i];
	        	sesaoSelect.appendChild(optionOpcao); 
            }
        }


        function verClasses(){
            var sesaoSelect = document.getElementById('secaoSelect');
            var valor = sesaoSelect.options[sesaoSelect.selectedIndex].value;
            var classes = search(valor, dadosExcel);
            
            tituloModal.innerHTML += "Seccao " + valor;            


            var table = document.createElement("table");
            var trHeader = document.createElement("tr");
            var thClasse = document.createElement("th");
            thClasse.innerHTML = "Classe";
            thClasse.style.width = "1%"; 
            thClasse.style.textAlign= "center"; 
            trHeader.appendChild(thClasse);           

            var thDescricao= document.createElement("th");
            thDescricao.innerHTML = "Descrição";
            thDescricao.style.textAlign= "center"; 

            trHeader.appendChild(thDescricao);

            table.appendChild(trHeader);

            for (var i = 0; i < classes.length; i++){
                var tr = document.createElement("tr");
                var tdClasse = document.createElement("td");
                tdClasse.innerHTML = classes[i].classe;
                tdClasse.style.textAlign = "center";                

                var tdDescricao = document.createElement("td");
                tdDescricao.innerHTML = classes[i].descricao;

                tr.appendChild(tdClasse);
                tr.appendChild(tdDescricao);

                table.appendChild(tr);
                

            }

            document.getElementById("conteudoModal").appendChild(table);

            modal.style.display = "block"; 
           
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
            modal.style.display = "none";
        }
        } 



	</script>

<?php
}
?>





