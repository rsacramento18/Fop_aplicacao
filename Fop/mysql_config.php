<?php
ini_set('default_charset', 'UTF-8');

define('BD_USER', 'root');
define('BD_PASSWORD', 'Agaporni1991');
define('BD_HOST', 'localhost');
define("BD_NAME", 'fop_aplicacao');

$dbc = @mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME)
or die('Could not connect to mysql ' . mysqli_connect_error());
$dbc->set_charset("utf8");

?>
