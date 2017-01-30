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

        $prep_stmt = "SELECT user_id FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $dbc->prepare($prep_stmt);

        if($stmt){
          $stmt->bind_param('s', $user);
          $stmt->execute();
          $stmt->store_result();

          if($stmt->num_rows == 1 ) {
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
            $stmt->close();
        }

    }
    else {
      $error_msg .= '<p class="error">Database error Line 39</p>';
      $stmt->close();
  }

  if(empty($error_msg)) {
      $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
      
      $password = hash('sha512', $password . $random_salt);

      $query = "INSERT INTO users ( user_id , privilegio, password, salt, clube) 
      VALUES ( ?, ?, ?, ?, ?)";
      if ($insert_stmt = mysqli_prepare($dbc, $query)){
        
        mysqli_stmt_bind_param($insert_stmt, 'sssss', $user, $privilegio, 
            $password, $random_salt, $clube);
                // Execute the prepared query.
        mysqli_stmt_execute($insert_stmt);
        $affected_rows = mysqli_stmt_affected_rows($insert_stmt);
        if (! $affected_rows == 1) {
            header('Location: error.php?err=Registration failure: INSERT');
        }
        else{
            header('Location: register_success.php');
        }   
    }
    else {
        header('Location: error.php?err=Registration failure: INSERT2');
    }
}
}

?
