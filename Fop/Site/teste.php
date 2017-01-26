<?php
require_once 'functions.php';


$array = csv_to_array('classes/SadoTejo.csv');


/* $array = mb_convert_encoding($array, 'UTF-8', mb_detect_encoding($array)); */



function utf8_encode_deep(&$input) {
    if (is_string($input)) {
        $input = utf8_encode($input);
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            utf8_encode_deep($value);
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));

        foreach ($vars as $var) {
            utf8_encode_deep($input->$var);
        }
    }
}


utf8_encode_deep($array);
print_r($array);



?>
