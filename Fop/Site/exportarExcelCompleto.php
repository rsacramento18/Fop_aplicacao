<?php
require_once('../mysql_config_2.php');
$xls_filename = 'baseDadosSocios'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name


/***** DO NOT EDIT BELOW LINES *****/ 
// Create MySQL connection
$sql = "SELECT (socios.stam) as STAM, (socios.nome) as Nome, (socios.email) as Email, (socios.bi) as 'BI/CC', (socios.pais)  as 'Pais' , (socios.regiao) as 'Regiao', (socios.morada) as Morada, (socios.cod_postal) as 'Codigo Postal', socios.Localidade, (socios.telefone1) as Telefone, (socios.telefone2) as Telemovel, (socios.cartaoFop) as 'Cartoo FOP', (socios_clubes.clube) as Clube, (socios_clubes.membro_Num) as 'Membro Numero', (socios_clubes.data_adesao) as 'Data de Adesao'
FROM socios 
INNER JOIN socios_clubes
ON socios.stam = socios_clubes.stam
ORDER BY socios.stam ASC";
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Failed to connect to MySQL:<br />" . mysql_error() . "<br />" . mysql_errno());
// Select database
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Failed to select database:<br />" . mysql_error(). "<br />" . mysql_errno());
// Execute query
$result = @mysql_query($sql,$Connect) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());

// Header info settings
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");

/***** Start of Formatting for Excel *****/
// Define separator (defines columns in excel &amp; tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++) {
    echo mysql_field_name($result,$i) . "\t";
}
print("\n");    
//end of printing column names  
//start while loop to get data
while($row = mysql_fetch_row($result))
{
    $schema_insert = "";
    for($j=0; $j<mysql_num_fields($result);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}   
?>