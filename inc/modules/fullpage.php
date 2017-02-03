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

		<?php
		if(kGetNewsFeaturedImage() != false)
		{ ?>
			<div class="featuredImage">
				<?php
				kSetImage( kGetNewsFeaturedImage() );
				?>
				<img src="<?= kGetImageUrl(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
			</div>
		<?php } ?>
		
		<?php
		if(trim(strip_tags(kGetNewsPreview(), "<img>")) != "") { ?>
			<div class="excerptBox">
				<?= kGetNewsPreview(); ?>
			</div>
		<?php } ?>
		
		<div class="contentsBox">
			<?= kGetNewsText(); ?>
		</div>

		<?php
		if(count(kGetNewsPhotogallery())>0) { ?>
			<div id="pageGallery">
			<?php

			$i=0;
			$countVerticalImages=0;
			$phg=kGetNewsPhotogallery();
			foreach($phg as $i=>$img) {
				
				/* try to arrange couples of vertical images */

				/* first of all find the orientation of the previous, current and next image */
				if(!isset($previousIsVertical)) $previousIsVertical=false;
				$currentIsVertical = false;
				$nextIsVertical = false;
				if(isset($phg[$i+1]))
				{
					kSetImage($phg[$i+1]);
					if(kGetImageWidth()<kGetImageHeight()) {
						$nextIsVertical = true;
					}
				}

				kSetImage($img);
				if(kGetImageWidth()<kGetImageHeight()) {
					$currentIsVertical = true;
				}

				// then generate the class based on combinations
				$class = "";
				if($currentIsVertical && $previousIsVertical && $countVerticalImages%2!=0) $class="vertical right";
				elseif($currentIsVertical && $nextIsVertical) $class="vertical left";
				elseif($currentIsVertical) $class="vertical center";

				?>
				<div class="phgthumb <?= $class; ?>" id="photoThumb<?= $i; ?>">
					<a href="<?= kGetImageURL(); ?>" rel="lightbuzz">
						<img src="<?= kGetImageURL(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
					</a>
				</div>
				<?
				$i++;
				$previousIsVertical = $currentIsVertical;
				if($currentIsVertical) $countVerticalImages++;
				} ?>
				<div class="clearBoth"></div>
			</div>
		<?php } ?>

		<?php
		if(count(kGetNewsDocuments())>0) { ?>
			<div id="pageDocuments"><ul>
			<? $i=0;
			foreach(kGetNewsDocuments() as $doc) {
				kSetDocument($doc);
				?>
				<li><a href="<?= kGetDocumentURL(); ?>" title="<?= kGetDocumentAlt(); ?>"><?= trim(kGetDocumentCaption())!=""?kGetDocumentCaption():kGetDocumentFilename(); ?></a></li>
				<?
				$i++;
				} ?></ul>
			</div>
		<?php } ?>
Ì
		<script>var shop = null;</script>
	</div>
	<?php
	
} elseif(kIsShop()) {
	kSetShopItemByDir();
	?>
	<input type="hidden" id="idsitem" value="<?= kGetShopItemId(); ?>">
	<div class="grid w12">
	
		<div class="titleBox">
			<h1><?= kGetShopItemTitle(); ?></h1>
			<?php if(trim(kGetShopItemSubtitle()) != "") { ?><h2><?= kGetShopItemSubtitle(); ?></h2><? } ?>
		</div>

		<?php
		if(kGetShopItemFeaturedImage() != false)
		{ ?>
			<div class="featuredImage">
				<?php
				kSetImage( kGetShopItemFeaturedImage() );
				?>
				<img src="<?= kGetImageUrl(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
			</div>
		<?php } ?>
		
		<?php
		if(trim(strip_tags(kGetShopItemPreview(), "<img>")) != "") { ?>
			<div class="excerptBox">
				<?= kGetShopItemPreview(); ?>
			</div>
		<?php } ?>
		
		<div class="contentsBox">
			<?= kGetShopItemText(); ?>
			
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

		<?php
		if(count(kGetShopItemPhotogallery())>0) { ?>
			<div id="pageGallery">
			<?php

			$i=0;
			$countVerticalImages=0;
			$phg=kGetShopItemPhotogallery();
			foreach($phg as $i=>$img) {
				
				/* try to arrange couples of vertical images */

				/* first of all find the orientation of the previous, current and next image */
				if(!isset($previousIsVertical)) $previousIsVertical=false;
				$currentIsVertical = false;
				$nextIsVertical = false;
				if(isset($phg[$i+1]))
				{
					kSetImage($phg[$i+1]);
					if(kGetImageWidth()<kGetImageHeight()) {
						$nextIsVertical = true;
					}
				}

				kSetImage($img);
				if(kGetImageWidth()<kGetImageHeight()) {
					$currentIsVertical = true;
				}

				// then generate the class based on combinations
				$class = "";
				if($currentIsVertical && $previousIsVertical && $countVerticalImages%2!=0) $class="vertical right";
				elseif($currentIsVertical && $nextIsVertical) $class="vertical left";
				elseif($currentIsVertical) $class="vertical center";

				?>
				<div class="phgthumb <?= $class; ?>" id="photoThumb<?= $i; ?>">
					<a href="<?= kGetImageURL(); ?>" rel="lightbuzz">
						<img src="<?= kGetImageURL(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
					</a>
				</div>
				<?
				$i++;
				$previousIsVertical = $currentIsVertical;
				if($currentIsVertical) $countVerticalImages++;
				} ?>
				<div class="clearBoth"></div>
			</div>
		<?php } ?>

		<?php
		if(count(kGetShopItemDocuments())>0) { ?>
			<div id="pageDocuments"><ul>
			<? $i=0;
			foreach(kGetShopItemDocuments() as $doc) {
				kSetDocument($doc);
				?>
				<li><a href="<?= kGetDocumentURL(); ?>" title="<?= kGetDocumentAlt(); ?>"><?= trim(kGetDocumentCaption())!=""?kGetDocumentCaption():kGetDocumentFilename(); ?></a></li>
				<?
				$i++;
				} ?></ul>
			</div>
		<?php } ?>

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
		
		<?php
		if(kGetPageFeaturedImage() != false)
		{ ?>
			<div class="featuredImage">
				<?php
				kSetImage( kGetPageFeaturedImage() );
				?>
				<img src="<?= kGetImageUrl(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
			</div>
		<?php } ?>

		<?php
		if(trim(strip_tags(kGetPagePreview(), "<img>")) != "") { ?>
			<div class="excerptBox">
				<?= kGetPagePreview(); ?>
			</div>
		<?php } ?>
		
		<div class="contentsBox">
			<?= kGetPageText(); ?>
		</div>

		<?
		if(count(kGetPagePhotogallery())>0)
		{ ?>
			<div id="pageGallery">
			<? $i=0;
			foreach(kGetPagePhotogallery() as $img) {
				kSetImage($img);
				?>
				<div class="phgthumb" id="photoThumb<?= $i; ?>">
					<a href="<?= kGetImageURL(); ?>" rel="lightbuzz">
						<img src="<?= kGetImageURL(); ?>" width="<?= kGetImageWidth(); ?>" height="<?= kGetImageHeight(); ?>" alt="<?= kGetImageAlt(); ?>">
					</a>
				</div>
				<?
				$i++;
				} ?>
				<div class="clearBoth"></div>
			</div>
			<?
		} ?>

		<?
		if(count(kGetPageDocuments())>0)
		{ ?>
			<div id="pageDocuments"><ul>
			<? $i=0;
			foreach(kGetPageDocuments() as $doc) {
				kSetDocument($doc);
				?>
				<li><a href="<?= kGetDocumentURL(); ?>" title="<?= kGetDocumentAlt(); ?>"><?= trim(kGetDocumentCaption())!=""?kGetDocumentCaption():kGetDocumentFilename(); ?></a></li>
				<?
				$i++;
				} ?></ul>
			</div>
			<?
		}
		?>

		<div class="clearBoth"></div>
	</div>
	<?php
	
}

?>&nbsp;