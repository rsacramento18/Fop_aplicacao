<?php
require('FPDF/tfpdf.php');
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

if(isset($_POST['stam'], $_POST['clube'])){
    $stam = $_POST['stam'];
    $clube = $_POST['clube'];

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
            $this->Cell(70,10,'Recibo Quotas',0,1,'C');

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

    $query = "SELECT nome, email, bi, pais, regiao, morada, cod_postal, Localidade, telefone1, telefone2 from socios 
                INNER JOIN socios_clubes
                ON socios.stam=socios_clubes.stam 
                WHERE socios_clubes.stam = '$stam' AND socios_clubes.clube = '$clube'";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);

        $nome = $row['nome'];
        $email = $row['email'];
        $bi = $row['bi'];
        $pais = $row['pais'];
        $regiao = $row['regiao'];
        $morada = $row['morada'];
        $cod_postal = $row['cod_postal'];
        $localidade = $row['Localidade'];
        $telefone1 = $row['telefone1'];
        $telefone2 = $row['telefone2'];
    }

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->SetTextColor(0,0,0);
    $pdf->ln(10);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'STAM',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, $stam,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'NOME',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5,(string) $nome,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'EMAIL',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, (string)$email,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'BI/CC',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, $bi,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'PAÍS',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, (string)$pais,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'REGIÃO',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, (string)$regiao,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'MORADA',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, (string)$morada,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'CÓDIGO POSTAL',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, $cod_postal,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'LOCALIDADE',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, (string)$localidade,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'TELEFONE 1',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, $telefone1,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(5);
    $pdf->Cell(10);
    $pdf->Cell(30,5, 'TELEFONE 2',0,0,'R');
    $pdf->Cell(10);
    $pdf->SetFont('Exo', '', 10);
    $pdf->Cell(80,5, $telefone2,0,0,'L');

    $pdf->SetFont('Exo', 'B', 10);
    $pdf->ln(15);
    $pdf->Cell(30);
    $pdf->Cell(30,5, 'Quota');

    $pdf->Cell(20);
    $pdf->Cell(30,5, 'Ano');

    $pdf->Cell(20, 0);
    $pdf->Cell(20,5, 'Valor',0,1);

    $pdf->SetFillColor(132,1,1);
    $pdf->Cell(190,0.5,'',0,1,'C',true);


    $query= "SELECT dataDe, dataAte, precoQuota, valorPago, dataDoPagamento FROM quotas 
        WHERE stam = '$stam' AND clube = '$clube' AND valido = 'Joia' ";
    $stmt = @mysqli_query($dbc, $query);
    $dataDe = "";
    $dataAte = "";
    $preco = "";
    $valorPago = "";
    $dataDoPagamento = "";    
    if($stmt) {
        $row = mysqli_fetch_array($stmt);
        $dataDe = $row['dataDe'];
        $dataAte = $row['dataAte'];
        $preco = $row['precoQuota'];
        $valorPago = $row['valorPago'];
        $dataDoPagamento = $row['dataDoPagamento'];    
    }

    $ts1 = strtotime($dataDe);
    $ts2 = strtotime($dataAte);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    $dataDe = explode('-', $dataDe);
    $dataAte = explode('-', $dataAte);

    $dataDe[1] = $dataDe[1] +1; 

    $precoJoia = $valorPago - ($diff*$preco);
     $pdf->SetFont('Exo', '', 10);
     $pdf->ln(2.5);
     $pdf->Cell(30);
     $pdf->Cell(30,5, 'Joia');


     $pdf->Cell(20);
     $pdf->Cell(30,5, (string)$dataDe[0] );

     $pdf->Cell(20, 0);
     $pdf->Cell(20,5, (number_format((float)($precoJoia), 2, '.', '')) . '€',0,1);

    do{

        switch (intval($dataDe[1])) {
            case 1:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Janeiro');
                break;
            case 2:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Fevereiro');
                break;
            case 3:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Março');
                break;
            case 4:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Abril');
                break;
            case 5:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Maio');
                break;
            case 6:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Junho');
                break;
            case 7:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Julho');
                break;
            case 8:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Agosto');
                break;
            case 9:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Setembro');
                break;
            case 10:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Outubro');
                break;
            case 11:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Novembro');
                break;
            case 12:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(2.5);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Dezembro');
                break;
            default:
                $pdf->SetFont('Exo', '', 10);
                $pdf->ln(20);
                $pdf->Cell(30);
                $pdf->Cell(30,5, 'Erro');
                break;
        }
        $ano = $dataDe[0];
        $pdf->Cell(20);
        $pdf->Cell(30,5, (string)$dataDe[0] );

        $pdf->Cell(20, 0);
        $pdf->Cell(20,5, (number_format((float)($preco), 2, '.', '')) . '€',0,1);

        $dataDe[1] = intval(intval($dataDe[1]) +1);
        if($dataDe[1] == 13){
            $dataDe[1] = 1;
            $dataDe[0] = intval(intval($dataDe[0]) +1);
        }
    }while(intval($dataDe[0])!=intval($dataAte[0]) || intval($dataDe[1])!=intval($dataAte[1])+1 );


    $pdf->SetFont('Exo', 'B', 11);

    $pdf->ln(15);
    $pdf->Cell(140);
    $pdf->Cell(23,7, 'Valor pago:');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, (number_format((float)($valorPago), 2, '.', '')) . '€' , 0,1, 'R');
    $pdf->Cell(123);
    $pdf->Cell(40,7, 'Data do Pagamento :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, $dataDoPagamento, 0,1, 'R');

    $pdf->Output();
}
else {
    echo "nao deu";
}
?>