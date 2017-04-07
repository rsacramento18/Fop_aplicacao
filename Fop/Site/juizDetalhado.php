<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$idJuiz = $_POST['source1'];
}

$query = "SELECT * from juizes  
WHERE idJuiz = '$idJuiz'";

$stmt = @mysqli_query($dbc, $query);
if($stmt) {

	$dadosJuiz = mysqli_fetch_array($stmt);

    $idJuiz = $dadosJuiz['idJuiz'];

	echo "<div id='dadosJuiz' style='display:block'>";
	echo "<table id='tableJuizDetalhado'>";

	echo "<tr><th>User</th><td id='user'>" . $dadosJuiz['user'] . "</td></tr>";
	echo "<tr><th>Nome</th><td id='nome'>" . $dadosJuiz['nome'] . "</td></tr>";
	echo "<tr><th>Email</th><td id='email'>" . $dadosJuiz['email'] . "</td></tr>";
	echo "<tr><th>Bi/CC</th><td id='bi'>" . $dadosJuiz['bi'] . "</td></tr>";
	echo "<tr><th>País</th><td id='pais'>" . $dadosJuiz['pais'] . "</td></tr>";
	echo "<tr><th>Região</th><td id='regiao'>" . $dadosJuiz['regiao'] . "</td></tr>";
	echo "<tr><th>Morada</th><td id='morada'>" . $dadosJuiz['morada'] . "</td></tr>";
	echo "<tr><th>Código Postal</th><td id='cod_postal'>" . $dadosJuiz['cod_postal'] . "</td></tr>";
	echo "<tr><th>Localidade</th><td id='Localidade'>" . $dadosJuiz['Localidade'] . "</td></tr>";
	echo "<tr><th>Telefone 1</th><td id='telefone1'>" . $dadosJuiz['telefone1'] . "</td></tr>";
	echo "<tr><th>Telefone 2</th><td id='telefone2'>" . $dadosJuiz['telefone2'] . "</td></tr>";

    echo "</table>";

    echo "<div id='imgExposicaoDetalhada'>";
        echo "<img src='$dadosJuiz[foto]' height='300' width='300'/>";
    echo "</div>";
 

	echo "</div>";


	echo "<form id='formAlterarJuiz' action='alterarJuiz.php' method='post' name='formAlterarJuiz' style='display:none' enctype='multipart/form-data' >";
        echo "<input type='hidden' name='idJuiz' value='$idJuiz'/>";
        echo "<span>Nome Juiz</span><input type='text' name='nomeJuiz' id='nomeJuiz' size='50'/><br/>";
        echo "<span>Foto </span><input type='file' name='foto' id='foto'/><br/> ";
        echo "<span>Email </span><input type='email' name='emailJuiz' id='emailJuiz' size='48'/><br/>";
        echo "<span>Bi/CC</span><input type='number' name='biJuiz' id='biJuiz' size='48'/><br/>";
        echo "<span>Pais </span><input type='text' name='paisJuiz' id='paisJuiz' size='48'/><br/>";
        echo "<span>Regiao </span><input type='text' name='regiaoJuiz' id='regiaoJuiz' size='48'/><br/>";
        echo "<span>Morada </span><input type='text' name='moradaJuiz' id='moradaJuiz' size='48'/><br/>";
        echo "<span>Codigo Postal</span><input type='text' name='cod_postalJuiz' id='cod_postalJuiz' size='48'/><br/>";
        echo "<span>Localidade </span><input type='text' name='LocalidadeJuiz' id='LocalidadeJuiz' size='48'/><br/>";
        echo "<span>Telefone 1</span><input type='number' name='telefone1Juiz' id='telefone1Juiz' size='48'/><br/>";
        echo "<span>Telefone 2</span><input type='number' name='telefone2Juiz' id='telefone2Juiz' size='48'/><br/>";
         
        echo "<input type='submit' id='alterarDadosBT' value='Confirmar Alteracoes'></input>";
        echo "<input type='button' id='btVoltar' name='btVoltar' value='Voltar' onclick='voltarFunction()'></input>";

    echo "</form>";


	echo "<form action='eliminarAssociadoClube.php' id='formEliminarAssociadoClube' method='post' name='formAlterarDadosAssociadoClube' style='display:none'>";
        echo "<input type='hidden' name='idJuiz' value='$idJuiz'></input>";
    echo "</form>";
    
    echo "<input type='button' name='btShowForm' id='btShowForm' Value='Alterar dados' onclick=' showAlterarDados()'/>";
	echo "<input type='button' id='eliminarJuiz' value='Eliminar Juiz'></input>";
	
}
?>
<script type="text/javascript">
    
    document.getElementById('nomeJuiz').value = document.getElementById('nome').innerHTML;
    document.getElementById('emailJuiz').value = document.getElementById('email').innerHTML;
    document.getElementById('biJuiz').value = document.getElementById('bi').innerHTML;
    document.getElementById('paisJuiz').value = document.getElementById('pais').innerHTML;
    document.getElementById('regiaoJuiz').value = document.getElementById('regiao').innerHTML;
    document.getElementById('moradaJuiz').value = document.getElementById('morada').innerHTML;
    document.getElementById('cod_postalJuiz').value = document.getElementById('cod_postal').innerHTML;
    document.getElementById('LocalidadeJuiz').value = document.getElementById('Localidade').innerHTML;
    document.getElementById('telefone1Juiz').value = document.getElementById('telefone1').innerHTML;
    document.getElementById('telefone2Juiz').value = document.getElementById('telefone2').innerHTML;


    function showAlterarDados(){
        document.getElementById('dadosJuiz').style.display = 'none';
        document.getElementById('btShowForm').style.display = 'none';
        document.getElementById('eliminarJuiz').style.display = 'none';
        document.getElementById('formAlterarJuiz').style.display = 'block';
    }

    function voltarFunction(){
        document.getElementById('dadosJuiz').style.display = 'block';
        document.getElementById('btShowForm').style.display = 'inline-block';
        document.getElementById('eliminarJuiz').style.display = 'inline-block';
        document.getElementById('formAlterarJuiz').style.display = 'none';
    }

	function alterarNumeroFunction(){
		var numeroAssociado = document.getElementById('numeroAssociado');
		numeroAssociado.style.display = "none";

		var alterarNumeroAssociado = document.getElementById('alterarNumeroAssociado');
		alterarNumeroAssociado.style.display = "block";

		var formAlterarNumeroAssociadoClube = document.getElementById('formAlterarNumeroAssociadoClube');
		formAlterarNumeroAssociadoClube.style.display = "none";

		var formAlterarDadosAssociadoClube = document.getElementById('formAlterarDadosAssociadoClube');
		formAlterarDadosAssociadoClube.style.display = "none";

		var formEliminarAssociadoClube = document.getElementById('formEliminarAssociadoClube');
		formEliminarAssociadoClube.style.display = "none";
	}
</script>
