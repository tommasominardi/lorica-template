<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kHaveNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
		<?= kGetNewsPreview(); ?>&nbsp;
	</div>
	<?php
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
		<?= kGetPagePreview(); ?>&nbsp;
	</div>
	<?php
}