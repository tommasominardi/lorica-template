<?php
$cart=kGetShopCart();
if(!isset($GLOBALS['loricaContext'])) $GLOBALS['loricaContext']="";
?>
<section class="cart cartWidget">
<?php
if($cart['itemsnumber']>0)
{
	?>
		<h2><?= kTranslate('Il tuo carrello'); ?></h2>
		<div class="cartSummary">
		<table class="cartList">
		<?
		$i=0;
		foreach($cart['items'] as $item)
		{
			// print table header
			if($i==0)
			{
				?>
				<tr>
				<?php if($GLOBALS['loricaContext']!="topbar") { ?><th class="qty"><?= kTranslate('qta'); ?></th><?php } ?>
				<th class="title"><?= kTranslate('articolo'); ?></th>
				<th class="price"><?= kTranslate('prezzo'); ?></th>
				</tr>
				<?php
			}
			
			// print item
			/* [id] is the id of the item into the cart, within variations */
			?>
			<tr id="item<?= $item['uid']; ?>">
				<?php if($GLOBALS['loricaContext']!="topbar") { ?>
				<td class="qty">
					<a href="javascript:shopCart.removeFromCart('<?= $item['uid']; ?>');" class="changeQtyBtn">-</a>
					<span class="qtynum"><?= $item['qty']; ?></span>
					<a href="javascript:shopCart.addToCart('<?= $item['uid']; ?>');" class="changeQtyBtn">+</a>
				</td>
				<?php } ?>
				<td class="title">
					<a href="<?= $item['permalink']; ?>">
						<strong><?= $item['titolo']; ?></strong>
						<?php if($item['productcode']!="") echo ' ('.$item['productcode'].')'; ?>
						</a><br>
						<?php
						if($item['sottotitolo']!="") echo $item['sottotitolo']."<br>";
						$variations="";
						foreach($item['variations'] as $v)
						{
							$variations.=' '.$v['collection'].': '.$v['name'].',';
						}
						$variations=rtrim($variations,",-");
						if($variations!="") { ?><span class="variations"><em><?= $variations; ?></em></span><br><? }
						
						$customvariations="";
						foreach($item['customvariations'] as $k=>$v) {
							$customvariations.=' '.$k.': '.$v.',';
							}
						$customvariations=rtrim($customvariations,",");
						if($customvariations!="") { ?><span class="variations custom"><?= $customvariations; ?></span><br><? }
						?>
				</td>
				<td class="price"><span class="pricenum"><?= number_format($item['realprice']*$item['qty'],2); ?></span> <?= kGetShopCurrency("symbol"); ?></td>
			</tr>
			<?
			$i++;
		}

		if($i==0) echo '<tr><td>'.kTranslate('Your cart is empty').'</td></tr>';
		?>
		</table>
		
		<div class="totalamount">
			<p class="alignright">
				<?= kTranslate('totale').' <span class="totalnum">'.number_format(kGetShopCartItemsAmount(),2); ?></span> <?= kGetShopCurrency("symbol"); ?><br>
				<?php
				if(!kIsShopCart()) { ?>
					<a href="<?= kGetCurrentLanguageDir().kGetShopDir().'/'.kGetShopCartDir(); ?>" class="button"><?= kTranslate('Vai alla cassa'); ?></a>
				<?php } ?>
			</p>
		</div>
		</div>
	
	<?php
}
?>
</section>
