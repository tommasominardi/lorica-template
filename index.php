<?php
kPrintHeader();


foreach($GLOBALS['page_rows'] as $row)
{
	?><div class="row"><?php
	
		loricaIncludeModules($row);
	
	?></div><?php
}


kPrintFooter(); ?>