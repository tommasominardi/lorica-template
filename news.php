<?php
kPrintHeader();


if(kHaveNews())
{

	foreach($GLOBALS['news_rows'] as $row)
	{
		loricaIncludeModules($row, 'news');
	}

} else {

	foreach($GLOBALS['newsarchive_rows'] as $row)
	{
		loricaIncludeModules($row, 'news');
	}

}


kPrintFooter();