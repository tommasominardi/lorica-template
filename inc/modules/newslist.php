<div class="newslist">
	<?php

	$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);
	$GLOBALS['loricaOptions'] = intval($GLOBALS['loricaOptions']);
	if(empty($GLOBALS['loricaOptions'])) $GLOBALS['loricaOptions'] = kGetVar('news',1);
	if(empty($GLOBALS['loricaOptions'])) $GLOBALS['loricaOptions'] = 5;

	if(!isset($_GET['p'])) $_GET['p'] = 1;
	
	foreach(kGetNewsList( array("page"=>$_GET['p'], "limit"=>$GLOBALS['loricaOptions']) ) as $i=>$news)
	{
		kSetNewsByDir($news['dir']);

		?>
		<a href="<?= kGetNewsPermalink(); ?>">
			<div class="secondaryNews <?= $i%2==0?'even':'odd' ?>">
				<?php
				if(!empty($news['featuredimage']))
				{
					kSetImage(kGetNewsFeaturedImage());
					?>
					<div class="featuredImage">
						<img src="<?= kGetImageUrl(); ?>">
					</div>
				<?php } ?>

				<div class="grid w1 column dateBox">
					<div class="date"><?= kGetNewsDate("<strong>%d</strong><small>%B</small>"); ?></div>
				</div>
				<div class="grid w<?= $GLOBALS['loricaColumnWide']-1; ?> column previewBox">
					<div class="preview">
						<h2><?= kGetNewsTitle(); ?></h2>
						<? if(kGetNewsSubtitle()!="") { ?><h3><?= kGetNewsSubtitle(); ?></h3><? } ?>
						<?= kGetNewsPreview(); ?>
					</div>
				</div>
			<div class="clearBoth"></div>
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
