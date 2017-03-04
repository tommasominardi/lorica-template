<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kHaveNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> subtitle">
		<h2><?= kGetNewsSubtitle(); ?></h2>
	</div>
	<?php
} elseif(kHaveShopItem()) {
	kSetShopItemByDir();
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> subtitle">
		<h2><?= kGetShopItemSubtitle(); ?></h2>
	</div>
	<?php
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> subtitle">
		<h2><?= kGetPageSubtitle(); ?></h2>
	</div>
	<?php
}