<?php
require_once '../mysql_config.php';

$error_msg = "";



if(isset($_POST['nomeRegistar'], $_POST['stamRegistarInternacional'], $_POST['idRegistarInternacional'], $_POST['paisRegistarInternacional'], $_POST['addressRegistarInternacional'], $_POST['p'] )) {

    $nomeRegistar = filter_input(INPUT_POST, 'nomeRegistar', FILTER_SANITIZE_STRING);
    $stamRegistarInternacional = filter_input(INPUT_POST, 'stamRegistarInternacional', FILTER_SANITIZE_STRING);
    $idRegistarInternacional = filter_input(INPUT_POST, 'idRegistarInternacional', FILTER_SANITIZE_NUMBER_INT);
    $paisRegistarInternacional = filter_input(INPUT_POST, 'paisRegistarInternacional', FILTER_SANITIZE_STRING);
    $addressRegistarInternacional = filter_input(INPUT_POST, 'addressRegistarInternacional', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
       		// The hashed pwd should be 128 characters long.
        	// If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    
   
	$stamExistente = '';
    $query = "SELECT stamCFROM contasEstrangeiro WHERE stam = '$stamRegistarInternacional' LIMIT 1";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $stamExistente = $row['stam'];
        if($stamExistente == $stamRegistarInternacional) $error_msg .= '<p class="error">The stam you inserted is already associated with another account in the database please choose another.</p>';
	}


	$biExistente = '';
    $query = "SELECT id FROM contasEstrangeiro WHERE id = '$idRegistarInternacional' LIMIT 1";
    if($stmt = @mysqli_query($dbc, $query)) {
        $row = mysqli_fetch_array($stmt);
        $biExistente= $row['bi'];
        if($biExistente== $idRegistarInternacional) $error_msg .= '<p class="error">The id you inserted is already associated with another account.Please choose another.</p>';
	}

        
    echo $error_msg;
    if(empty($error_msg)) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
      
        $password = hash('sha512', $password . $random_salt);

        $query = "INSERT INTO contasEstrangeiro ( name, stam, id, country, address, password, salt) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        if ($insert_stmt = mysqli_prepare($dbc, $query)){
        
            mysqli_stmt_bind_param($insert_stmt, 'sssssss', $nomeRegistar, $stamRegistarInternacional, $idRegistarInternacional, $paisRegistarInternacional, $addressRegistarInternacional, $password, $random_salt);
                // Execute the prepared query.
            mysqli_stmt_execute($insert_stmt);
            $affected_rows = mysqli_stmt_affected_rows($insert_stmt);
            if (! $affected_rows == 1) {
                header('location: error2.php?err=There was an error inserting data to the data base. Please try again.');
            }
            else{
                header('Location: register_success.php');
            }   
        }
        else{
            echo "nao deu";
        }
    }
    else {
          
            header('location: error2.php?err='.$error_msg);
    }
}
else{
    echo "nao deu";
}



?>
