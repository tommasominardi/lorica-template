<?php
kPrintHeader();


foreach($GLOBALS['home_rows'] as $row)
{
	?><div class="row"><?php
	
		loricaIncludeModules($row);
	
	?></div><?php
}


kPrintFooter(); ?>