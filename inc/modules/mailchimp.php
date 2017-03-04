<div class="newsletter subscribe mailchimp">
	<h2><?= kTranslate('Newsletter'); ?></h2>
	<p><?= kTranslate('Iscriviti alla nostra newsletter'); ?></p>
	<form action="<?= kGetTemplateDir(); ?>ajax/mailchimp.php">
		<input type="text" name="nl_leaveEmpty">
		<input type="text" name="nl_name" placeholder="<?= kTranslate('Scrivi il tuo nome'); ?>"><br>
		<input type="text" name="nl_email" placeholder="<?= kTranslate('Scrivi la tua e-mail'); ?>"><br>
		<input type="hidden" name="nl_code" value="<?= $GLOBALS['loricaOptions']; ?>">
		<div class="submit"><input type="submit" name="nl_submit" value="<?= kTranslate('Iscriviti'); ?>"></div>
	
		<div class="nl_loading"><?= kTranslate('...aspetta un attimo, ti sto iscrivendo...'); ?></div>
		<div class="nl_success"><?= kTranslate('Iscritto con successo'); ?></div>
		<div class="nl_fail"><?= kTranslate('Si sono verificati problemi durante l\'iscrizione, per favore riprova'); ?></div>
	</form>
</div>
