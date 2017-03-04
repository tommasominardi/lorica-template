<?php
$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);


if(kIsNews())
{
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
	
		<div class="titleBox">
			<h1><?= kGetNewsTitle(); ?></h1>
			<?php if(trim(kGetNewsSubtitle()) != "") { ?><h2><?= kGetNewsSubtitle(); ?></h2><? } ?>
		</div>

		<div class="contentsBox">
			<?= kGetNewsText(); ?>
		</div>

	</div>
	<?php

	
/************
* SHOP ITEM
************/
} elseif(kIsShop()) {
	kSetShopItemByDir();
	?>
	<input type="hidden" id="idsitem" value="<?= kGetShopItemId(); ?>">
	<div class="grid w12">
	
		<div class="titleBox">
			<h1><?= kGetShopItemTitle(); ?></h1>
			<?php if(trim(kGetShopItemSubtitle()) != "") { ?><h2><?= kGetShopItemSubtitle(); ?></h2><? } ?>
		</div>

		<div class="contentsBox">
			<?= kGetShopItemText(); ?>

			<?php
			$customfields = (kGetShopItemCustomFields());
			
			if(!empty($customfields))
			{
				foreach($customfields as $customfield)
				{
					echo '<div class="customfield"><span class="customfield name">'. $customfield['name'] .'</span>: <span class="customfield value">'.$customfield['value'].'</span></div>';
				}
			}
			?>
			
			<div class="variationsBox"><?
			/* VARIATIONS */
			/* the onchange event is activated and managed by kShopItem javascript class */
			$variationslist = kGetShopItemVariations();
			
			if(!empty($variationslist))
			{
				$i=0;
				foreach($variationslist as $collection=>$variations)
				{
					?>
					<label for="variation<?= $i; ?>"><?= $collection; ?></label>
					<select id="variation<?= $i; ?>" name="variation[<?= $i; ?>]" class="variation">
						<?
						foreach($variations as $option) { ?>
							<option value="<?= $option['idsvar']; ?>"><?= $option['name']; ?> <?= $option['price']!=""?'('.$option['price'].')':''; ?></option>
							<? }
						?>
						</select>
					<br />
					<?
					$i++;
				}
			}
			?>
			</div>
		</div>
		
		<div class="clearBoth"></div>
	</div>
	<?php
	
} else {
	?>
	<div class="grid w<?= $GLOBALS['loricaColumnWide']; ?>">
		<div class="titleBox">
			<h1><?= kGetPageTitle(); ?></h1>
			<?php if(trim(kGetPageSubtitle()) != "") { ?><h2><?= kGetPageSubtitle(); ?></h2><? } ?>
		</div>
		
		<div class="contentsBox">
			<?= kGetPageText(); ?>
		</div>

		<div class="clearBoth"></div>
	</div>
	<?php
	
}

?>&nbsp;