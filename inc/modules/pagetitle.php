<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kHaveNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> title">
		<h1><?= kGetNewsTitle(); ?>&nbsp;</h1>
	</div>
	<?php
} elseif(kHaveShopItem()) {
	kSetShopItemByDir();
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> title">
		<h1><?= kGetShopItemTitle(); ?>&nbsp;</h1>
	</div>
	<?php
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> title">
		<h1><?= kGetPageTitle(); ?>&nbsp;</h1>
	</div>
	<?php
}