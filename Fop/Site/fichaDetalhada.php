<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'] )){
	$idFicha = $_POST['source1'];
}

$query = "SELECT fichasTopicosJulgamento.idFicha, fichasJulgamento.nomeFicha, fichasTopicosJulgamento.idTopico, topicosJulgamento.topico, topicosJulgamento.pontuacao FROM `fichasTopicosJulgamento` INNER JOIN topicosJulgamento ON fichasTopicosJulgamento.idTopico = topicosJulgamento.idTopico INNER JOIN fichasJulgamento ON fichasTopicosJulgamento.idFicha = fichasJulgamento.idFicha WHERE fichasTopicosJulgamento.idFicha = '$idFicha'";


$stmt = @mysqli_query($dbc, $query);
if($stmt) {
    
    $dadosFicha = mysqli_fetch_array($stmt);

    $nomeFicha = $dadosFicha['nomeFicha'];
    echo "<h2 id='fichaNomeHeader'>Nome ficha - " . $nomeFicha . "</h2>";
    
    echo "<div id='dadosFichaDiv'>";

    echo "<span class ='spanTopicosHeader'>Topico</span><span class ='spanTopicosHeader'>Pontuacao</span></br>";
    do{
        
        
        echo "<div><span class='spanTopicos'>" . $dadosFicha['topico'] . "</span><span class='spanTopicos'>" . $dadosFicha['pontuacao'] . "</span></div>";
        
  

    }while($dadosFicha = mysqli_fetch_array($stmt));
    echo "</div>";
}
	
?>
<script type="text/javascript">
</script>
