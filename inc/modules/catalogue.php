<div class="row">
	<div class="grid w<?= $GLOBALS['loricaColumnWide']-1; ?> nomargin column shoplist">
		<?php

		$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);
		$GLOBALS['loricaOptions'] = intval($GLOBALS['loricaOptions']);
		if(empty($GLOBALS['loricaOptions'])) $GLOBALS['loricaOptions'] = 3;
		$column_width = $GLOBALS['loricaOptions'];

		if(!isset($_GET['p'])) $_GET['p'] = 1;
		
		foreach(kGetShopItemList( array("page"=>$_GET['p']) ) as $i=>$article)
		{
			kSetShopItemByDir($article['dir']);

			?>
			<a href="<?= kGetShopItemPermalink(); ?>">
				<div class="grid w<?= $column_width; ?> column">
					<?php
					if(!empty($article['featuredimage']))
					{
						kSetImage(kGetShopItemFeaturedImage());
						?>
						<div class="featuredImage">
							<img src="<?= kGetThumbUrl(); ?>" alt="">
						</div>
					<?php } ?>

					<div class="preview">
						<h2 class="aligncenter"><?= kGetShopItemTitle(); ?></h2>
						<? if(kGetShopItemSubtitle()!="") { ?><h3 class="aligncenter"><?= kGetShopItemSubtitle(); ?></h3><? } ?>
						<div class="price"><ins><?= number_format(kGetShopItemPrice(),2,",",".").' '.kGetShopCurrency("symbol"); ?></ins></div>
						<?= kGetShopItemPreview(); ?>
					</div>
				</div>
			</a>
			<?php
		}
		?>

		<div class="clearBoth"></div>
		<div class="aligncenter">
			<?php if($_GET['p'] > 1) { ?>
				<div class="button"><a href="?p=<?= $_GET['p']-1; ?>"><?= kTranslate('Pagina precedente'); ?></a></div>
			<?php } ?>
			
			<div class="button"><a href="?p=<?= $_GET['p']+1; ?>"><?= kTranslate('Pagina successiva'); ?></a></div>
			
		</div>
	</div>
</div>

<style>
.shoplist>a:nth-child(<?= ceil(12/$column_width); ?>n+1) {
	clear:both;
}
</style>
