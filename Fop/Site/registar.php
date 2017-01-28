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
  <div id="registar">
    <h1>registar</h1>
    <span>Tipo de Registo</span>
    <select id="selectTipoRegisto">
        <option id="nacional">Nacional</option>
        <option id="internacional">Internacional</option>
    </select>
    <form action="registarNacional.inc.php" method="post" name="registarNacional" id='registarNacional' style="display:block">
        <input type='text' name='stam' id='stam' size='30' placeholder='Stam'/>
        <span class="labelsRegistar">Introduzir o Stam. Este Stam tem que existir na base de dados.</span><br />
        <input type='text' name='bi' id='bi' size='30' placeholder='Bi/CC'/>
        <span class="labelsRegistar">Introduza o Bi/CC, este ja tera que estar inserido na base de dados.</span><br />
        <input type='password' name='password' id='password' size='30' placeholder='Password'/> 
        <span class="labelsRegistar">Introduza uma passord a sua escolha para a conta.</span><br />
        <input type='password' name='password' id='password' size='30' placeholder='Confirmar Password'/> 
        <span class="labelsRegistar">Confirme a sua password.</span><br />

    </form>
    <form action"registarInternacional.inc" method="post" name="registarInternacional" id="registarInternacional" style="display:none">

        <input type='text' name='nome' id='nome' size='30' placeholder='Name'/>
        <span class="labelsRegistar">Insert a name for the account.</span><br />
        <input type='text' name='stam' id='stam' size='30' placeholder='Stam'/>
        <span class="labelsRegistar">Introduzir o Stam. Este Stam tem que existir na base de dados.</span><br />
        <input type='number' name='bi' id='bi' size='30' placeholder='Bi/CC'/>
        <span class="labelsRegistar">Introduza o Bi/CC, este ja tera que estar inserido na base de dados.</span><br />
        <input type='password' name='password' id='password' size='30' placeholder='Password'/> 
        <span class="labelsRegistar">Introduza uma passord a sua escolha para a conta.</span><br />
        <input type='password' name='password' id='password' size='30' placeholder='Confirmar Password'/> 
        <span class="labelsRegistar">Confirme a sua password.</span><br />

    </form>
  </div>
    <script type="text/javascript">

        
        var selectTipoRegisto = document.getElementById('selectTipoRegisto');
        var registarNacional = document.getElementById('registarNacional');
        var registarInternacional = document.getElementById('registarInternacional');

        selectTipoRegisto.onclick= function (){
            if(registarNacional.style.display == "none"){
                registarNacional.style.display = "block";
                registarInternacional.style.display = 'none';
            }
            else {
                registarInternacional.style.display = "block";
                registarNacional.style.display = "none";

            }
        }

    </script>
  </body>
