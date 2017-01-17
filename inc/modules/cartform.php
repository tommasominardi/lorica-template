<?php
$cart=kGetShopCart();
global $fieldValue;
?>
<section class="cartForm">
<?php

// if cart is not empty, print the form
if($cart['itemsnumber']>0) {

	/* LOGIN */
	if(!kMemberIsLogged())
	{ ?>
		<section class="login margin-top-60">
			<h2><?= kTranslate('Hai già un utente?'); ?></h2>
			<?= kTranslate('Accedi per trovare tutto precompilato coi tuoi dati'); ?>
			<?
			kPrintLogInForm();
			?>
		</section>
		<?php
	}
	?>

	<section class="personalData margin-top-60">
		<form action="" method="post" class="personalData">
			<h2><?= kTranslate("I tuoi dati personali"); ?></h2>
			<table>
			<tr><td><?= kTranslate("Nome e cognome"); ?> *</td><td><input type="text" name="customer_name" id="field_name" mandatory="true" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['name']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("E-mail"); ?> *</td><td><input type="text" name="customer_email" id="field_email" mandatory="true" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['email']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("Numero di telefono"); ?> *</td><td><input type="text" name="customer_phone" id="field_Phone" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['phone']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("Indirizzo"); ?> *</td><td><input type="text" name="customer_address" id="field_Address" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['address']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("Città"); ?> *</td><td><input type="text" name="customer_city" id="field_City" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['city']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("Provincia"); ?></td><td><input type="text" name="customer_state" id="field_State" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['state']); ?>" class="normal" />
					<?= kTranslate("CAP"); ?> * <input type="text" name="customer_zipcode" id="field_ZipCode" value="<?= str_replace('"','&quot;',$_SESSION['orderData']['customer']['zipcode']); ?>" class="normal" style="width:80px;" /></td></tr>
			<tr><td><?= kTranslate("Paese"); ?> *</td><td><select name="customer_country" id="customer_country" mandatory="true"><?
				foreach(kGetShopCountries() as $country) { ?>
					<option value="<?= $country['ll']; ?>"<?= $country['ll']==$_SESSION['orderData']['customer']['country']?' selected':''; ?>><?= kTranslate($country['country']); ?></option>
					<? }
				?></select></td></tr>
			<tr><td><?= kTranslate("Codice Fiscale"); ?></td><td><input type="text" name="payment_cf" id="field_cf" value="<?= str_replace('"','&quot;',$fieldValue['payment']['cf']); ?>" class="normal" /></td></tr>
			<tr><td><?= kTranslate("Comunicazioni al venditore"); ?></td><td><textarea name="customer_message" id="field_Message"><?= $_SESSION['orderData']['customer']['message']; ?></textarea></td></tr>
			<tr><td><?= kTranslate("Metodo di pagamento"); ?></td><td><div id="paymentMethods"></div></td></tr>
			</table>
			<br />

			<h2><a href="javascript:shopCart.switchVisibility(document.getElementById('deliveryBox'));"><?= kTranslate("Specify a different shipping address"); ?></a></h2>
			<div class="box" id="deliveryBox">
				<input type="hidden" name="customdelivery" value="no">
				<table>
				<tr><td><?= kTranslate("Full name"); ?> *</td><td><input type="text" name="delivery_name" id="field_name" mandatory="true" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['name']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("E-mail"); ?> *</td><td><input type="text" name="delivery_email" id="field_email" mandatory="true" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['email']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("Phone number"); ?></td><td><input type="text" name="delivery_phone" id="field_Phone" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['phone']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("Address"); ?> *</td><td><input type="text" name="delivery_address" id="field_Address" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['address']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("City"); ?> *</td><td><input type="text" name="delivery_city" id="field_City" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['city']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("State"); ?> *</td><td><input type="text" name="delivery_state" id="field_State" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['state']); ?>" class="normal" />
						<?= kTranslate("Zip code"); ?> * <input type="text" name="delivery_zipcode" id="field_ZipCode" value="<?= str_replace('"','&quot;',$fieldValue['delivery']['zipcode']); ?>" class="normal" style="width:80px;" /></td></tr>
				<tr><td><?= kTranslate("Country"); ?> *</td><td><select name="delivery_country" id="delivery_country" mandatory="true"><option value=""></option><?
					foreach(kGetShopCountries() as $country) { ?>
						<option value="<?= $country['ll']; ?>"<?= $country['ll']==$fieldValue['delivery']['country']?' selected':''; ?>><?= kTranslate($country['country']); ?></option>
						<? }
					?></select></td></tr>
				</table>
				</div>


			<h2><a href="javascript:shopCart.switchVisibility(document.getElementById('paymentBox'));"><?= kTranslate("Request invoice"); ?></a></h2>
			<div class="box" id="paymentBox">
				<input type="hidden" name="invoice" value="no">
				<table>
				<tr><td><?= kTranslate("Business name"); ?> *</td><td><input type="text" name="payment_name" id="field_name" mandatory="true" value="<?= str_replace('"','&quot;',$fieldValue['payment']['name']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("Phone number"); ?></td><td><input type="text" name="payment_phone" id="field_Phone" value="<?= str_replace('"','&quot;',$fieldValue['payment']['phone']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("Address"); ?></td><td><input type="text" name="payment_address" id="field_Address" value="<?= str_replace('"','&quot;',$fieldValue['payment']['address']); ?>" class="normal" /></td></tr>
				<tr><td><?= kTranslate("City"); ?></td><td><input type="text" name="payment_city" id="field_City" value="<?= str_replace('"','&quot;',$fieldValue['payment']['city']); ?>" class="normal" />
						<?= kTranslate("Zip code"); ?> <input type="text" name="payment_zipcode" id="field_ZipCode" value="<?= str_replace('"','&quot;',$fieldValue['payment']['zipcode']); ?>" class="normal" style="width:80px;" /></td></tr>
				<tr><td><?= kTranslate("Country"); ?> *</td><td><select name="payment_country" id="Country" mandatory="true"><option value=""></option><?
					foreach(kGetShopCountries() as $country) { ?>
						<option value="<?= $country['ll']; ?>"<?= $country['ll']==$fieldValue['payment']['country']?' selected':''; ?>><?= kTranslate($country['country']); ?></option>
						<? }
					?></select></td></tr>
				<tr><td><?= kTranslate("VAT (Only for EU members customers)"); ?></td><td><input type="text" name="payment_vat" id="field_vat" value="<?= str_replace('"','&quot;',$fieldValue['payment']['vat']); ?>" class="normal" /></td></tr>
				</table>
				</div>


			<div style="text-align:right;"><small>* <?= kTranslate("Mandatory"); ?></small></div>
		
			<div class="submit"><input type="submit" value="<?= kTranslate('Confirm your order'); ?>" name="confirmOrder"></div>
			</form>
	
		</section>
	</div>
	<? }
?>
	
</section>