<?php
require_once '../mysql_config.php';

$error_msg = "";



if(isset($_POST['nomeFicha'], $_POST['counterTopico'])) {

    $nomeFicha = filter_input(INPUT_POST, 'nomeFicha', FILTER_SANITIZE_STRING);
    $counterTopico = filter_input(INPUT_POST, 'counterTopico', FILTER_SANITIZE_NUMBER_INT);
    
    $topicosNome = array();
    $topicosPontuacao = array();
    for($i = 0, $j=1; $i < $counterTopico ; $i++){
        if(isset($_POST['topicoNome'.$j], $_POST['pontuacaoTopico'.$j])){
            $topicosNome[$i] = $_POST['topicoNome'.$j];
            $topicosPontuacao[$i] = $_POST['pontuacaoTopico'.$j];
                
        }
        $j++;
    }

        

    $query = "SELECT nomeFicha FROM fichasJulgamento WHERE nomeFicha = '$nomeFicha' LIMIT 1";
	$nomeFichaExistente = '';
	if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $nomeFichaExistente = $row['nomeFicha'];
        if(!empty($nomeFichaExistente)){
            $nomeFicha .= " Copia";
        }
    }
	
    $query = "SELECT MAX(idTopico) as idTopico from topicosJulgamento";
    $last_idTopico =0;
    if($stmt = @mysqli_query($dbc, $query)){
        $row = mysqli_fetch_array($stmt);
        $last_idTopico = $row['idTopico'];
    }
   
    $query = "SELECT MAX(idFicha) as idFicha from fichasJulgamento";
    $last_idFicha =0;
    if($stmt = @mysqli_query($dbc, $query)){
        $row = mysqli_fetch_array($stmt);
        $last_idFicha = $row['idFicha'];
    }
        
    $query = "INSERT INTO topicosJulgamento(topico, pontuacao) VALUES ";
    for ($i =0; $i< $counterTopico; $i++){
        $topico = $topicosNome[$i];
        $pontuacao = $topicosPontuacao[$i];
        $query .= "('$topico', '$pontuacao')";
        if($i != $counterTopico -1){
            $query .= ",";
        }
    }
    if($stmt = @mysqli_query($dbc, $query)) {
        $query = "INSERT INTO fichasJulgamento(nomeFicha) VALUES('$nomeFicha')";
        if($stmt = @mysqli_query($dbc, $query)){
            $last_idFicha +=1;
            $last_idTopico +=1;
            $query = "INSERT INTO fichasTopicosJulgamento VALUES";
            for($i = 0; $i < $counterTopico; $i++){

                $query .= "('$last_idFicha', '$last_idTopico')";
                $last_idTopico +=1;
                
                if($i != $counterTopico -1){
                    $query .= ",";
                }
            }
            if($stmt = @mysqli_query($dbc, $query)){
                header('Location: verFichasJulgamento.php');

            }
        }
        else {

            header('location: error2.php?err=Houve um erro na insercao dos dados na base de dados. Por favor tente novamente.');
        }
    }
    else{
        header('location: error2.php?err=Houve um erro na insercao dos dados na base de dados. Por favor tente novamente.');

    }
       
}
else {
    echo "nao deu";
}



?>
