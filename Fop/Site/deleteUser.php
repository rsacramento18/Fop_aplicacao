<?php

require_once('../mysql_config.php');

$user = ($_POST['q']);

$query = "DELETE FROM users 
WHERE user_id = '$user'";
$stmt = @mysqli_query($dbc, $query);
if($stmt) {
    echo "<p>O utilizador foi removido com sucesso</p>";
}
else {
    echo "Erro o utilizador não foi removido com sucesso";
}
?>
