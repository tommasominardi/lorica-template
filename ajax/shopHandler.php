<?
/* (c)2014 Kalamun GPL v3*/

require_once('../../../inc/tplshortcuts.lib.php');
kInitBettino('../../../');

/* get item price */
if(isset($_GET['getItemPrice']))
{
	kSetShopItemById($_GET['getItemPrice']);
	$variations=explode(',',trim($_GET['variations'],','));
	echo number_format(kGetShopItemPrice(array("idsitem"=>$_GET['getItemPrice'],"variations"=>$variations)),2);
}

/* get total amount */
elseif(isset($_POST['getTotalAmount']))
{
	echo number_format(kGetShopCartItemsAmount(),2).' '.kGetShopCurrency("symbol");
}

/* add an item to cart */
elseif(isset($_POST['addToCart']))
{
	kSetShopItemById($_POST['addToCart']);
	$qty=isset($_POST['qty'])?intval($_POST['qty']):1;
	$variations=isset($_POST['variations'])&&is_array($_POST['variations'])?$_POST['variations']:array();
	$customvariations=isset($_POST['customvariations'])&&is_array($_POST['customvariations'])?$_POST['customvariations']:array();

	if(kGetShopItemId()>0) kShopAddToCart(kGetShopItemId(),$qty,$variations,$customvariations);

	// print the entire list of items into the cart
	$cart=kGetShopCart();
	foreach($cart['items'] as $item)
	{
		echo $item['id'].'|'.$item['qty'].'|'.number_format($item['totalprice'],2)."\n";
	}
	// print the summary
	echo 'tot||'.number_format(kGetShopCartItemsAmount(),2);
}
	
/* remove an item from cart */
elseif(isset($_POST['removeFromCart']))
{
	kSetShopItemById($_POST['removeFromCart']);
	$qty=isset($_POST['qty'])?intval($_POST['qty']):1;
	$variations=isset($_POST['variations'])&&is_array($_POST['variations'])?$_POST['variations']:array();
	if(kGetShopItemId()>0)
	{
		kShopRemoveFromCart(kGetShopItemId(),$qty,$variations);
	}
	// return the entire list of items into the cart
	$cart=kGetShopCart();
	foreach($cart['items'] as $item) {
		echo $item['id'].'|'.$item['qty'].'|'.number_format($item['totalprice'],2)."|".$item['realprice']."\n";
		}
	echo 'tot||'.number_format(kGetShopCartItemsAmount(),2);
}

/* increase the number of items in the cart */
elseif(isset($_POST['increaseCartItem']))
{
	kShopIncreaseCartItem($_POST['increaseCartItem']);
	// print the entire list of items into the cart
	$cart=kGetShopCart();
	foreach($cart['items'] as $item)
	{
		echo $item['id'].'|'.$item['qty'].'|'.number_format($item['totalprice'],2)."|".$_POST['increaseCartItem']."\n";
	}
	// print the summary
	echo 'tot||'.number_format(kGetShopCartItemsAmount(),2)."|".$_POST['increaseCartItem'];
}

/* decrease the number of items in the cart */
elseif(isset($_POST['decreaseCartItem']))
{
	// backup of the current item
	$backupitem=array();
	$cart=kGetShopCart();
	foreach($cart['items'] as $item)
	{
		if($item['uid']==$_POST['decreaseCartItem']) $backupitem=$item;
	}
	
	kShopDecreaseCartItem($_POST['decreaseCartItem']);
	// print the entire list of items into the cart
	$cart=kGetShopCart();
	$iszero=true;
	foreach($cart['items'] as $item)
	{
		echo $item['id'].'|'.$item['qty'].'|'.number_format($item['totalprice'],2)."|".$_POST['decreaseCartItem']."\n";
		if($item['uid']==$_POST['decreaseCartItem']) $iszero=false;
	}
	if($iszero==true)
	{
		echo $backupitem['id']."|0|0|".$_POST['decreaseCartItem']."\n";
	}
	// print the summary
	echo 'tot||'.number_format(kGetShopCartItemsAmount(),2)."|".$_POST['decreaseCartItem'];
}
	
/* get deliverer by country code */
elseif(isset($_GET['getDeliversByCountryCode'])) {
	$cart=kGetShopCart();
	$zone=kGetShopZoneByCountryCode($_GET['getDeliversByCountryCode']);
	$deliverers=kGetShopDeliverersByZone($zone);
	$i=0;
	foreach($deliverers as $del) {
		kSetShopDelivererById($del['iddel']);
		$spedizione=kGetShopDelivererPriceByKg($cart['totalweight']);
		?><input type="radio" name="delivery_method" id="Deliverer<?= $del['iddel']; ?>" value="<?= $del['iddel']; ?>"<?= ($del['iddel']==$Deliverer||($del['iddel']!=$Deliverer&&$i==0)?' checked':''); ?>> <label for="Deliverer<?= $del['iddel']; ?>"><strong><?= $del['name']; ?></strong></label><br /><?
		$i++;
		}
	}

/* get payment methods by country code */
elseif(isset($_GET['getPaymentsByCountryCode']))
{
	$cart=kGetShopCart();
	$zone=kGetShopZoneByCountryCode($_GET['getPaymentsByCountryCode']);
	$payments_modes=kGetShopPaymentsByZone($zone);
	$i=0;
	foreach($payments_modes as $pay)
	{
		kSetShopPaymentById($pay['idspay']);
		?>
		<input type="radio" name="payment_method" id="Payment<?= $pay['idspay']; ?>" value="<?= $pay['idspay']; ?>"<?= ($i==0)?' checked':''; ?>><label for="Payment<?= $pay['idspay']; ?>"><strong><?= $pay['name']; ?></strong> <?= ($pay['price']>0?'('.$pay['price'].' '.kGetShopCurrency("symbol").')':'') ?><?= ($pay['pricepercent']>0?'('.$pay['pricepercent'].'%)':'') ?></label>
		<div style="padding-left:20px;"><?= $pay['descr']; ?></div>
		<?
		$i++;
	}
}

/* print the cart summary - used for widget */
elseif(isset($_POST['getCartSummary']))
{
	include('../inc/modules/minicart.php');
}

