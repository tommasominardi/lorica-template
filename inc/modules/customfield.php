<?php
$field_name = $GLOBALS['loricaOptions'];


if(kHaveShopItem()) {
	kSetShopItemByDir();
	$customfield = (kGetShopItemCustomFields([ "name"=>$field_name ]));
	
	if(!empty($customfield[0]) && !empty($customfield[0]['value']))
	{
		echo '<div class="customfield"><span class="customfield name">'. $customfield[0]['name'] .'</span>: <span class="customfield value">'.$customfield[0]['value'].'</span></div>';
	}
}