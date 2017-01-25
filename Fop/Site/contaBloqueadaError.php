<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Gest_FOP</title>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/form.js"></script>
    <script type="text/JavaScript" src="js/functionsJS.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|PT+Sans+Narrow|Dosis|Exo:400,700' rel='stylesheet' type='text/css'>  
    <link type="text/css" href="styles/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles/normalize.css" />
    <link rel="stylesheet" href="styles/main.css" />   

    
</head>
<body>
    <?php
    $error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
    
    if (! $error) {
        $error = 'Oops! An unknown error happened.';
    }
    ?>
    <div class="wrapper-content">
        <h1>Conta Bloqueada</h1>
        <p>ESTE UTILIZADOR ENCONTRA-SE BLOQUEADO PELO MOTIVO DE SE ENCONTRAR NESTE MOMENTO COM DÍVIDAS À FOP.</p></br>
        <p>CHAMAMOS A ATENÇÃO AOS CLUBES QUE ESTÃO BLOQUEADOS, QUE A SITUAÇÃO DE NÃO CUMPRIMENTO PODERÁ LEVAR AO CORTE DOS APOIOS QUE A FOP PRESTA AO MESMOS, NOMEADAMENTE NO PAGAMENTO DAS DESPESAS DOS JUÍZES NAS SUAS EXPOSIÇÕES, CONFORME APROVAÇÃO DO PONTO QUATRO DA ORDEM DE TRABALHOS APROVADO POR UNANIMIDADE PELOS CLUBES PRESENTES, NA AG DE 29 DE MARÇO DE 2014, REALIZADA EM BELAS. PARA MAIS INFORMAÇÕES CONTACTAR A TESOURARIA.</p>
    </div>
</body>
</html>
