<?php
require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();

if(isset($_POST['normal'])){
  $precoNormal = $_POST['normal'];
  
  $query = "UPDATE anilhasPrecos SET preco='$precoNormal'
  WHERE id = 1";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
      mysqli_stmt_execute($update_stmt);
      $affected_rows = mysqli_stmt_affected_rows($update_stmt);
      if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Normal');
    }
    else{
        header('Location: precosAnilhas.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Normal');
}

}
else if(isset($_POST['reforcada'])){
  $precoReforcada = $_POST['reforcada'];

  $query = "UPDATE anilhasPrecos SET preco='$precoReforcada'
  WHERE id = 2";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
      mysqli_stmt_execute($update_stmt);
      $affected_rows = mysqli_stmt_affected_rows($update_stmt);
      if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: O valor introduzido não é um numero.');
    }
    else{
        header('Location: precosAnilhas.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Reforcada');
}

}
else if(isset($_POST['aco_inox'])){
  $precoAco_inox = $_POST['aco_inox'];

  $query = "UPDATE anilhasPrecos SET preco='$precoAco_inox'
  WHERE id = 3";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
      mysqli_stmt_execute($update_stmt);
      $affected_rows = mysqli_stmt_affected_rows($update_stmt);
      if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Reforcada.');
    }
    else{
        header('Location: precosAnilhas.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Reforcada.');
}

}
else if(isset($_POST['6Pedido'])){
    $precoAco_inox = $_POST['6Pedido'];

    $query = "UPDATE anilhasPrecos SET preco='$precoAco_inox'
    WHERE id = 5";
    if ($update_stmt = mysqli_prepare($dbc, $query)){
        mysqli_stmt_execute($update_stmt);
        $affected_rows = mysqli_stmt_affected_rows($update_stmt);
        if (! $affected_rows == 1) {
            header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Reforcada.');
        }
        else{
            header('Location: precosAnilhas.php');
        }   
    }
    else {

        header('Location: error.php?err=DataSet failure: Gravar Preco Anilhas Reforcada.');
    }

}
else if(isset($_POST['quantidadeMinimaNormal'])){
  $quantidade = $_POST['quantidadeMinimaNormal'];

  $query = "UPDATE quantidadeMinima SET quantidade='$quantidade'
  WHERE id = 1";
  if ($update_stmt = mysqli_prepare($dbc, $query)){
      mysqli_stmt_execute($update_stmt);
      $affected_rows = mysqli_stmt_affected_rows($update_stmt);
      if (! $affected_rows == 1) {
        header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
    }
    else{
        header('Location: precosAnilhas.php');
    }   
}
else {

    header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
}
}
else if(isset($_POST['quantidadeMinimaReforcada'])){
    $quantidade = $_POST['quantidadeMinimaReforcada'];

    $query = "UPDATE quantidadeMinima SET quantidade='$quantidade'
    WHERE id = 2";
    if ($update_stmt = mysqli_prepare($dbc, $query)){
        mysqli_stmt_execute($update_stmt);
        $affected_rows = mysqli_stmt_affected_rows($update_stmt);
        if (! $affected_rows == 1) {
            header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
        }
        else{
            header('Location: precosAnilhas.php');
        }   
    }
    else {

        header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
    }
}
else if(isset($_POST['quantidadeMinimaAco'])){
    $quantidade = $_POST['quantidadeMinimaAco'];

    $query = "UPDATE quantidadeMinima SET quantidade='$quantidade'
    WHERE id = 3";
    if ($update_stmt = mysqli_prepare($dbc, $query)){
        mysqli_stmt_execute($update_stmt);
        $affected_rows = mysqli_stmt_affected_rows($update_stmt);
        if (! $affected_rows == 1) {
            header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
        }
        else{
            header('Location: precosAnilhas.php');
        }   
    }
    else {

        header('Location: error.php?err=DataSet failure: Gravar Quantidade Minima das Anilhas.');
    }
}
else if(isset($_POST['cartaoFop'])){
    $cartaoFop = $_POST['cartaoFop'];

    $query = "UPDATE anilhasPrecos SET preco='$cartaoFop'
    WHERE id = 4";
    if ($update_stmt = mysqli_prepare($dbc, $query)){
        mysqli_stmt_execute($update_stmt);
        $affected_rows = mysqli_stmt_affected_rows($update_stmt);
        if (! $affected_rows == 1) {
            header('Location: error.php?err=DataSet failure: Gravar o novo preco do cartao FOP.');
        }
        else{
            header('Location: precosAnilhas.php');
        }   
    }
    else {

        header('Location: error.php?err=DataSet failure: Gravar o novo preco do cartao FOP.');
    }
}
?>