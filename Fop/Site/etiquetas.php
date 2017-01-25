<?php
require('FPDF/tfpdf.php');
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();
if(isset($_SESSION['clube'])){

    $clube = $_SESSION['clube'];

    $query = "SELECT * FROM clubes WHERE nome_clube = '$clube'";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $nome_clube = $row['nome_clube'];
        $sigla = $row['sigla'];
        $morada = $row['morada'];
        $img = $row['imagem'];
        $site = $row['site'];
        $email = $row['email'];
    }


    $pdf = new tFPDF('P','mm','A4','','', '', '', '', '');

    $pdf->AddPage();

    $pdf->SetMargins(0,0,0);
    $pdf->SetAutoPageBreak(TRUE, 0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Exo','','Exo-Regular.ttf',true);
    $pdf->AddFont('Exo', 'B', 'Exo-Bold.ttf', true);
    $pdf->AddFont('Exo', 'I', 'Exo-Italic.ttf', true);

    $pdf->SetXY(0 , 0);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();

    $cell_width = 105;
    $cell_height = 12;

    $esquerdoDireito = 0;
    $counter = 0;

    $query= "SELECT * FROM socios
    LEFT JOIN socios_clubes
    ON socios.stam = socios_clubes.stam
    WHERE socios_clubes.clube = '$clube' AND socios.email = ''  
    ORDER BY socios.stam ASC";
    $stmt = @mysqli_query($dbc, $query);
    if($stmt) {


        while($row = mysqli_fetch_array($stmt)) {

            $pdf->SetFont('Exo', 'B', 11);
            $pdf->SetTextColor(0,0,0);

            $morada = $row['morada'];
            $cod_postal = $row['cod_postal'] ;
            $Localidade = $row['Localidade'];

            $pdf->MultiCell($cell_width,$cell_height, $morada . "\n" . $cod_postal . "\n" .  $Localidade,1,'C');

            if($esquerdoDireito == 0){
                if($counter == 8){
                    $current_y = 0;
                    $counter = 0;
                }

                $pdf->SetXY(105 , $current_y);
                $esquerdoDireito = 1;
                $counter++;
            }
            else{

                $current_y = $current_y + 3*$cell_height+0.1;
                $pdf->SetXY(0 , $current_y);
                $esquerdoDireito = 0;
            }
            
        }

    }


    $pdf->Output();
}
else {
    echo "nao deu";
}
?>