<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true || login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
        <h1>Criar Ficha de Julgamento</h1>
        <div id="divCriarFichaJulgamento">
           <form action="criarFichaJulgamento.inc.php" method="post" name="formCriarFichaJulgamento" id="formCriarFichaJulgamento">
                <input type ="text" name="nomeFicha" id="nomeFicha" placeHolder="Nome da Ficha" style="margin:10px"/><br /> 

                <input type="text" name="topicoNome1" id="topicoNome1" placeholder="Nome Topico" style="margin:10px; width:300px"/>
                <input type="number" name="pontuacaoTopico1" id="pontuacaoTopico1" style="margin:10px; width:110px" placeholder="Pontuacao"/>
                <input type="button" name="btAdicionarTopico" id="btAdicionarTopico" value="+" onclick="adicionarTopico();"/><br />
                <input type="button" name="btCriarFicha" id="btCriarFicha" value="Criar Ficha" onclick="formSubmit(); " style="margin:10px"/>
            </form> 
        </div>
    </div>
    
    <script type="text/javascript">

        var counter = 1;
        var formFicha = document.getElementById("formCriarFichaJulgamento");
        var btAdicionarTopico = document.getElementById("btAdicionarTopico");
        var btCriarFicha = document.getElementById("btCriarFicha");

        function removerTopico(){
            if(counter > 1){    

                var input = document.getElementById('topicoNome' + counter);
                var input2 = document.getElementById('pontuacaoTopico'+ counter);
                                
                input.parentNode.removeChild( input );
                input2.parentNode.removeChild( input2 );

                
                
                if(counter == 2){
                    var input3 = document.getElementById("btRemoverTopico");
                
                    input3.parentNode.removeChild( input3 );
                }
                
                formFicha.removeChild(formFicha.lastChild); 
                counter -= 1;
                console.log(counter);
            }
        }

        function adicionarTopico(){
            counter += 1;
            if(counter <= 10){ 
                var newDiv = document.createElement("div");
                newDiv.id = "divLinha"+counter;
                var input = document.createElement("input");
                input.type = "text";
                input.name = "topicoNome" + counter;
                input.id = "topicoNome" + counter;
                input.placeholder = "Nome Topico";
                input.style.margin= "10px";
                input.style.width=  "300px";

                var input2 = document.createElement("input");
                input2.type = "number";
                input2.name = "pontuacaoTopico" + counter;
                input2.id = "pontuacaoTopico" + counter;
                input2.style.margin= "14px";
                input2.style.width=  "110px";
                input2.placeholder = "Pontuacao";
                
                btCriarFicha.before(newDiv)

                newDiv.appendChild(input);
                newDiv.appendChild(input2);

                if(counter == 2){

                    newDiv.innerHTML += "<input type='button' name='btRemoverTopico' id='btRemoverTopico' value='-' onclick='removerTopico();'/>";
                }
                newDiv.innerHTML += "<br />";
                console.log(counter);
            }
        }


        function formSubmit(){
            var hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = "counterTopico";
            hidden.value = counter;
            formFicha.appendChild(hidden);
            pontuacaoTotal = 0;
            for(var i = 1;  i < counter+1; i++ ){
                var pontuacao = document.getElementById("pontuacaoTopico"+i);
                pontuacaoTotal += parseInt(pontuacao.value);
                console.log(pontuacao);
            }
            console.log(pontuacaoTotal);
            if(pontuacaoTotal == 100){
                formFicha.submit();
            }
            else{
                alert("A pontuacao total de todos os topicos e " + pontuacao.value + ". A pontuacao total tem que dar 100.");
            }

        }


        
        
            

    </script>


<?php endif;?>
<?php include ("footer.php"); ?>
