<? if(!kMemberIsLogged()) { ?>
	<? if(isset($_POST['login_username'])&&isset($_POST['login_password'])) { ?>
		<div class="alert"><?= kTranslate('Username o password errati'); ?></div>
		<? } ?>
	<form action="" method="post">
		<table style="margin:0 auto;">
		<tr>
		<td><label for="login_username"><?= kTranslate('Username'); ?></label></td><td><input type="text" id="login_username" name="login_username" /></td>
		<td><label for="login_password"><?= kTranslate('Password'); ?></label></td><td><input type="password" id="login_password" name="login_password" /></td>
		<td colspan="2" class="submit"><input type="submit" value="<?= kTranslate('Accedi'); ?>" /></td>
		</tr>
		</table>
		</form>
	<? } ?>