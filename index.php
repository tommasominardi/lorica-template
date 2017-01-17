<?php
kPrintHeader();


foreach($GLOBALS['page_rows'] as $row)
{
	loricaIncludeModules($row);
}


kPrintFooter();