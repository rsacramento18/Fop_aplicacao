$(document).ready(function() {
    $(function(){
        $.datepicker.setDefaults(
            $.extend( $.datepicker.regional[ '' ] )
            );
        $( '.datepicker' ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    // var docHeight = $( window ).height() + 20;
    // var footerHeight = $('footer').height();
    // var footerTop = $('footer').position().top + footerHeight;  
    // if (footerTop < docHeight) {
    //     $('footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
    // }

    $("#table tr").click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');    
        var value=$(this).find('td:first').html();  
    });
    $('#delete User').on('click', function(e){
        var str = $("#table tr.selected td:first").html();     
    });
} );

function deleteUser(){
    var str = $("#table tr.selected td:first").html();
    if(str !== ""){
        $(function() {
            $.ajax({
                url: "deleteUser.php", //assumes file is in root dir//
                type: "post",
                data: "q="+str,
                processData: false,
                success: function(response) {
                    alert('User Removido com Sucesso'); //inserts echoed data into div//
                    window.location.reload();
                }
            });
        });
    }
}

function blockUser(){
    var str = $("#table tr.selected td:first").html();
    if(str !== ""){
        $(function() {
            $.ajax({
                url: "BlockUser.php", //assumes file is in root dir//
                type: "post",
                data: "q="+str,
                processData: false,
                success: function(response) {
                    alert('User Bloqueado/Desbloqueado com Sucesso'); //inserts echoed data into div//
                    window.location.reload();
                }
            });
        });
    }
}

function showUser(str) {
    $(function() {
        $.ajax({
            url: "getUser.php", //assumes file is in root dir//
            type: "post",
            data: "q="+str.value,
            processData: false,
            success: function(response) {
                $("#txtHint").html(response); //inserts echoed data into div//
            }
        });
    });
}

function showUsersDiv() {
 document.getElementById('NcontaDiv').style.display = "none";
 document.getElementById('usersDiv').style.display = "block";
}

function preencherSocio(str1, str2) {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'preencherSocio.php', //assumes file is in root dir//
            data: {source1: str1.value, source2: str2.value},
            success: function(response) {
                $("#txtHint").html(response); //inserts echoed data into div//
            }
        });
    });
}

function showSocios(str1, str2, str3) {
    var variable = $("#squaredTwo2").is(':checked') ? $("#squaredTwo2").val() : 0;
    $(function() {
        $.ajax({
            type: 'post',
            url: 'sociosDisplay.php', //assumes file is in root dir//
            data: {source1: str1.value, source2: str2.value, source3:variable},
            success: function(response) {
                var form = document.getElementById("sociosDisplay");

                var newDiv  = document.createElement("div");
                newDiv.className = 'socioView';
                newDiv.innerHTML = response;

                form.insertBefore(newDiv, form.firstChild);        
            }
        });
    });
}


function editarClube(str1) {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'editarClube.php', //assumes file is in root dir//
            data: {source1: str1.value},
            success: function(response) {
                $("#sociosClubeDisplay").html(response);      
            }
        });
    });
}

function showSociosClube(str1) {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'sociosClubeDisplay.php', //assumes file is in root dir//
            data: {source1: str1.value},
            success: function(response) {
                $("#sociosClubeDisplay").html(response);      
            }
        });
    });
}

function limparDiv(){
    var elements = document.getElementsByClassName("socioView");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
}

function showNContaDiv() {   
 document.getElementById('usersDiv').style.display = "none";
 document.getElementById('NcontaDiv').style.display = "block";
}

function gravarDataAnilha(str1, str2) {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'gravarDataAnilha.php', //assumes file is in root dir//
            data: {source1: str1, source2: str2.value},
        });
    });
}

function dataCustumize(str1, str2){
    var date1 = str2;
    if(str1=="1" && date1!="0000-00-00"){
        document.getElementById("data1text").value = date1;
    }
    else if(str1=="2" && date1!=null){
        document.getElementById("data2text").value = date1;
    }
    else if(str1=="3" && date1!=null){
        document.getElementById("data3text").value = date1;
    }
    else if(str1=="4" && date1!=null){
        document.getElementById("data4text").value = date1;
    }
    else if(str1=="5" && date1!=null){
        document.getElementById("data5text").value = date1;
    }
    else if(str1=="6" && date1!=null){
        document.getElementById("data6text").value = date1;
    }
    
}

function getDataActual(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    today = yyyy+'-'+mm+'-'+dd;
    return today;
}

function showCustoAnilhas(str1) {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'mostrarCusto.php', //assumes file is in root dir//
            data: "q="+str1,
            success: function(response) {
                $("#custoAnilhas").html(response); //inserts echoed data into div//
            }
        });
    });
}


function exportarExel() {
    $(function() {
        $.ajax({
            type: 'post',
            url: 'exportarExel.php', //assumes file is in root dir//
        });
    });
}


