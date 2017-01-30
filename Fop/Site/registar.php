<?php
include_once 'register.inc.php';
include_once 'functions.php';
?>
<!doctype html>
<html>
<head>
  <title>register</title>
  <script type="text/javascript" src="js/sha512.js"></script> 
  <script type="text/javascript" src="js/form.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
  <link rel="stylesheet" href="styles/normalize.css" />
  <link rel="stylesheet" href="styles/main.css" />
</head>
<body>
<div class="wrapper-contentRegistar">
  <header>
    <div class="logo-div clearfix">
        <h1 class = "logo_header"><a href="">Gest_FOP</a></h1>
        <h3>Federação Ornitológica Portuguesa</h3>
    </div>
  </header>
  <div id="registar">
    <h1>registar</h1>
    <span>Tipo de Registo</span>
    <select id="selectTipoRegisto">
        <option id="nacional">Nacional</option>
        <option id="internacional">Internacional</option>
    </select>
    <span id="labelsRegistarSelect"> If your country is not Portugal change "Tipo de Registo" to Internacional.</span>
    <form action="registarNacional.inc.php" method="post" name="registarNacionalForm" id="registarNacionalForm" style="display:block">
        <input type="text" name="stamRegistar" id="stamRegistar" size="30" placeholder="Stam"/>
        <span class="labelsRegistar">Introduzir o Stam. Este Stam tem que existir na base de dados.</span><br />
        <input type="number" name="biRegistar" id="biRegistar" size="30" placeholder="Bi/CC"/>
        <span class="labelsRegistar">Introduza o Bi/CC, este ja tera que estar inserido na base de dados.</span><br />
        <input type="password" name="passwordRegistar" id="passwordRegistar" size="30" placeholder="Password"/> 
        <span class="labelsRegistar">Introduza uma passord a sua escolha para a conta.</span><br />
        <input type="password" name="passwordConfirmarRegistar" id="passwordConfirmarRegistar" size="30" placeholder="Confirmar Password"/> 
        <span class="labelsRegistar">Confirme a sua password.</span><br />
        <input type="submit" id="btRegistarNacional" name="btRegistarNacional" value="Registar Conta"/>

    </form>
    <form action"registarInternacional.inc" method="post" name="registarInternacionalForm" id="registarInternacionalForm" style="display:none">

        <input type="text" name="nomeRegistar" id="nomeRegistar" size="30" placeholder="Name"/>
        <span class="labelsRegistar">Insert a name for the account.</span><br />
        <input type="text" name="stamRegistarInternacional" id="stamRegistarInternacional" size="30" placeholder="Stam"/>
        <span class="labelsRegistar">Insert a Stam of your club.</span><br />
        <input type="text" name="idRegistarInternacional" id="idRegistarInternacional" size="30" placeholder="Identification"/>
        <span class="labelsRegistar">Insert Identification.</span><br />
        <input type="text" name="paisRegistarInternacional" id="paisRegistarInternacional" size="30" placeholder="Country"/>
        <span class="labelsRegistar">Insert your country of origin.</span><br />
        <input type="text" name="addressRegistarInternacional" id="addressRegistarInternacional" size="30" placeholder="Address"/>
        <span class="labelsRegistar">Insert home address.</span><br />
        <input type="password" name="passwordRegistarInternacional" id="passwordRegistarInternacional" size="30" placeholder="Password"/> 
        <span class="labelsRegistar">Insert a password for you account.</span><br />
        <input type="password" name="passwordConfirmarRegistarInternacional" id="passwordConfirmarRegistarInternacional" size="30" placeholder="Confirm Password"/> 
        <span class="labelsRegistar">Confirm your password.</span><br />
        <input type="submit" id="btRegistarInternacional" name="btRegistarInternacional" value="Register Account"/>

    </form>
  </div>
</div>
    <script type="text/javascript">

        
        var selectTipoRegisto = document.getElementById("selectTipoRegisto");
        var registarNacional = document.getElementById("registarNacionalForm");
        var registarInternacional = document.getElementById("registarInternacionalForm");
        var spanSelect = document.getElementById("labelsRegistarSelect");

        selectTipoRegisto.onchange= function (){
            if(registarNacional.style.display == "none"){
                registarNacional.style.display = "block";
                registarInternacional.style.display = "none";
                spanSelect.style.display = "inline";
            }
            else {
                registarInternacional.style.display = "block";
                registarNacional.style.display = "none";
                spanSelect.style.display = "none";

            }
        }

    </script>
  </body>
