<?php include ('header.php'); ?>
<?php if (login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true ) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
<?php

if(isset($_POST['source1'])){
	$idExposicao= $_POST['source1'];
}

$userStam = $_SESSION['user'];

$query = "SELECT * from exposicoes where idExposicao = '$idExposicao'";

if(isset($_SESSION['idExposicao'])){
    if($_SESSION['idExposicao']!= $idExposicao){
        $_SESSION['tableAves'] = '';
    }
}

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
    echo "<h1>Inscrever Aves</h1>";
    
    if($dadosExposicao['tipoExposicao'] != 'Clube'){
        echo "<h2>Selecionar Clube</h2><select id='inscreverAvePeloClube'>";
        
        $query = "SELECT * from socios_clubes  where stam = '$userStam'";

        $stmt = @mysqli_query($dbc, $query);
        if($stmt) {

            while ( $row = mysqli_fetch_array($stmt)){;
                $clube = $row['clube'];

                echo "<option value='$clube'>$clube</option>";
            }
        }
        
        echo "</select>";
    }
    else{
         echo "<h2>Selecionar Clube</h2><select id='inscreverAvePeloClube'>";
        
        $query = "SELECT * from socios_clubes  where stam = '$userStam'";

        $stmt = @mysqli_query($dbc, $query);
        if($stmt) {

            while ( $row = mysqli_fetch_array($stmt)){;
                $clube = $row['clube'];
                
                if($clube == $dadosExposicao['clube1'] || $clube == $dadosExposicao['clube2'] || $clube == $dadosExposicao['clube3'] || $clube == $dadosExposicao['clube4'] || $clube == $dadosExposicao['clube5']){ 

                    echo "<option value='$clube'>$clube</option>";
                }
            }
        }
        
        echo "</select>";
    }


    if($dadosExposicao['excel'] != ''){
        echo "<div id='verExcelClasses2'>";
            echo "<h2>Ver Classes</h2>";
            echo "<span>Seccao </span><select name='secaoSelect' id='secaoSelect'></select>";
            echo "<input type='button' name='btVerClasses' id='btVerClasses' value='Ver Classes' onclick='verClasses()' /> ";
        echo "</div>";
    }

    echo "<div id='adicionarAves'>";
        echo "<h2>Adicionar Aves</h2>";
        echo "<span>Seccao</span><select name='selectAdicionarAves' id='selectAdicionarAves'></select>";
        echo "<input type='number' id='classeInput' name='classeInput' placeholder='Classe' oninput='mostrarDescricao();' size='3'/>";
        echo "<input type='text' id='descricaoClasse' name='descricaoClasse' placeholder='Descricao' disabled='true'/>";
        echo "<input type='button' id='btAdicionarAve' name='btAdicionarAve' value='+' onclick='adicionarAveFunction();' />";
    echo "</div>";

    echo "<div id='avesInscritas'>";
        echo "<h2>Aves a inscrever</h2>";
        if(isset($_SESSION["tableAves"])){
            echo "<table id='tableAvesInscritas'>";
                echo $_SESSION["tableAves"];
            echo "</table>";
        }
        else {
            echo "<table id='tableAvesInscritas'>";
                echo "<tr><th class='seccao'>Seccao</th><th class='classe'>Classe</th><th class='descricao'>Descricao</th><th class='anilha'>Anilha</th><th class='ano'>Ano</th><th class='preco'>Preco</th><th></th></tr>";
            echo "</table>";
        }
        echo "<form method='post' action='inscreverAves.inc.php' id='formInscreverAves'>";

        echo "<input type='hidden' value='nao ha clube' name='clubeInscreverAves' id='clubeInscreverAves'/>";
        echo "<input type='hidden' value='$userStam' name='stamInscreverAves' id='stamInscreverAves'/>";
        echo "<input type='hidden' value='$idExposicao' name='idExposicaoInscreverAves' id='idExposicaoInscreverAves'/>";
        
        echo "<input type='button' id='btInscreverAves'  value='Inscrever Aves' onclick='validarAves();' />";
        echo "</form>";
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
        var idExposicao = <?php echo $idExposicao ?>;
        
        var numGaiola= 0; 
        
        console.log(dadosExcel);
        
        var resultObject = search("F2",dadosExcel);
        
        var distinct = searchClassesDistinct(dadosExcel);

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
            trHeader.appendChild(thClasse);           80

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
            descricaoClasse.value = searchSecaoClasse(seccao, classe, dadosExcel); 
        }

        

        function adicionarAveFunction(){
            var seccao = document.getElementById('selectAdicionarAves').value;
            var classe = document.getElementById('classeInput').value;
            var descricao = descricaoClasse.value;
            var table = document.getElementById('tableAvesInscritas');
            
            
            if(seccao != '' && classe != '' && descricao != ''){
                if(classe % 2 == 0 ){
                    numGaiola++;        
            
                    var tableRow =  "<tr class='singleRow'><td class='seccao'>" + seccao + "</td><td class='classe'>" + classe + "</td><td class='descricao'>" + descricao + "</td><td class='anilha'><input class='guardarDados' type='number' id='numAnilha' /></td><td class='ano'><input class='guardarDados' type='number' id='anoAve'/></td><td class='preco'><input class='guardarDados' type='number' id='precoAve'/><p>€</p></td><td><input type='button' class='btRemoverSingle' value='-' /></tr>";

                    table.innerHTML += tableRow;
                }
                else {
                    var tableRow = '';
                    for(var i = 0; i < 4; i++){
                        numGaiola++;
                        

                        if(i==0){ 
                            tableRow +=  "<tr class='equipaRow'><td class='seccao'>" + seccao + "</td><td class='classe'>" + classe + "</td><td class='descricao'>" + descricao + "</td><td class='anilha'><input  class='guardarDados' type='number' id='numAnilha'/></td><td class='ano'><input class='guardarDados' type='number' id='anoAve'/></td><td class='preco'/><input class='guardarDados' type='number' id='precoAve'/><p>€</p><td><input type='button' class='btRemoverSingle' value='-' /></td></td></tr>";
                        }
                        else {
                            tableRow +=  "<tr class='equipaRow'><td class='seccao'>" + seccao + "</td><td class='classe'>" + classe + "</td><td class='descricao'>" + descricao + "</td><td class='anilha'><input class='guardarDados' type='number' id='numAnilha'/></td><td class='ano'><input class='guardarDados' type='number' id='anoAve'/></td><td class='preco'><input class='guardarDados' type='number' id='precoAve'/><p>€</p><td></td></td></tr>";

                        } 
                        
                    }
                    var tbody = document.createElement('tbody');
                    tbody.innerHTML = tableRow ;
                        

                    table.appendChild(tbody);
                    console.log(table);
                }
                $.ajax({
                    type:'POST',
                    url:'update.php',
                    data: {tableAves: table.innerHTML, exposicao: idExposicao},
                    success:function(response){
                    }
                }); 
                window.scrollTo(0,document.body.scrollHeight);
            }

        }
        
        $('#tableAvesInscritas').on("change paste keyup", '.guardarDados', function(){
            this.setAttribute("value", this.value);
            var table = document.getElementById('tableAvesInscritas');
            $.ajax({
                    type:'POST',
                    url:'update.php',
                    data: {tableAves: table.innerHTML, exposicao: idExposicao},
                    success:function(response){
                    }
                }); 


        }); 

        
        
        window.onkeypress = function(event) {
            if (event.keyCode == 13) {
               adicionarAveFunction(); 
            }
        }

        window.onkeypress = function(event) {
            if (event.keyCode == 13 && event.shiftKey ) {
                var input = document.getElementById('classeInput');
                input.value = null;
                input.focus();
                input.scrollIntoView(); 
            }
        }
        

        $('#tableAvesInscritas').on("click", '.btRemoverSingle', function(){
            var table = document.getElementById('tableAvesInscritas');
            var tr = this.parentNode.parentNode.parentNode;
            tr.parentNode.removeChild( tr );
            $.ajax({
                type:'POST',
                url:'update.php',
                data: {tableAves: table.innerHTML, exposicao: idExposicao},
                success:function(response){
                }
            }); 
            console.log(table.innerHTML)

        }); 
        

        function validarAves(){
            var formInscreverAves = document.getElementById('formInscreverAves');
            var currentYear = new Date().getFullYear();
            var avesParaInscrever = document.getElementById('tableAvesInscritas').children;
            var aves = new Array();

            var clubeInscreverAves = document.getElementById('clubeInscreverAves');

            var e = document.getElementById("inscreverAvePeloClube");
            var strUser = e.options[e.selectedIndex].value; 
            
            clubeInscreverAves.value = strUser;

            console.log(clubeInscreverAves.value);            

            for (var i = 1, j = 0; i < avesParaInscrever.length; i++){
                if(avesParaInscrever[i].children.length == 1){
                    if(isNaN(avesParaInscrever[i].children[0].children[3].children[0].valueAsNumber)){
                        alert("Nao introduziu nenhum valor no campo Anilha.");
                        return;
  
                    }
                    if(parseInt(avesParaInscrever[i].children[0].children[4].children[0].valueAsNumber) > parseInt(currentYear) || isNaN(avesParaInscrever[i].children[0].children[4].children[0].valueAsNumber)  ){
                        alert("Nao introduziu nenhum valor no campo ano ou o ano da ave e superior ao ano actual.");
                        return;
                    }
                    if(!isNaN(avesParaInscrever[i].children[0].children[5].children[0].valueAsNumber)){
                        if(parseInt(avesParaInscrever[i].children[0].children[5].children[0].valueAsNumber) < 0  ){
                            alert("O preco tem que ser um valor positivo");
                            return;
                        }
                    }
                    
                    var ave = new Array();
                    ave[0] = avesParaInscrever[i].children[0].children[0].innerHTML;
                    ave[1] = avesParaInscrever[i].children[0].children[1].innerHTML;
                    ave[2] = avesParaInscrever[i].children[0].children[3].children[0].valueAsNumber;
                    ave[3] = avesParaInscrever[i].children[0].children[4].children[0].valueAsNumber;
                    ave[4] = avesParaInscrever[i].children[0].children[5].children[0].valueAsNumber;
                    aves[j] = ave;
                    j++;
                }
                else {
                    for(var h = 0; h < 4; h++){
                        if(isNaN(avesParaInscrever[i].children[0].children[3].children[0].valueAsNumber)){
                            alert("Nao introduziu nenhum valor no campo Anilha.");
                            return;
  
                        }
                        if(parseInt(avesParaInscrever[i].children[0].children[4].children[0].valueAsNumber) > parseInt(currentYear) || isNaN(avesParaInscrever[i].children[0].children[4].children[0].valueAsNumber)  ){
                            alert("Nao introduziu nenhum valor no campo Ano ou o Ano da ave e superior ao ano actual");
                            return;
                        }
                        if(!isNaN(avesParaInscrever[i].children[0].children[5].children[0].valueAsNumber)){
                            if(parseInt(avesParaInscrever[i].children[0].children[5].children[0].valueAsNumber) < 0  ){
                                alert("O preco tem que ser um valor positivo");
                                return;
                            }
                        }

                        var ave = new Array();
                        ave[0] = avesParaInscrever[i].children[h].children[0].innerHTML;
                        ave[1] = avesParaInscrever[i].children[h].children[1].innerHTML;
                        ave[2] = avesParaInscrever[i].children[h].children[3].children[0].valueAsNumber;
                        ave[3] = avesParaInscrever[i].children[h].children[4].children[0].valueAsNumber;
                        ave[4] = avesParaInscrever[i].children[h].children[5].children[0].valueAsNumber;
                        aves[j] = ave;
                        j++;

                    }
                }    
            }
           $.ajax({
                type:'POST',
                url:'update2.php',
                data: {avesphp: aves},
                success:function(response){
                }
            }); 

            

           formInscreverAves.submit(); 

            console.log(aves);
            
        }
        
	</script>

<?php
}
?>
<?php endif;?>
<?php include ("footer.php"); ?>
