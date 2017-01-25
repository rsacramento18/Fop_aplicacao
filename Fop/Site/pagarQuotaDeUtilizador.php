<?php include ("header.php"); ?>
<div class="wrapper-content">
    <div id="loggado">
        <?php 
        echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
        echo "<p>" . $_SESSION['clube'] . "</p>";
        ?>
    </div>
    <h1>Pagar Quotas</h1>    
    <div id="encomendaEfectuada">
        <?php
        if(isset ($_POST['quotaPagarAte'], $_POST['preco'], $_SESSION['stam'], $_SESSION['nome'], $_SESSION['clube'])){
          $dataAte = $_POST['quotaPagarAte'];

          $stam = $_SESSION['stam'];

          $nome = $_SESSION['nome'];

          $clube = $_SESSION['clube'];

          $preco = $_POST['preco'];

          $dataAte = explode('-', $dataAte);

          switch ($dataAte[1]) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                $dataAte[2] = "31";
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                $dataAte[2] = "30";
                break;
            case 2:
                if(date('L')==0){
                    $dataAte[2]="29";
                }
                else{
                    $dataAte[2] = "28";
                }
                break;
            default:
                $dataAte = "30";
                break;
        }

        $dataAte = implode('-', $dataAte);

        $query = "SELECT dataAte from quotas where stam = '$stam' AND clube = '$clube' AND valido = 'Actual'";
        $dataDe = 0;
        if($stmt = @mysqli_query($dbc, $query)) {
            $row = mysqli_fetch_array($stmt);
            $dataDe =  $row['dataAte'];
            if($dataDe == ''){
                $query = "SELECT dataAte from quotas where stam = '$stam' AND clube = '$clube' AND valido = 'Joia'";
                $dataDe = 0;
                if($stmt = @mysqli_query($dbc, $query)) {
                    $row = mysqli_fetch_array($stmt);
                    $dataDe =  $row['dataAte'];
                }
            }
        }

        $dataDe = explode('-', $dataDe);

        $dataDe[2] = "01";

        if(intval($dataDe[1]) < 10){
            $dataDe[1] = intval($dataDe[1]) + 1;
            $dataDe[1] = '0' . $dataDe[1];
            ?><script type="text/javascript">console.log("passou!")</script><?php
        }
        else if (intval($dataDe[1]) == 12){
            $dataDe[1] = '01';
            $dataDe[0] = intval($dataDe[0]) +1;
        }
        else {
            $dataDe[1] = '' + intval($dataDe[1]) + 1;
        }

        $dataDe = implode('-', $dataDe);

        echo $dataDe;
        $ts1 = strtotime($dataDe);
        $ts2 = strtotime($dataAte);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = ((($year2 - $year1) * 12) + ($month2 - $month1)) +1;

        $valorApagar = $diff*$preco;

        echo "<form id='confirmarPagamentoQuota' action='confirmarPagamentoQuota.php' method='post' name='confirmarPagamentoQuota'>";
        echo "<h3 id=confirmacaoDados>Confirmação de dados</h3>";
        echo "<input type='hidden'  name='stam' value = '$stam'></input>";
        echo "<input type='hidden'  name='clube' value = '$clube'></input>";
        echo "<input type='hidden'  name='dataDe' value = '$dataDe'></input>";
        echo "<input type='hidden'  name='dataAte' value = '$dataAte'></input>";
        echo "<input type='hidden'  name='valorApagar' value = '$valorApagar'>";
        echo "<input type='hidden'  name='preco' value = '$preco'></input>";

        echo "<table>";

        echo "<tr><th>Stam</th><td>" . $stam . "</td></tr>";
        echo "<tr><th>Nome</th><td>" . $nome . "</td></tr>";
        echo "<tr><th>Clube</th><td>" . $clube . "</td></tr>";
        echo "<tr><th>Data de</th><td>" . $dataDe . "</td></tr>";
        echo "<tr><th>data Ate</th><td>" . $dataAte . "</td></tr>";
        echo "<tr><th>Valor a Pagar</th><td>" . $valorApagar . "€</td></tr>";
        echo "<tr><th>Preco de Quota</th><td>" . $preco . "€</td></tr>";
        
        echo "</table>";

        echo "<input type='submit' value='Pagar Quota' name='pagarQuotaBT2'></input> ";

        echo "</form>";
        
    }
    else if(isset ($_POST['quotaPagarAtePrimeiraVez'], $_POST['quotaPagarDe'], $_POST['joia'] ,$_POST['preco'], $_SESSION['stam'], $_SESSION['nome'], $_SESSION['clube'])){
        $dataAte = $_POST['quotaPagarAtePrimeiraVez'];

        $dataDe = $_POST['quotaPagarDe'];

        $joia = $_POST['joia'];

        $stam = $_SESSION['stam'];

        $nome = $_SESSION['nome'];

        $clube = $_SESSION['clube'];

        $preco = $_POST['preco'];

        $dataAte = explode('-', $dataAte);
        $dataDe = explode('-', $dataDe);

        switch ($dataAte[1]) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
            $dataAte[2] = "31";
            break;
            case 4:
            case 6:
            case 9:
            case 11:
            $dataAte[2] = "30";
            break;
            case 2:
            if(date('L')==0){
                $dataAte[2]="29";
            }
            else{
                $dataAte[2] = "28";
            }
            break;
            default:
            $dataAte = "30";
            break;
        }

        $dataDe[2] = "1";

        // if(intval($dataDe[1]) < 10){
        //     $dataDe[1] = intval($dataDe[1]) + 1;
        //     $dataDe[1] = '0' + $dataDe[1];
        // }
        // else if (intval($dataDe[1]) == 12){
        //     $dataDe[1] = '01';
        // }
        // else {
        //     $dataDe[1] = '' + intval($dataDe[1]) + 1;
        // }


        $dataAte = implode('-', $dataAte);
        $dataDe = implode('-', $dataDe);

        $ts1 = strtotime($dataDe);
        $ts2 = strtotime($dataAte);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = ((($year2 - $year1) * 12) + ($month2 - $month1)) + 1 ;

        $valorApagar = $diff*$preco +$joia;
        

        echo "<form id='confirmarPagamentoQuota' action='confirmarPagamentoQuotaPrimeiraVez.php' method='post' name='confirmarPagamentoQuota'>";
        echo "<h3 id=confirmacaoDados>Confirmação de dados</h3>";
        echo "<input type='hidden'  name='stam' value = '$stam'></input>";
        echo "<input type='hidden'  name='clube' value = '$clube'></input>";
        echo "<input type='hidden'  name='dataDe' value = '$dataDe'></input>";
        echo "<input type='hidden'  name='dataAte' value = '$dataAte'></input>";
        echo "<input type='hidden'  name='joia' value = '$joia'></input>";
        echo "<input type='hidden'  name='valorApagar' value = '$valorApagar'>";
        echo "<input type='hidden'  name='preco' value = '$preco'></input>";

        echo "<table>";

        echo "<tr><th>Stam</th><td>" . $stam . "</td></tr>";
        echo "<tr><th>Nome</th><td>" . $nome . "</td></tr>";
        echo "<tr><th>Clube</th><td>" . $clube . "</td></tr>";
        echo "<tr><th>Data de</th><td>" . $dataDe . "</td></tr>";
        echo "<tr><th>data Ate</th><td>" . $dataAte . "</td></tr>";
        echo "<tr><th>Valor da Joia</th><td>" . $joia . "€</td></tr>";
        echo "<tr><th>Valor a Pagar</th><td>" . $valorApagar . "€</td></tr>";
        echo "<tr><th>Preco de Quota</th><td>" . $preco . "€</td></tr>";
        
        echo "</table>";

        echo "<input type='submit' value='Pagar Quota' name='pagarQuotaBT2'></input> ";

        echo "</form>";
        
    }
    else{
        echo "not isseted";
    }
    ?>
</div>
</div>
<?php include ("footer.php"); ?>
