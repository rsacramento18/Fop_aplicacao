<?php

require_once('../mysql_config.php');

$users = ($_POST['q']);

$query = "SELECT user_id, privilegio, clube
FROM users
WHERE user_id = '$users'
LIMIT 1";
$stmt = @mysqli_query($dbc, $query);
if($stmt) {

    echo "<table>";
    while($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['privilegio'] . "</td>";
        echo "<td>" . $row['clube'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
