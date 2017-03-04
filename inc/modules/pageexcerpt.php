<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kHaveNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> excerpt">
		<?= kGetNewsPreview(); ?>&nbsp;
	</div>
	<?php
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?> excerpt">
		<?= kGetPagePreview(); ?>&nbsp;
	</div>
	<?php
}