<div class="newsletter subscribe">
	<h2><?= kTranslate('Newsletter'); ?></h2>
	<?= kTranslate('Iscriviti alla nostra newsletter'); ?>
	<form action="<?= kGetTemplateDir(); ?>ajax/newsletter.php">
		<input type="text" name="nl_leaveEmpty">
		<input type="text" name="nl_name" placeholder="<?= kTranslate('Scrivi il tuo nome'); ?>"><br>
		<input type="text" name="nl_email" placeholder="<?= kTranslate('Scrivi la tua e-mail'); ?>"><br>
		<input type="hidden" name="nl_code" value="<?= rand(1000,9999).$GLOBALS['loricaOptions']; ?>">
		<div class="submit"><input type="submit" name="nl_submit" value="<?= kTranslate('Iscriviti'); ?>"></div>
	
		<div class="nl_loading"><?= kTranslate('...aspetta un attimo, ti sto iscrivendo...'); ?></div>
		<div class="nl_success"><?= kTranslate('Iscritto con successo'); ?></div>
		<div class="nl_fail"><?= kTranslate('Si sono verificati problemi durante l\'iscrizione, per favore riprova'); ?></div>
	</form>
</div>
