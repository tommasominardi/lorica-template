<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);
?>
<a href="<?= kGetBaseDir(); ?>" class="logo"><h2><?php
	if($GLOBALS['display_logo'] == true) { ?><img src="<?= kGetTemplateDir(); ?>img/logo<?= $GLOBALS['loricaColumnWide']<4 ? '_small' : ''; ?>.png" alt="<?= kGetSiteName(); ?>"><? }
	else { echo kGetSiteName(); }
?></h2></a>
