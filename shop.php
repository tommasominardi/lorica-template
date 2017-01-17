<?php
kPrintHeader();


if(kHaveShopItem())
{

	foreach($GLOBALS['shop_rows'] as $row)
	{
		loricaIncludeModules($row, 'shop');
	}

} else {

	foreach($GLOBALS['shoparchive_rows'] as $row)
	{
		loricaIncludeModules($row, 'shop');
	}

}


kPrintFooter();