<?php
require_once '../mysql_config.php';

$error_msg = "";



if(isset($_POST['stamRegistar'], $_POST['biRegistar'], $_POST['p'] )) {

    $stamRegistar = filter_input(INPUT_POST, 'stamRegistar', FILTER_SANITIZE_STRING);
    $biRegistar= filter_input(INPUT_POST, 'biRegistar', FILTER_SANITIZE_NUMBER_INT);

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
       		// The hashed pwd should be 128 characters long.
        	// If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    
    $stamRegistar = strtoupper($stamRegistar);

    if (!preg_match(
    '/^            # Start of string
    (?=.*\p{Lu}.*\p{Lu})   # at least one uppercase letter
    (?=.*\d.*\d)   # at least two digits
    .{4}           # exactly 8 characters
    $              # End of string
    /xu',     
    $stamRegistar)) $error_msg .= '<p class"error">O stam Indicado nao tem o formato AA11.</p>';

    $stamRegistar .= '-FOP';


    $query = "SELECT stam FROM socios WHERE stam = '$stamRegistar' LIMIT 1";
	$stamExistente = '';
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$stamExistente =  $row['stam'];
        if($stamExistente != $stamRegistar) $error_msg .= '<p class="error">O stam indicado nao existe na base  de dados. Escolha Outro</p>';
        $query = "SELECT stamContaSocio FROM contasSocio WHERE stamContaSocio = '$stamRegistar' LIMIT 1";
        if($stmt = @mysqli_query($dbc, $query)) {
            $row = mysqli_fetch_array($stmt);
            $stamExistente = $row['stamContaSocio'];
            if($stamExistente == $stamRegistar) $error_msg .= '<p class="error">O stam indicado ja existe noutra conta Indique outro stam.</p>';
        }
	}


    $query = "SELECT bi FROM socios WHERE bi = '$biRegistar' LIMIT 1";
	$biExistente = '';
	if($stmt = @mysqli_query($dbc, $query)) {
		$row = mysqli_fetch_array($stmt);
		$biExistente=  $row['bi'];
        if($biExistente != $biRegistar) $error_msg .= '<p class="error">O bi indicado nao existe na base  de dados. Escolha Outro.</p>';
        $query = "SELECT bi FROM contasSocio WHERE bi = '$biRegistar' LIMIT 1";
        if($stmt = @mysqli_query($dbc, $query)) {
            $row = mysqli_fetch_array($stmt);
            $biExistente= $row['bi'];
            if($biExistente== $biRegistar) $error_msg .= '<p class="error">O bi indicado ja existe noutra conta Indique outro stam.</p>';
        }
	}

        
    echo $error_msg;
    if(empty($error_msg)) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
      
        $password = hash('sha512', $password . $random_salt);

        $query = "INSERT INTO contasSocio( stamContaSocio ,bi , password, salt) VALUES ( ?, ?, ?, ?)";
        if ($insert_stmt = mysqli_prepare($dbc, $query)){
        
            mysqli_stmt_bind_param($insert_stmt, 'ssss', $stamRegistar, $biRegistar, 
            $password, $random_salt);
                // Execute the prepared query.
            mysqli_stmt_execute($insert_stmt);
            $affected_rows = mysqli_stmt_affected_rows($insert_stmt);
            if (! $affected_rows == 1) {
                header('Location: error2.php?err=Registration failure: INSERT');
            }
            else{
                header('Location: register_success.php');
            }   
        }
    }
    else {
            header('location: error2.php?err=registration failure: insert2');
    }
}



?>
