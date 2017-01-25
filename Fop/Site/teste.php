<?php
require_once 'functions.php';


$arrayV = csv_to_array('classes/csvListagem.csv');


print_r($arrayV[0]['classe']);





?>
