<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
	$error = 'Oops! Um erro aconteceu..';
}
include ("header.php");
if (login_check($dbc) == true) : ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<h1>Houve um problema!</h1>
	<p class="error"><?php echo $error; ?></p>
</div>

<?php endif;?>
<?php include ("footer.php"); ?>