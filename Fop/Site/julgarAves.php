<?php

require_once('../mysql_config.php');
require_once('functions.php');
sec_session_start();
if(isset($_POST['source1'])){
	$idExposicao= $_POST['source1'];
}

echo "<div id='julgarAvesDiv'>";


$user = $_SESSION['user'];
    if($_SESSION['options'] == 1){
        $query = "SELECT * FROM inscreverAves WHERE idExposicao = '$idExposicao' ORDER BY seccao, classe, stam";
    }
    else {
        $query = "SELECT * FROM inscreverAves WHERE idExposicao = '$idExposicao' ORDER BY seccao, classe, stam";
    }
    $stmt = @mysqli_query($dbc, $query);
    if($stmt) {


        $avesInscritas = array();
        $i = 0;

        while ( $row = mysqli_fetch_array($stmt)){
            $avesInscritas[$i][0] = $row['idAveInscrita'];
            $avesInscritas[$i][1] = $row['idExposicao'];
            $avesInscritas[$i][2] = $row['stam'];
            $avesInscritas[$i][3] = $row['clube'];
            $avesInscritas[$i][4] = $row['seccao'];
            $avesInscritas[$i][5] = $row['classe'];
            $avesInscritas[$i][6] = $row['anilhaNum'];
            $avesInscritas[$i][7] = $row['ano'];
            $avesInscritas[$i][8] = $row['preco'];
            $i++;
        } 
        

        $avesInscritasLenght = count($avesInscritas);

        $j = 0;
        
        if($_SESSION['options']==1){
            $seccao = $avesInscritas[0][4];
            echo "<div class='avesBox' id='box$seccao'>";
                echo "<p>$seccao</p>";
            echo "</div>";
            for ($i = 0; $i < $avesInscritasLenght;  $i++){
                if($seccao != $avesInscritas[$i][4]){
                    $seccao = $avesInscritas[$i][4];
                    echo "<div class='avesBox' id='box$seccao'>";
                        echo "<p>$seccao</p>";
                    echo "</div>";

                }
            }
        }
        
                /* if($avesInscritas[$i][5] % 2 == 0 && $j == 0){ */
                /*     echo "<b>Singular----------------------</b>"; */
                /*     $seccao = $avesInscritas[$i][4]; */
                /*     $classe = $avesInscritas[$i][5]; */
                /*     $anilhaNum = $avesInscritas[$i][6]; */
                /*     $ano = $avesInscritas[$i][7]; */
                /*     $preco = $avesInscritas[$i][8]; */
                /*     echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>"; */
                /* } */
                /* else{ */
                /*     if($j == 0){ */
                /*         echo "<b>Equipa-----------------------</b>"; */
                /*     } */
                /*     $seccao = $avesInscritas[$i][4]; */
                /*     $classe = $avesInscritas[$i][5]; */
                /*     $anilhaNum = $avesInscritas[$i][6]; */
                /*     $ano = $avesInscritas[$i][7]; */
                /*     $preco = $avesInscritas[$i][8]; */
                /*     echo "<p>$seccao --- $classe --- $anilhaNum --- $ano --- $preco</p>"; */
                
                /*     $j++; */

                /*     if( $j == 4 ) { */
                /*         $j = 0; */
                /*     } */

                /* } */
            /* } */
            /* } */
        /* } */
        echo "<div id='myModal' class='modal'> ";
            echo "<div id='conteudoModal' class='modal-content'>";
                echo "<h2 id='tituloModal' ></h2>"; 
                echo "<span id='closeModal' class='close'>&times;</span>";    
                echo "<table id='modalContentTable'>";
                echo "<tr><th>Stam</th><th>Seccao</th><th>Classe</th><th>Anilha</th><th>Ano</th><th>Preco</th></tr>";
                echo "</table>";

            echo"</div>";
    
        echo"</div>";

    }
    else{
        echo "erro na query";
    }
echo "</div>";

?>

<script type="text/javascript">
var avesInscritas = <?php echo json_encode($avesInscritas); ?>;
var span = document.getElementById("closeModal");
var modal = document.getElementById("myModal");

console.log(avesInscritas);

$('#julgarAvesDiv').on("click", ".avesBox", function(){
    var elems = document.querySelectorAll(".avesBoxSelected");

    [].forEach.call(elems, function(el) {
        el.classList.remove("avesBoxSelected");
    });
    var elems = document.querySelectorAll(".buttonsAveBox");

    [].forEach.call(elems, function(el) {
        el.classList.remove("avesBoxSelected");
        el.parentNode.removeChild(el);
    });
    this.classList.add("avesBoxSelected");
    var seccao = this.childNodes[0].innerHTML;
    this.innerHTML += "<div class='buttonsAveBox'><input type='button' value='Ver Aves' onclick='verAvesSeccao("+ '"' + seccao + '"' + ");'/><input type='button' value='julgar' onclick='julgarAves("+ '"' + seccao + '"' + ");'/>";

});

    function julgarAves(seccao){
        $.ajax({
            type:'POST',
            url:'julgar.php',
            data: {seccao: seccao},
            success:function(response){
            }
        }); 

    }
    

    function verAvesSeccao(seccao){
        
        
        var modalContent = document.getElementById("modalContentTable");
        for (var i=0; i< avesInscritas.length; i++){
           if(avesInscritas[i][4] == seccao){

                modalContent.childNodes[0].innerHTML += "<tr><td>" + avesInscritas[i][2] + "</td><td>" + avesInscritas[i][3] + "</td><td>" + avesInscritas[i][4] + "</td><td>" + avesInscritas[i][5] + "</td><td>" + avesInscritas[i][6] + avesInscritas[i][7] + "</td><td>" +  avesInscritas[i][8] + "</td></tr>";
            } 

            
        }
        modal.style.display = "block";
    }


    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    } 
	
</script>

