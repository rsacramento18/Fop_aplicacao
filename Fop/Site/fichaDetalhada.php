<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'] )){
	$idFicha = $_POST['source1'];
}
$quey = "SELECT COUNT(*), counter from fichasTopicosJulgamento INNER JOIN topicosJulgamento ON fichasTopicosJulgamento.idTopico=topicosJulgamento.idTopico WHERE idFicha='$idFicha'";

$stmt = @mysqli_query($dbc, $query);
$counter = 0;
if($stmt) {
    $row = mysqli_fetch_array($dbc, $query);
    $counter = $row['counter'];
}

$query = "SELECT fichasTopicosJulgamento.idFicha, fichasJulgamento.nomeFicha, fichasTopicosJulgamento.idTopico, topicosJulgamento.topico, topicosJulgamento.pontuacao FROM `fichasTopicosJulgamento` INNER JOIN topicosJulgamento ON fichasTopicosJulgamento.idTopico = topicosJulgamento.idTopico INNER JOIN fichasJulgamento ON fichasTopicosJulgamento.idFicha = fichasJulgamento.idFicha WHERE fichasTopicosJulgamento.idFicha = '$idFicha'";


$stmt = @mysqli_query($dbc, $query);
if($stmt) {
    
    $dadosFicha = mysqli_fetch_array($stmt);

    $nomeFicha = $dadosFicha['nomeFicha'];
    echo "<div id='dadosFichaDiv' style='display:block'>";

    echo "<h2 id='fichaNomeHeader'>Nome ficha - " . $nomeFicha . "</h2>";
    
    echo "<span class ='spanTopicosHeader'>Topico</span><span class ='spanTopicosHeader'>Pontuacao</span></br>";

    do{
        
        echo "<div><span class='spanTopicos'>" . $dadosFicha['topico'] . "</span><span class='spanTopicos'>" . $dadosFicha['pontuacao'] . "</span></div>";

    }while($dadosFicha = mysqli_fetch_array($stmt));
    
    echo "<input type='button' id='btAlterarFicha' name='btAlterarFicha' value='Alterar Ficha de Julgamento' onclick ='showForm();'/>";

    echo "</div>";
    
    echo "<div id='divAlterarFicha' style='display:none'>";

    echo "<form id='formAlterarFicha' action='formAlterarFicha.inc.php' method='post' name='formAlterarFicha'>";

      echo "<input type ='text' name='nomeFicha' id='nomeFicha' placeHolder='Nome da Ficha' style='margin:10px'/><br /> ";

      echo "<input type='text' name='topicoNome1' id='topicoNome1' placeholder='Nome Topico' style='margin:10px; width:300px'/>";

      echo "<input type='number' name='pontuacaoTopico1' id='pontuacaoTopico1' style='margin:10px; width:110px' placeholder='Pontuacao'/>";

      echo "<input type='button' name='btAdicionarTopico' id='btAdicionarTopico' value='+' onclick='adicionarTopico();'/><br />";
      
      echo "<input type='button' name='btCriarFicha' id='btCriarFicha' value='Alterar os Dados' onclick='formSubmit(); ' style='margin:10px'/>";


    echo "</form>";
    
    echo "</div>";

}

?>
<script type="text/javascript">
    var counter = 1;
    var formFicha = document.getElementById("formCriarFichaJulgamento");
    var btAdicionarTopico = document.getElementById("btAdicionarTopico");
    var btCriarFicha = document.getElementById("btCriarFicha");

    var dadosFichaDiv = document.getElementById("dadosFichaDiv");
    var divs = dadosFichaDiv.getElementsByTagName('div');
    console.log(divs);
    for(var i = 0, j = 1; i < divs.length; i++, j++){
        if(j ==1 && i==0){
            var topicoNome = document.getElementById('topicoNome1');
            var topicoPontuacao = document.getElementById('pontuacaoTopico1');
            var child = divs[0].getElementsByTagName('span');
            topicoNome.value = child[0].innerHTML;
            topicoPontuacao.value = child[1].innerHTML;
            
        }
        else {
            counter +=1;
            var child = divs[i].getElementsByTagName('span');

            var newDiv = document.createElement("div");
            newDiv.id = "divLinha"+counter;

            var input = document.createElement("input");
            input.type = "text";
            input.name = "topicoNome" + counter;
            input.id = "topicoNome" + counter;
            input.value = child[0].innerHTML;
            input.style.margin= "10px";
            input.style.width=  "300px";

            var input2 = document.createElement("input");
            input2.type = "number";
            input2.name = "pontuacaoTopico" + counter;
            input2.id = "pontuacaoTopico" + counter;
            input2.style.margin= "14px";
            input2.style.width=  "110px";
            input2.value = child[1].innerHTML;
            
            btCriarFicha.before(newDiv)

            newDiv.appendChild(input);
            newDiv.appendChild(input2);

            if(counter == 2){

                newDiv.innerHTML += "<input type='button' name='btRemoverTopico' id='btRemoverTopico' value='-' onclick='removerTopico();'/>";
            }
            newDiv.innerHTML += "<br />";
            console.log(counter);
            document.getElementById('topicoNome'+counter).value = child[0].innerHTML;
            document.getElementById('pontuacaoTopico'+counter).value = child[1].innerHTML;
        }
    }
    
     

    function removerTopico(){
        if(counter > 1){    
            var div = document.getElementById('divLinha'+counter);
                
            console.log(div.id); 

            div.parentNode.removeChild( div );
                    
            counter -= 1;
        }
    }

    function adicionarTopico(){
        counter += 1;
        if(counter <= 10){ 
            var newDiv = document.createElement("div");
            newDiv.id = "divLinha"+counter;
            var input = document.createElement("input");
            input.type = "text";
            input.name = "topicoNome" + counter;
            input.id = "topicoNome" + counter;
            input.placeholder = "Nome Topico";
            input.style.margin= "10px";
            input.style.width=  "300px";

            var input2 = document.createElement("input");
            input2.type = "number";
            input2.name = "pontuacaoTopico" + counter;
            input2.id = "pontuacaoTopico" + counter;
            input2.style.margin= "14px";
            input2.style.width=  "110px";
            input2.placeholder = "Pontuacao";
            
            btCriarFicha.before(newDiv)

            newDiv.appendChild(input);
            newDiv.appendChild(input2);

            if(counter == 2){

                newDiv.innerHTML += "<input type='button' name='btRemoverTopico' id='btRemoverTopico' value='-' onclick='removerTopico();'/>";
            }
            newDiv.innerHTML += "<br />";
            console.log(counter);
        }
        else {
            counter -=1;
        }
    }


    function formSubmit(){
        var hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "counterTopico";
        hidden.value = counter;
        formFicha.appendChild(hidden);
        pontuacaoTotal = 0;
        for(var i = 1;  i < counter+1; i++ ){
            var pontuacao = document.getElementById("pontuacaoTopico"+i);
            pontuacaoTotal += pontuacao.value;
            console.log(pontuacao);
        }
        if(pontuacao == 100){
            formFicha.submit();
        }
        else{
            alert("A pontuacao total de todos os topicos e " + pontuacao.value + ". A pontuacao total tem que dar 100.");
        }

    }


    function showForm(){
        var dadosFichaDiv = document.getElementById("dadosFichaDiv");
        var divAlterarFicha = document.getElementById("divAlterarFicha");
        
        if( dadosFichaDiv.style.display = 'block' ){
            dadosFichaDiv.style.display = 'none';
            divAlterarFicha.style.display = 'block';
        }
    }


</script>
