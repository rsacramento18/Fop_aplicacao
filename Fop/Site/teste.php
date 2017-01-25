<?php
require_once 'excel_reader2.php';

$excel = new Spreadsheet_Excel_Reader("classes/LISTAGEM.xls");

// Test to see the excel data stored in $sheets property
echo '<pre>';
var_export($excel->sheets);
echo '</pre>';








?>
