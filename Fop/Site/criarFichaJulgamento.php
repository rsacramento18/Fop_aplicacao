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
           <form action="#" method="post" name="formCriarFichaJulgamento" id="formCriarFichaJulgamento">
                
                <input type ="text" name="nomeFicha" id="nomeFicha" placeHolder="Nome da Ficha" style="margin:10px"/><br /> 

                <input type="text" name="topicoNome1" id="topicoNome1" placeholder="Nome Topico" style="margin:10px; width:300px"/>
                <input type="number" name="pontucaoTopico1" id="pontucaoTopico1" style="margin:10px; width:70px"/>
                <input type="button" name="btAdicionarTopico" id="btAdicionarTopico" value="+" onclick="adicionarTopico();"/><br />
            </form> 
        </div>
    </div>
    
    <script type="text/javascript">

        var counter = 1;
        var formFicha = document.getElementById("formCriarFichaJulgamento");
        var btAdicionarTopico = document.getElementById("btAdicionarTopico");

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
                input2.style.width=  "70px";

                formFicha.appendChild(input);
                formFicha.appendChild(input2);

                if(counter == 2){

                    formFicha.innerHTML += "<input type='button' name='btRemoverTopico' id='btRemoverTopico' value='-' onclick='removerTopico();'/>";
                }
                formFicha.innerHTML += "<br />";
                console.log(counter);
            }
        }


        
        
            

    </script>


<?php endif;?>
<?php include ("footer.php"); ?>
