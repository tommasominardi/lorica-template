<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kIsShop()) {
	kSetShopItemByDir();
	?>
	<input type="hidden" id="idsitem" value="<?= kGetShopItemId(); ?>">
	<div class="grid w12">
		<div class="row">
			<div class="grid w4 column">
				<div class="priceBox">
					<?php
					if(kGetShopItemPrice()>0 && kGetShopItemQuantity()>0)
					{
						echo '<span id="price">'.number_format(kGetShopItemPrice(),2).'</span> '.kGetShopCurrency("symbol");
					} else {
						echo kTranslate('OUT OF STOCK');
					}
					?>
				</div>
			</div>
				
			<div class="grid w8 column">
				<?php if(kGetShopItemPrice()>0 && (kGetShopItemQuantity()>0)) {
					?>
					<div class="addToCartBox">
						<div id="addToCart"><?= kTranslate('Add to cart'); ?></div>
						<div id="addToCartAdded"><?= kTranslate('Successfully added!'); ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	
}

?>&nbsp;