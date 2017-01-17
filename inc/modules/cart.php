<?php
$cart=kGetShopCart();

if($cart['itemsnumber']>0)
{
	?>
	<section class="cart cartWidget">
		<h2><?= kTranslate('Il tuo carrello'); ?></h2>
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
				<th class="qty"><?= kTranslate('qta'); ?></th>
				<th class="title"><?= kTranslate('articolo'); ?></th>
				<th class="price"><?= kTranslate('prezzo'); ?></th>
				</tr>
				<?php
			}
			
			// print item
			/* [id] is the id of the item into the cart, within variations */
			?>
			<tr id="item<?= $item['uid']; ?>">
				<td class="qty">
					<a href="javascript:shopCart.removeFromCart('<?= $item['uid']; ?>');" class="changeQtyBtn">-</a>
					<span class="qtynum"><?= $item['qty']; ?></span>
					<a href="javascript:shopCart.addToCart('<?= $item['uid']; ?>');" class="changeQtyBtn">+</a>
				</td>
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
			</p>
		</div>
	
	</section>
	<?php
}
