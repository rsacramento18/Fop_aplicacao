<?php
include_once '../mysql_config.php';
include_once 'functions.php';
date_default_timezone_set('UTC');
sec_session_start();
verificarDataPedido($dbc);
?>
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
    <?php if( login_clube_check($dbc) == true) :?>
        <link rel="stylesheet" href="styles/alternate.css" />
    <?php endif ?>  
<link rel="stylesheet" href="styles/main.css" />   


</head>
<body>
    <?php
    if (login_check($dbc) == false && login_checkSocios($dbc) == false && login_socioEstrangeiros == false ) : ?>
    <p>
        <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
    </p>
    <p>Return to <a href="login.php">login page</a></p>
<?php else : ?>

    <header>
        <div class="logo-div clearfix">
            <h1 class = "logo_header"><a href="">Gest_FOP</a></h1>
            <h3>Federação Ornitológica Portuguesa</h3>
        </div>
    </header>

    <div class="menu-wrap">
     <nav class="menu">
        <ul class="clearfix">
            <li class=<?php if (basename($_SERVER['PHP_SELF'])=="home.php") : ?>"current-item"<?php endif;?>><a href="home.php">Home</a></li>
            <?php if( login_fop_check($dbc) == true || login_clube_check($dbc) == true) :?>
            <li class=<?php if ((basename($_SERVER['PHP_SELF'])=="pesquisarSocio.php") || 
                (basename($_SERVER['PHP_SELF'])=="novoRegisto.php") || 
                (basename($_SERVER['PHP_SELF'])=="pesquisaClube.php")) : ?>"current-item"<?php endif;?>><a href="#">Associados<span class="arrow"> &#9660;</span></a>
                <ul class="sub-menu">
                    <li><a href="pesquisarSocio.php">Pesquisar Associado</a></li>
                    <li><a href="pesquisaClube.php">Listar Associados no Clube</a></li>
                    <li><a href="verificarBi.php">Novo Registo Associado</a></li>
                </ul>
            </li>
            <?php endif;?>
            <?php if( login_clube_check($dbc) == true ) :?>
                <li class=<?php if ((basename($_SERVER['PHP_SELF'])=="gestaoClube.php") || 
                    (basename($_SERVER['PHP_SELF'])=="pagarQuotas.php") || 
                    (basename($_SERVER['PHP_SELF'])=="#")) : ?>"current-item"<?php endif;?>><a href="#">Gestão do Clube<span class="arrow"> &#9660;</span></a>
                    <ul class="sub-menu">
                        <li><a href="dadosDoCLube.php">Dados do Clube</a></li>
                        <li><a href="gestaoClube.php">Gestão de Associados</a></li>
                        <li><a href="pagarQuotas.php">Pagar Quotas</a></li>                        
                        <li><a href="verListagensClube.php">Listagens</a></li>
                        <li><a href="etiquetas.php">Tirar Etiquetas</a></li>
                    </ul>
                </li>
            <?php endif;?>
            <?php if( login_fop_check($dbc) == true) :?>
                <li class=<?php if ((basename($_SERVER['PHP_SELF'])=="gestaoContas.php") || 
                    (basename($_SERVER['PHP_SELF'])=="log.php") || 
                    (basename($_SERVER['PHP_SELF'])=="administracaoClubes.php")
                    || (basename($_SERVER['PHP_SELF'])=="exportarBaseDados.php")) : ?>"current-item"<?php endif;?>><a href="#">Administração<span class="arrow"> &#9660;</span></a>

                    <ul class="sub-menu">
                        <li><a href="gestaoContas.php">Gestão de Contas</a></li>
                        <li><a href="administracaoClubes.php">Administração de Clubes</a></li>
                        <li><a href="log.php">Actividade de Contas</a></li>
                        <li><a href="exportarBaseDados.php" target="_blank">Exportar Base de Dados</a></li>
                    </ul>

                </li>
            <?php endif; ?>
            <?php if( login_fop_check($dbc) == true || login_clube_check($dbc) == true) :?>
            <li class=<?php if ((basename($_SERVER['PHP_SELF'])=="encomendarAnilhasFase1.php") || (basename($_SERVER['PHP_SELF'])=="listagens.php") ||
                (basename($_SERVER['PHP_SELF'])=="opcoesAnilhas.php") || 
                (basename($_SERVER['PHP_SELF'])=="precosAnilhas.php")) : ?>"current-item"<?php endif;?>><a href="#">Anilhas<span class="arrow"> &#9660;</span></a>
                
                <ul class="sub-menu">
                    <li><a href="encomendarAnilhasFase1.php">Encomendar</a></li>
                    <?php if( login_fop_check($dbc) == true) :?>
                        <li><a href="#">Opções<span class="arrow"> &#9658;</span></a>
                            <ul class="sub-sub-menu">
                                <li><a href="opcoesAnilhas.php">Datas Limite</a></li>
                                <li><a href="precosAnilhas.php">Definições Anilhas</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li><a href="listagens.php">Listagens dos Pedidos</a></li>
                </ul>
                
            </li>
            <?php endif; ?>
            <?php if( (login_fop_check($dbc) == true) || (login_clube_check($dbc) == true)  || (login_colegio_check($dbc) == true)):?>
            <li class=<?php if (basename($_SERVER['PHP_SELF'])=="exposicoes.php") : ?>"current-item"<?php endif;?>><a href="#">Exposições<span class="arrow"> &#9660;</span></a>
                <ul class="sub-menu">
                    <?php if( (login_fop_check($dbc) == true) ||  (login_colegio_check($dbc) == true) ||  (login_clube_check($dbc) == true) ) :?>
                        <li><a href="todasExposicoes.php">Todas as Exposiçoes</a></li>
                    <?php endif; ?>
                    
                    <?php if( login_fop_check($dbc) == true ) :?>
                        <li><a href="criarExposicao.php">Criar Exposição</a></li>
                    <?php endif; ?>
                   
                </ul>
            </li>
            <?php endif; ?>
            <?php if( login_colegio_check($dbc) == true) :?>
                <li class=<?php if ((basename($_SERVER['PHP_SELF'])=="criarFichaJulgamento.php") || 
                    (basename($_SERVER['PHP_SELF'])=="#")) : ?>"current-item"
                <?php endif;?>><a href="#">Fichas de Julgamentos<span class="arrow"> &#9660;</span></a>

                    <ul class="sub-menu">
                        <li><a href="criarFichaJulgamento.php">Criar FIcha</a></li>
                        <li><a href="#">Nova Listagem</a></li>
                    </ul>

                </li>
            <?php endif; ?>

            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
</div> 
<?php endif;?>             
