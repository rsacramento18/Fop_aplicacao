<?php
require('FPDF/tfpdf.php');
require_once '../mysql_config.php';
require_once('functions.php');
sec_session_start();

if(isset($_SESSION['clube'], $_POST['pedidoExportar'])){
    $clube = $_SESSION['clube'];
    $pedidoExportar = $_POST['pedidoExportar'];

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
            $this->Cell(70,10,'Pedido de Anilhas '. $this->pedidoExportar .' - Nota de Pagamento',0,1,'C');
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

    $pdf->SetFont('Exo','B',10);

    $pdf->ln(10);
    $pdf->Cell(10);
    $pdf->Cell(25,5, 'Anilhas Normais',0,1);
    
    $pdf->SetFillColor(0,0,0);
    $pdf->Cell(5);
    $pdf->Cell(180,0.5,'',0,1,'C',true);

    $query = "SELECT sum(quantidade) as quantidadeTotal, ROUND(SUM(custo),2) as custo FROM encomendasAnilhas WHERE clube = '$sigla' AND opcao = 'Normal' AND vagaNum = '$pedidoExportar'";
    $quantidadeTotalNormal = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $quantidadeTotalNormal = $row['quantidadeTotal'];
        $custoNormal = $row['custo'];
    }

    $query = "SELECT sum(quantidade) as quantidadeTotal, ROUND(SUM(custo),2) as custo FROM encomendasAnilhas WHERE clube = '$sigla' AND opcao = 'Reforçada' AND vagaNum = '$pedidoExportar'";
    $quantidadeTotalReforcada = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $quantidadeTotalReforcada = $row['quantidadeTotal'];
        $custoReforcada = $row['custo'];
    }

    $query = "SELECT sum(quantidade) as quantidadeTotal, ROUND(SUM(custo),2) as custo FROM encomendasAnilhas WHERE clube = '$sigla' AND opcao = 'Aço/Inox' AND vagaNum = '$pedidoExportar'";
    $quantidadeTotalAco = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $quantidadeTotalAco = $row['quantidadeTotal'];
        $custoAco = $row['custo'];
    }

    $query = "SELECT COUNT(*) as quantidadeCartaoFop FROM ( SELECT stam, MIN(cartaoFopPago) AS cartoes FROM encomendasAnilhas WHERE cartaoFopPago = 'sim' and clube = '$sigla'   AND vagaNum = '$pedidoExportar' GROUP BY stam) x";
    $quantidadeCartaoFop = 0;
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $quantidadeCartaoFop = $row['quantidadeCartaoFop'];
    }

    $query = "SELECT preco from anilhasPrecos where id = 4";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $precoCartaoFop = $row['preco'];
    }

    $pdf->SetFont('Exo', '', 10);

    $pdf->Cell(10);
    $pdf->Cell(50,7, 'Quantidade Anilhas Pedidas :');
    $pdf->Cell(95, 0);
    $pdf->Cell(25,7, $quantidadeTotalNormal , 0,1, 'R');

    $pdf->Cell(10);
    $pdf->Cell(27,7, 'Valor Anilhas :');
    $pdf->Cell(118, 0);
    $pdf->Cell(25,7, (number_format((float)($custoNormal), 2, '.', '')) . '€', 0,1, 'R');
    
    $pdf->Cell(10);
    $pdf->Cell(28,7, 'Comissão 15% :');
    $pdf->Cell(117, 0);
    $pdf->Cell(25,7, (number_format((float)($custoNormal*0.15), 2, '.', '')) . '€', 0,1, 'R');
    
    $pdf->Cell(10);
    $pdf->Cell(28,7, 'A pagar à FOP :');
    $pdf->Cell(117, 0);
    $pdf->Cell(25,7, (number_format((float)($custoNormal*0.85), 2, '.', '')) . '€', 0,1,'R');

    if($quantidadeTotalReforcada!=0){

        $pdf->SetFont('Exo','B',10);

        $pdf->ln(5);
        $pdf->Cell(10);
        $pdf->Cell(25,5, 'Anilhas Reforçadas',0,1);
        
        $pdf->SetFillColor(0,0,0);
        $pdf->Cell(5);
        $pdf->Cell(180,0.5,'',0,1,'C',true);

        $pdf->SetFont('Exo', '', 10);

        $pdf->Cell(10);
        $pdf->Cell(50,7, 'Quantidade Anilhas Pedidas :');
        $pdf->Cell(95, 0);
        $pdf->Cell(25,7, $quantidadeTotalReforcada , 0,1, 'R');

        $pdf->Cell(10);
        $pdf->Cell(27,7, 'Valor Anilhas :');
        $pdf->Cell(118, 0);
        $pdf->Cell(25,7, (number_format((float)($custoReforcada), 2, '.', '')) . '€', 0,1, 'R');
        
        $pdf->Cell(10);
        $pdf->Cell(28,7, 'Comissão 15% :');
        $pdf->Cell(117, 0);
        $pdf->Cell(25,7, (number_format((float)($custoReforcada*0.15), 2, '.', '')) . '€', 0,1, 'R');
        
        $pdf->Cell(10);
        $pdf->Cell(28,7, 'A pagar à FOP :');
        $pdf->Cell(117, 0);
        $pdf->Cell(25,7, (number_format((float)($custoReforcada*0.85), 2, '.', '')) . '€', 0,1,'R');
    }

    if($quantidadeTotalAco!=0){

        $pdf->SetFont('Exo','B',10);

        $pdf->ln(5);
        $pdf->Cell(10);
        $pdf->Cell(25,5, 'Anilhas Aço/Inox',0,1);
        
        $pdf->SetFillColor(0,0,0);
        $pdf->Cell(5);
        $pdf->Cell(180,0.5,'',0,1,'C',true);

        $pdf->SetFont('Exo', '', 10);

        $pdf->Cell(10);
        $pdf->Cell(50,7, 'Quantidade Anilhas Pedidas :');
        $pdf->Cell(95, 0);
        $pdf->Cell(25,7, $quantidadeTotalAco , 0,1, 'R');

        $pdf->Cell(10);
        $pdf->Cell(27,7, 'Valor Anilhas :');
        $pdf->Cell(118, 0);
        $pdf->Cell(25,7, (number_format((float)($custoAco), 2, '.', '')) . '€', 0,1, 'R');
        
        $pdf->Cell(10);
        $pdf->Cell(28,7, 'Comissão 15% :');
        $pdf->Cell(117, 0);
        $pdf->Cell(25,7, (number_format((float)($custoAco*0.15), 2, '.', '')) . '€', 0,1, 'R');
        
        $pdf->Cell(10);
        $pdf->Cell(28,7, 'A pagar à FOP :');
        $pdf->Cell(117, 0);
        $pdf->Cell(25,7, (number_format((float)($custoAco*0.85), 2, '.', '')) . '€', 0,1,'R');
    }

    if($quantidadeCartaoFop!=0){

        $pdf->SetFont('Exo', 'B', 10);

        $pdf->ln(5);
        $pdf->Cell(10);
        $pdf->Cell(25,5, 'Cartao Fop',0,1);
        
        $pdf->SetFillColor(0,0,0);
        $pdf->Cell(5);
        $pdf->Cell(180,0.5,'',0,1,'C',true);

        $pdf->SetFont('Exo', '', 10);

        $pdf->Cell(10);
        $pdf->Cell(50,7, 'Quantidade Cartões Pedidos :');
        $pdf->Cell(95, 0);
        $pdf->Cell(25,7, $quantidadeCartaoFop , 0,1, 'R');

        $pdf->Cell(10);
        $pdf->Cell(27,7, 'Preco Cartão FOP :');
        $pdf->Cell(118, 0);
        $pdf->Cell(25,7, (number_format((float)($precoCartaoFop), 2, '.', '')) . '€', 0,1, 'R');

        $pdf->Cell(10);
        $pdf->Cell(27,7, 'Cartões a pagar à FOP :');
        $pdf->Cell(118, 0);
        $pdf->Cell(25,7, (number_format((float)($precoCartaoFop*$quantidadeCartaoFop), 2, '.', '')) . '€', 0,1, 'R');
    }

    $pdf->SetFont('Exo', 'B', 12);

    $pdf->ln(25);
    $pdf->Cell(60);
    $pdf->Cell(95,7, 'Valor total da quota suplementar a pagar à FOP :');
    $pdf->Cell(5, 0);
    $pdf->Cell(25,7, (number_format((float)(($precoCartaoFop*$quantidadeCartaoFop)+($custoNormal*0.85)+
        ($custoReforcada*0.85)+($custoAco*0.85)), 2, '.', '')) . '€', 0,1,'R');
    $pdf->SetFont('Exo', 'I', 10);
    $pdf->Cell(55);
    $pdf->Cell(100, 7, '(Este documento serve de recibo após boa cobrança)', 0 , 1, 'R' );





    $pdf->Output();
}
else {
    echo "nao deu";
}
?>