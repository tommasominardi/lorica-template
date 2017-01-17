<?php
kSetMenuSelectedByURL(kGetShopCartDir());
kPrintHeader();

/**********************************************
*  PREPROCESS PERSONAL DATA WHEN PAGE IS LOADED
**********************************************/
if(!isset($_SESSION['orderData'])) $_SESSION['orderData']=array("customer"=>array(),"delivery"=>array(),"payment"=>array());

// if not isset, create arrays with empty values (in order to avoid error notices)
// and fill the array in case of posted values
foreach(array("name","email","phone","address","city","state","zipcode","country","message") as $var) {
	if(!isset($_SESSION['orderData']['customer'][$var])) $_SESSION['orderData']['customer'][$var]="";
	if(!isset($_SESSION['orderData']['delivery'][$var])) $_SESSION['orderData']['delivery'][$var]="";
	if(!isset($_SESSION['orderData']['payment'][$var])) $_SESSION['orderData']['payment'][$var]="";

	if($_SESSION['orderData']['customer'][$var]=="" && kMemberIsLogged()) $_SESSION['orderData']['customer'][$var]=kGetMemberMetadata('shop_customer_'.$var);

	if(isset($_POST['customer_'.$var])) {
		$_SESSION['orderData']['customer'][$var]=$_POST['customer_'.$var];
		$_SESSION['orderData']['delivery'][$var]=$_POST['customer_'.$var];
		$_SESSION['orderData']['payment'][$var]=$_POST['customer_'.$var];
		}
	}
if(isset($_POST['customdelivery'])) {
	$_SESSION['orderData']['delivery']=array();
	foreach(array("name","email","phone","address","city","state","zipcode","country","carrier") as $var) {
		if($_POST['customdelivery']=='yes') {
			if(isset($_POST['delivery_'.$var])) $_SESSION['orderData']['delivery'][$var]=$_POST['delivery_'.$var];
			}
		}
	}
if(isset($_POST['invoice'])) {
	$_SESSION['orderData']['payment']=array();
	foreach(array("name","vat","cf","email","phone","address","city","zipcode","country","method") as $var) {
		if($_POST['invoice']=='yes') {
			if(isset($_POST['payment_'.$var])) $_SESSION['orderData']['payment'][$var]=$_POST['payment_'.$var];
			}
		}
	}
if(isset($_POST['payment_cf'])) $_SESSION['orderData']['payment']['cf']=$_POST['payment_cf'];
if(isset($_POST['payment_method'])) $_SESSION['orderData']['payment']['method']=$_POST['payment_method'];
if(!isset($_SESSION['orderData']['customer']['country'])||$_SESSION['orderData']['customer']['country']=="") $_SESSION['orderData']['customer']['country']=kDetectLang();

//precompiled fields
global $fieldValue;
$fieldValue=array();
foreach(array("name","email","phone","address","city","state","zipcode","country","carrier") as $var) {
	if(!empty($_SESSION['orderData']['delivery'][$var])) $fieldValue['delivery'][$var]=$_SESSION['orderData']['delivery'][$var];
	elseif(kMemberIsLogged()) $fieldValue['delivery'][$var]=kGetMemberMetadata('shop_delivery_'.$var);
	else $fieldValue['delivery'][$var]="";
	}
foreach(array("name","vat","cf","email","phone","address","city","zipcode","country","method") as $var) {
	if(!empty($_SESSION['orderData']['payment'][$var])) $fieldValue['payment'][$var]=$_SESSION['orderData']['payment'][$var];
	elseif(kMemberIsLogged()) $fieldValue['payment'][$var]=kGetMemberMetadata('shop_payment_'.$var);
	else $fieldValue['payment'][$var]="";
	}



/**********************************************
*  ORDER CONFIRMATION
**********************************************/

if(isset($_POST['confirmOrder'])) {
	?>

	<div class="row">
		<div class="grid w8 center">
		<?
		$log=kShopCheckOrderValidity($_SESSION['orderData']);

		//if order is not valid: print error message
		if($log!=false) {
			echo '<div class="alert">'.kTranslate($log['description']).'</div>';
			?>
			<div class="cartNav">
				<small><a href="?"><?= kTranslate('back'); ?></a></small>
			</div>
			<?
			}

		//order is valid: save it!
		else {
			$uid = kShopSaveOrder($_SESSION['orderData'],false);
			if($uid!=false) {
				kSetShopOrderByNumber($uid);
				$pay=kGetShopPaymentById(kGetShopOrderVar('idspay'));
				?>
				<div class="textBox">
					<?= kTranslate('Your order was successfully processed'); ?>.<br /><br />
					<?
					if($pay['gateway']=='paypal') {
						?>
						<?= kTranslate('You are about to be redirected to PayPal for payment'); ?><br />
						<?= kTranslate("If it doesn't work, click on the following link"); ?><br />
						<?
						kPrintShopPayPalForm();
						}
					elseif($pay['gateway']=='virtualpay') {
						?>
						<?= kTranslate('You are about to be redirected to VirtualPay for payment'); ?><br />
						<?= kTranslate("If it doesn't work, click on the following link"); ?><br />
						<?
						kPrintShopVirtualPayForm();
						}
					elseif($pay['gateway']=='pagonline') {
						?>
						<?= kTranslate('You are about to be redirected to our payment gateway'); ?><br />
						<?= kTranslate("If it doesn't work, click on the following link"); ?><br />
						<?
						kPrintShopPagonlineForm();
						}
					else { ?>
						<meta http-equiv="refresh" content="0; url=<?= kGetCurrentLanguageDir().kGetShopPayPalReturnPage(true); ?>">
						<? }
					?>
				</div>
				<?
				kShopEmptyCart();

			} else {
				$msg="Un ordine <strong>non</strong> è andato a buon fine.<br>Di seguito i dati raw per cercare di capire il problema:<br><br>";
				$msg.=serialize($_SESSION['orderData']).'<br><br>';
				$msg.=serialize(kGetShopCart());
				if(isset($GLOBALS['error_query'])) $msg.='<br><br>Query<br>'.$GLOBALS['error_query'];
				kSendEmail(ADMIN_MAIL, ADMIN_MAIL, kTranslate("Errore di registrazione dell'ordine"), $msg);
				?>
				<div class="textBox">
					<?= kTranslate("Purtroppo in seguito a problemi tecnici non siamo riusciti a registrare correttamente il tuo ordine."); ?><br>
					<?= kTranslate("Sarai contattato al più presto per la finalizzazione l'acquisto."); ?><br>
					<?= kTranslate('Sorry for the inconvenient.'); ?><br>
					Old Europa Cafe
				</div>
				<? }
			}
		?>
		</div>
	</div>

	<?
}



foreach($GLOBALS['cart_rows'] as $row)
{
	loricaIncludeModules($row);
}


kPrintFooter();