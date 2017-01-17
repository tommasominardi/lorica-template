<?php
kPrintHeader();


foreach($GLOBALS['home_rows'] as $row)
{
	loricaIncludeModules($row, 'home');
}


kPrintFooter();