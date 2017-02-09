<?php include ("header.php"); ?>
<?php if (login_check($dbc) == true || login_checkSocios($dbc) == true || login_checkEstrangeiros($dbc) == true) : ?>
	<div class="wrapper-content">
		<div id="loggado">
			<?php 
			echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
			echo "<p>" . $_SESSION['clube'] . "</p>";
			?>
		</div>
		<h1>Esta e a Home Page</h1>
        <?php
            if($_SESSION['privilegio'] == 'Socio'){
                $stam = $_SESSION['user'];
                $query = "SELECT contribuinte FROM socios WHERE stam = '$stam'";
                $contribuinte = 0;
                if($stmt = @mysqli_query($dbc, $query)) {
                    $row = mysqli_fetch_array($stmt);
                    $contribuinte =  $row['contribuinte'];
                }
                if($contribuinte == 0){
                    echo "<div id='myModal' class='modal' style='display:block'> ";
                        echo "<div id='conteudoModal' class='modal-content'>";
                            echo "<h2 id='tituloModal' >Inserir Contribuinte</h2>"; 
                            echo "<p>Para continuar tem que introduzir o seu numero de contribuinte!</p>";
                            echo "<form method='post' action='inserirContribuinte.php' id='formInserirContribuinte'/>";
                                echo "<input type='number' name='contribuinte' id='contribuinte' placeholder='Contribuinte'/>";
                                echo "<input type='hidden' name='user' id='user' value='$stam'/>";
                                echo "<input type='submit' name='btContribuinte' id='btContribuinte' value='Gravar Contribuinte' />";
                                echo "<input type='button' value='sair' onclick='sair();' />";
                            echo "</form>";
                        echo"</div>";
                    echo"</div>";
                }

            }
        ?>
    </div>
    <script type="text/javascript">
        function sair(){
            window.location='logout.php';
        }
    </script>

<?php endif;?>
<?php include ("footer.php"); ?>
