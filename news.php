<?php
kPrintHeader();


if(kHaveNews())
{
	if(empty($GLOBALS['news_rows'])) $GLOBALS['news_rows']=[];
	foreach($GLOBALS['news_rows'] as $row)
	{
		loricaIncludeModules($row, 'news');
	}

} else {

	if(empty($GLOBALS['newsarchive_rows'])) $GLOBALS['news_rows']=[];
	foreach($GLOBALS['newsarchive_rows'] as $row)
	{
		loricaIncludeModules($row, 'news');
	}

}


kPrintFooter();