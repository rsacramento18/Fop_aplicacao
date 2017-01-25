<?php
require('FPDF/tfpdf.php');
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

if(isset($_SESSION['clube'], $_POST['pedidoExportar'], $_POST['tipoAnilha'])){
    $clube = $_SESSION['clube'];
    $pedidoExportar = $_POST['pedidoExportar'];
    $tipoAnilha = $_POST['tipoAnilha'];

    $query = "SELECT nome_clube, sigla, morada, imagem, site, email FROM clubes WHERE nome_clube = '$clube'";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $nome_clube = $row['nome_clube'];
        $sigla = $row['sigla'];
        $morada = $row['morada'];
        $img = $row['imagem'];
        $site = $row['site'];
        $email = $row['email'];
    }

    $query = "SELECT sum(quantidade) as quantidadeTotal FROM encomendasAnilhas WHERE clube = '$sigla' 
    AND opcao = '$tipoAnilha' AND vagaNum = '$pedidoExportar'";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $quantidadeTotal = $row['quantidadeTotal'];
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
            if($this->tipoAnilha == 'Normal'){
                $this->SetFont('Exo','',12);
                $this->Cell(70);
                $this->Cell(70,10,'Pedido de Anilhas '. $this->pedidoExportar . ' - Anilhas Normais',0,1,'C');
            }
            else if($this->tipoAnilha == 'Reforcada'){
                $this->SetFont('Exo','',12);
                $this->Cell(70);
                $this->Cell(70,10,'Pedido de Anilhas '. $this->pedidoExportar . ' - Anilhas Reforçadas',0,1,'C');
            }
            else if($this->tipoAnilha == 'Aco/Inox'){
                $this->SetFont('Exo','',12);
                $this->Cell(70);
                $this->Cell(70,10,'Pedido de Anilhas '. $this->pedidoExportar . ' - Anilhas Aço/Inox',0,1,'C');
            }

            $this->SetFont('Exo', 'B', 10);
            $this->SetTextColor(0,0,0);
            $this->ln(10);
            $this->Cell(5);
            $this->Cell(25,10, $this->sigla);
            $this->Cell(50,10, $this->nome_clube, 0, 1);

            $this->Cell(5);
            $this->Cell(25,10, 'Morada');
            $this->Cell(50,10, $this->morada, 0, 1);

            $this->ln(5);
            $this->Cell(10);
            $this->Cell(12,5, 'STAM');

            $this->SetFont('Exo', '', 10);

            $this->Cell(20, 0);
            $this->Cell(50,5, 'Nome Criador');

            $this->Cell(17, 0);
            $this->Cell(20,5, 'Medida');

            $this->Cell(5, 0);
            $this->Cell(20,5, 'Quantidade');

            $this->Cell(5, 0);
            $this->Cell(10,5, 'Inicio');

            $this->Cell(6, 0);
            $this->Cell(10,5, 'Fim', 0,1);

            $this->SetFillColor(0,0,0);
            $this->Cell(190,0.5,'',0,1,'C',true);
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

    $pdf = new PDF('P','mm','A4', $pedidoExportar, $img, $tipoAnilha, $sigla, $nome_clube, $morada);

    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->AddFont('Exo','','Exo-Regular.ttf',true);
    $pdf->AddFont('Exo', 'B', 'Exo-Bold.ttf', true);
    $pdf->AddFont('Exo', 'I', 'Exo-Italic.ttf', true);

    $query= "SELECT encomendasAnilhas.stam, socios.nome, encomendasAnilhas.medida, encomendasAnilhas.quantidade, encomendasAnilhas.numInicio, encomendasAnilhas.numFim FROM encomendasAnilhas 
    LEFT JOIN socios
    ON encomendasAnilhas.stam = socios.stam
    WHERE vagaNum = '$pedidoExportar' AND opcao = '$tipoAnilha' AND clube = '$sigla' 
    GROUP BY stam ASC, numPedido ASC";
    $stmt = @mysqli_query($dbc, $query);
    if($stmt) {


        while($row = mysqli_fetch_array($stmt)) {

            $pdf->ln(5);
            $pdf->Cell(10);
            $pdf->Cell(12,5, $row['stam']);

            $pdf->SetFont('Exo', '', 9);

            $pdf->Cell(20, 0);
            $pdf->Cell(50,5, $row['nome']);

            $pdf->SetFont('Exo', '', 10);

            $pdf->Cell(20, 0);
            $pdf->Cell(23,5, number_format((float)$row['medida'], 1, '.', ''));

            $pdf->Cell(5, 0);
            $pdf->Cell(20,5, $row['quantidade']);

            $pdf->Cell(3, 0);
            $pdf->Cell(8,5, $row['numInicio']);

            $pdf->Cell(5, 0);
            $pdf->Cell(10,5, $row['numFim'], 0,1);
            
        }

    }

    $query= "SELECT ROUND(SUM(custo),2) as custo FROM encomendasAnilhas 
    WHERE vagaNum = '$pedidoExportar' AND opcao = '$tipoAnilha' AND clube = '$sigla'";
    $custo = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $custo =  $row['custo'];
    }

    $pdf->SetFont('Exo', 'B', 11);

    $pdf->ln(15);
    $pdf->Cell(111);
    $pdf->Cell(50,7, 'Quantidade Anilhas Pedidas :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, $quantidadeTotal , 0,1, 'R');
    $pdf->Cell(135);
    $pdf->Cell(27,7, 'Valor Anilhas :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, (number_format((float)($custo), 2, '.', '')) . '€', 0,1, 'R');
    
    $pdf->Cell(134);
    $pdf->Cell(28,7, 'Comissão 15% :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, (number_format((float)($custo*0.15), 2, '.', '')) . '€', 0,1, 'R');
    
    $pdf->Cell(134);
    $pdf->Cell(28,7, 'A pagar à FOP :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, (number_format((float)($custo*0.85), 2, '.', '')) . '€', 0,1,'R');



    $pdf->Output();
}
else {
    echo "nao deu";
}
?>