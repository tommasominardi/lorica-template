<?php
kPrintHeader();


if(kHaveNews())
{

	foreach($GLOBALS['news_rows'] as $row)
	{
		?><div class="row"><?php
		
			loricaIncludeModules($row);
		
		?></div><?php
	}

} else {

	foreach($GLOBALS['newsarchive_rows'] as $row)
	{
		?><div class="row"><?php
		
			loricaIncludeModules($row);
		
		?></div><?php
	}

}


kPrintFooter(); ?>