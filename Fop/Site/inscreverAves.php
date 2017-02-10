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

    $numGaiola = $dadosExposicao['numGaiola'];

    $idJuiz = $dadosExposicao['idJuiz'];

    $excel = $dadosExposicao['excel'];
    $dadosExcel = '';
    if($excel != '') {
        $dadosExcel = csv_to_array($dadosExposicao['excel']); 
        utf8_encode_deep($dadosExcel);        
    }
    if($dadosExposicao['excel'] != ''){
        echo "<div id='verExcelClasses2'>";
            echo "<h2>Ver Classes</h2>";
            echo "<span>Seccao </span><select name='secaoSelect' id='secaoSelect'></select>";
            echo "<input type='button' name='btVerClasses' id='btVerClasses' value='Ver Classes' onclick='verClasses()' /> ";
        echo "</div>";
    }

    echo "<div id='adicionarAves'>";
        echo "<h2>Inscrever Aves</h2>";
        echo "<span>Seccao</span><select name='selectAdicionarAves' id='selectAdicionarAves'></select>";
        echo "<input type='number' id='classeInput' name='classeInput' placeholder='Classe' oninput='mostrarDescricao();' size='3'/>";
        echo "<input type='text' id='descricaoClasse' name='descricaoClasse' placeholder='Descricao' disabled='true'/>";
        echo "<input type='button' id='btAdicionarAve' name='btAdicionarAve' value='+' onclick='adicionarAveFunction();'/>";
    echo "</div>";

    echo "<div id='avesInscritas'>";
        echo "<h2>Aves inscritas</h2>";
    
    echo "</div>";
    
	
    echo "<div id='myModal' class='modal'> ";
        echo "<div id='conteudoModal' class='modal-content'>";
            echo "<h2 id='tituloModal' ></h2>"; 
            echo "<span id='closeModal' class='close'>&times;</span>";    
        echo"</div>";
    echo"</div>";

    ?>
    <script type="text/JavaScript" src="js/functionsJS.js"></script>
	<script type="text/javascript">

		        
        var dadosExcel= <?php echo json_encode($dadosExcel); ?>;         
        var descricaoClasse = document.getElementById('descricaoClasse');
        
        console.log(dadosExcel);
        
        var resultObject = search("F2",dadosExcel);
        
        var distinct = searchClassesDistinct(dadosExcel);
        console.log(distinct); 
        console.log(resultObject);

        criarOptionSecao();
        criarOptionSecao2();

        var modal = document.getElementById('myModal');  
        var span = document.getElementById("closeModal");

        var tituloModal = document.getElementById('tituloModal');

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

        function searchSecaoClasse(nameKey, nameKey2, myArray){
            var obj =  "";
            for (var i=0, j=0; i < myArray.length; i++) {
                if (myArray[i].secao === nameKey && myArray[i].classe === nameKey2) {
                    obj = myArray[i].descricao;
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
        
        function criarOptionSecao2() {

            var sesaoSelect = document.getElementById('selectAdicionarAves');
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
        
        function mostrarDescricao (){
            var seccao = document.getElementById('selectAdicionarAves').value;
            var classe = classeInput.value;
            console.log(searchSecaoClasse(seccao, classe, dadosExcel));
            descricaoClasse.value = searchSecaoClasse(seccao, classe, dadosExcel); 
        }



	</script>

<?php
}
?>
