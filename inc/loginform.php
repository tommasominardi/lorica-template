<?php
if(!kMemberIsLogged())
{ 
	if(isset($_POST['login_username'])&&isset($_POST['login_password'])) {
		?>
		<div class="alert"><?= kTranslate('Username o password errati'); ?></div>
		<?php
	}
	?>
	<form action="" method="post" class="loginForm">
		<div class="row">
			<div class="grid w5 column">
				<label for="login_username"><?= kTranslate('Nome utente'); ?></label>
				<input type="text" id="login_username" name="login_username" />
			</div>
			<div class="grid w5 column">
				<label for="login_password"><?= kTranslate('Password'); ?></label>
				<input type="password" id="login_password" name="login_password" />
			</div>
			<div class="grid w2 column submit">
				<input type="submit" value="<?= kTranslate('Accedi'); ?>" />
			</div>
		</div>
	</form>
<?php
}