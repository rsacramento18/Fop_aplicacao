<?php include ("header.php"); ?>
<?php
if (login_check($dbc) == true) : ?>
<div class="wrapper-content">
	<div id="loggado">
		<?php 
		echo "<p>" . $_SESSION['user'] . "-" . $_SESSION['privilegio'] . "</p>";
		echo "<p>" . $_SESSION['clube'] . "</p>";
		?>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.tabs .tab-links a').on('click', function(e)  {
				var currentAttrValue = jQuery(this).attr('href');
				
				jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
				
				jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
				
				e.preventDefault();
			});

			document.getElementById('selectClube').style.display = "none";

			$('#privilegio').change(function () {
				if($('#privilegio').val() == "clube"){
					document.getElementById('selectClube').style.display = "";
				}
				else{
					$("#selectClube").val($("#selectClube option:first").val());
					document.getElementById('selectClube').style.display = "none";
				}
			});
		});
	</script>
	<h1>Gestao Contas</h1>

	<div class="tabs">
		<ul class="tab-links">
			<li class="active"><a href="#tab1">Ver Contas</a></li>
			<li><a href="#tab2">Criar Nova Conta</a></li>
		</ul>

		<div class="tab-content" >
			<div id="tab1" class="tab active">
				<?php getUsers($dbc)?>
				<input type="button" value="Elminar Conta" id="btEliminarConta" name"EContaBt" onclick="deleteUser()"/>
				<span class="labels"> Selecione uma conta primeiro para eliminar.</span>
				<input type="button" value="Bloquear/Desbloquear Conta" id="btBloquearConta" name"BContaBt" onclick="blockUser()"/>
				<span class="labels"> Selecione uma conta primeiro para bloquear.</span>
			</div>

			<div id="tab2" class="tab">
				<form action="register.inc.php" method="post" name="registration_form" id="registration_form">
					<h2>Criar nova conta de Utilizador</h2>
					<input type="text" name="user" size="30"  id="user" placeholder="User" /><span class="labels">Introduzir um nome de utilizador para a conta.</span><br />
					<input type="text" name="password" size="30"  id="password" placeholder="Password" /><span class="labels">Introduzir uma Password para a conta.</span> <br/>
					<input type="text" name="confirmpwd" id="confirmpwd" size="30"  placeholder="Confirm Password" /><span class="labels">Confirmar a Password.</span> <br />
					<select name="privilegio" id="privilegio">
						<option value="privilegio">Privilegio</option>
						<option value="fop">Fop</option>
						<option value="clube">Clube</option>
						<option value="colegioJuizes">Colégio de Juizes</option>
					</select><span class="labels">Selecionar um privilegio associado à conta.</span><br/>						
					<select name="clubes" id="selectClube">
						<option></option>	
						<?php getClubes($dbc)?>						
					</select><span class="labels">Selecionar um clube associado à conta.</span> <br/>
					
					<input type="button" value="Resgistar Utilizador"  onclick="return regformhash(this.form,
						this.form.user,
						this.form.password,
						this.form.confirmpwd,
						this.form.privilegio,
						this.form.clubes);"/>
					</form>
				</div>		     
			</div>
		</div>
	</div>
<?php endif; ?> 
<?php include ("footer.php"); ?>