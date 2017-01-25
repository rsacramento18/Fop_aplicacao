<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<div class="wrapper-content">
    <h1>Conta Bloqueada</h1>
    <p class="error"><?php echo $error; ?></p>
</div>
