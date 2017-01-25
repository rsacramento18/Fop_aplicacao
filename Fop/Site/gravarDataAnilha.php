<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset ($_POST['source1'],$_POST['source1'])){
  $dataNum = ($_POST['source1']);
  $data = $_POST['source2'];
  echo $campo; 
  echo $input;

  $query2= "INSERT INTO datasAnilhas(dataNum, data) Values (6,0000-00-00) ";

  $query = "UPDATE datasAnilhas 
  SET data='$data'
  WHERE dataNum = '$dataNum'";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
      mysqli_stmt_execute($update_stmt);
      $affected_rows = mysqli_stmt_affected_rows($update_stmt);
      if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: INSERT');
    }
    else{
        header('Location: opcoesAnilhas.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: INSERT2');
}
}
?>
