<?php
require('FPDF/tfpdf.php');
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

if(isset($_POST['valorListagem'])){
    $listagem = $_POST['valorListagem'];
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

    class PDF extends tFPDF
    {
        // Page header
        function Header()
        {
            // Logo
            $this->Image($this->image,10,10, 25, 25);


            $this->AddFont('Exo','','Exo-Regular.ttf',true);
            $this->AddFont('Exo', 'B', 'Exo-Bold.ttf', true);
            $this->AddFont('Exo', 'I', 'Exo-Italic.ttf', true);

            $this->SetFont('Exo','B',13);
            $this->SetTextColor(45,62,165);

            
            $this->Cell(50);
            $this->Cell(120,10,'Federação Ornitológica Portuguesa Cultural e',0,1,'C');
            $this->Cell(86);
            $this->Cell(40,10,'Desportiva',0,1,'C');
            $this->SetFont('Exo','',12);
            $this->Cell(70);
            $this->Cell(70,10,'Listagem de Clube',0,1,'C');

            $this->SetFont('Exo', 'B', 10);
            $this->SetTextColor(0,0,0);
            $this->ln(10);
            $this->Cell(5);
            $this->Cell(25,10, (string)$this->sigla);
            $this->Cell(50,10, (string)$this->nome_clube, 0, 1);

            $this->Cell(5);
            $this->Cell(25,10, 'Morada');
            $this->Cell(50,10, (string)$this->morada, 0, 1);

            $this->SetFont('Exo', '', 10);
        }

        // Page footer
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Exo','I',8);
            // Page number
            $this->Cell(0,10,'Todos os direitos reservados à FOP - Federação Ornitológica Portuguesa',0,0,'C'); 
            $this->Cell(5,0);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R'); 
        }
    }

    $pdf = new PDF('P','mm','A4','0',$img, $tipoAnilha, $sigla, $nome_clube, $morada);

    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->AddFont('Exo','','Exo-Regular.ttf',true);
    $pdf->AddFont('Exo', 'B', 'Exo-Bold.ttf', true);
    $pdf->AddFont('Exo', 'I', 'Exo-Italic.ttf', true);

    if($listagem == '1' || $listagem == '3' || $listagem == '4'){

        $pdf->SetFont('Exo', 'B', 10);
        $pdf->ln(15);
        $pdf->Cell(20);
        $pdf->Cell(30,5, 'Associado No.');

        $pdf->Cell(10);
        $pdf->Cell(65,5, 'Nome');

        $pdf->Cell(20, 0);
        $pdf->Cell(20,5, 'Stam',0,1);

        $pdf->SetFillColor(132,1,1);
        $pdf->Cell(190,0.5,'',0,1,'C',true);
    
    }
    else if($listagem == '2'){
        $pdf->SetFont('Exo', 'B', 10);
        $pdf->ln(15);
        $pdf->Cell(10);
        $pdf->Cell(65,5, 'Nome');

        $pdf->Cell(20);
        $pdf->Cell(30,5, 'Associado No.');

        $pdf->Cell(20, 0);
        $pdf->Cell(20,5, 'Stam',0,1);

        $pdf->SetFillColor(132,1,1);
        $pdf->Cell(190,0.5,'',0,1,'C',true);
    }

    if($listagem == '1'){
        $query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num 
                FROM socios 
                INNER JOIN socios_clubes ON socios.stam = socios_clubes.stam 
                WHERE socios_clubes.clube = '$clube' ORDER BY socios_clubes.membro_num ASC";
        if($stmt = @mysqli_query($dbc, $query)) {

            while($row = mysqli_fetch_array($stmt)){
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, $row['membro_num']);

                // $pdf->Cell();
                $pdf->Cell(65,5, $row['nome']);

                $pdf->Cell(20, 0);
                $pdf->Cell(20,5, $row['stam'],0,1);
            }
        }

    }
    if($listagem == '2'){
        $query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num 
                FROM socios 
                INNER JOIN socios_clubes ON socios.stam = socios_clubes.stam 
                WHERE socios_clubes.clube = '$clube' ORDER BY socios.nome ASC";
        if($stmt = @mysqli_query($dbc, $query)) {

            while($row = mysqli_fetch_array($stmt)){
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(5);
                $pdf->Cell(10);
                $pdf->Cell(65,5, $row['nome']);

                $pdf->Cell(30);
                $pdf->Cell(30,5, $row['membro_num']);

                $pdf->Cell(10, 0);
                $pdf->Cell(20,5, $row['stam'],0,1);
            }
        }

    }
    else if ($listagem == '3'){
        $query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num, quotas.dataAte
                FROM socios 
                INNER JOIN socios_clubes on socios.stam=socios_clubes.stam
                INNER JOIN quotas on quotas.stam = socios_clubes.stam
                WHERE socios_clubes.clube = '$clube' AND (quotas.valido = 'Actual' OR quotas.valido = 'Joia')";

        $validarQuota = date('Y-m');

        if($stmt = @mysqli_query($dbc, $query)) {

            while($row = mysqli_fetch_array($stmt)){

                $dataSocio = $row['dataAte'];

                $dataAte = date("Y-m",strtotime($dataSocio));

                if($validarQuota > $dataAte){
                    $pdf->SetFont('Exo', '', 10);
                    $pdf->ln(15);
                    $pdf->Cell(30);
                    $pdf->Cell(30,5, $row['membro_num']);

                    // $pdf->Cell(20);
                    $pdf->Cell(65,5, $row['nome']);

                    $pdf->Cell(20, 0);
                    $pdf->Cell(20,5, $row['stam'],0,1);
                }
            }
        }
    }
    else if ($listagem == '4'){
        $query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num, quotas.dataAte
                FROM socios 
                INNER JOIN socios_clubes on socios.stam=socios_clubes.stam
                INNER JOIN quotas on quotas.stam = socios_clubes.stam
                WHERE socios_clubes.clube = '$clube' AND (quotas.valido = 'Actual' OR quotas.valido = 'Joia')";

        $validarQuota = date('Y-m');

        if($stmt = @mysqli_query($dbc, $query)) {

            while($row = mysqli_fetch_array($stmt)){

                $dataSocio = $row['dataAte'];

                $dataAte = date("Y-m",strtotime($dataSocio));

                if($validarQuota == $dataAte){
                    $pdf->SetFont('Exo', '', 10);
                    $pdf->ln(15);
                    $pdf->Cell(30);
                    $pdf->Cell(30,5, $row['membro_num']);

                    // $pdf->Cell(20);
                    $pdf->Cell(65,5, $row['nome']);

                    $pdf->Cell(20, 0);
                    $pdf->Cell(20,5, $row['stam'],0,1);
                }
            }
        }
    }
    

    $pdf->Output();
}
else {
    echo "nao deu";
}
?>