<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kHaveNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
		<?= kGetNewsText(); ?>&nbsp;
	</div>
	<?php
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
		<?= kGetPageText(); ?>&nbsp;
	</div>
	<?php
}