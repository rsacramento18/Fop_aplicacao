<?php

require_once('../mysql_config.php');

$user = ($_POST['q']);

$query = "SELECT block from users where user_id = '$user'";
$stmt = @mysqli_query($dbc, $query);{
    if($stmt) {
        $row = mysqli_fetch_array($stmt);
        $block = $row['block'];
        if($block == 'Nao'){

            $query = "UPDATE users set block = 'Sim' 
            WHERE user_id = '$user'";
            $stmt = @mysqli_query($dbc, $query);
            if($stmt) {
                
            }
        }
        else{

            $query = "UPDATE users set block = 'Nao' 
            WHERE user_id = '$user'";
            $stmt = @mysqli_query($dbc, $query);
            if($stmt) {
             
            }

        }
    }
    else {
        echo "Erro!";
    }
}
?>