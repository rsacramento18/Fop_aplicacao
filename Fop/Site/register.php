<?php
include_once 'register.inc.php';
include_once 'functions.php';
?>
<!doctype html>
<html>
<head>
  <title>register</title>
  <script type="text/javascript" src="js/sha512.js"></script> 
  <script type="text/javascript" src="js/form.js"></script>
  <link href='https://fonts.googleapis.com/css?family=inconsolata' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="styles/normalize.css" />
  <link rel="stylesheet" href="styles/login_register.css" />
</head>
<body>
  <?php
  if (!empty($error_msg)) {
    echo $error_msg;
  }
  ?>
  <div id="registar">
    <h1>registar</h1>
  </div>
  <div id ="register_div">
    <form action="<?php echo esc_url($_server['php_self']); ?>" method="post" name="registration_form">
      <p>user</p>
      <input type="text" name="user" size="30"  id="primeiro_nome"/>

      <p>password</p>
      <input type="password" name="password" size="30"  id="password"/>

      <p>confirm password</p>
      <input type="password" name="confirmpwd" id="confirmpwd" size="30" />

      <p id = "bt_register">
        <input type="button" value="register"  onclick="return regformhash(this.form,
         this.form.user,
         this.form.password,
         this.form.confirmpwd);"/>
       </p>
     </form>
     <p><a href="login.php">return to login</a></p>
   </div>
 </body>
 </html>
