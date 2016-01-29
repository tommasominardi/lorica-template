<div class="latestnews compact">
	<?php

	$GLOBALS['loricaColumnWide'] = intval($GLOBALS['loricaColumnWide']);
	$GLOBALS['loricaOptions'] = intval($GLOBALS['loricaOptions']);
	if(empty($GLOBALS['loricaOptions'])) $GLOBALS['loricaOptions'] = kGetVar('news',1);
	if(empty($GLOBALS['loricaOptions'])) $GLOBALS['loricaOptions'] = 5;

	foreach(kGetNewsList( array("limit"=>$GLOBALS['loricaOptions']) ) as $i=>$news)
	{
		kSetNewsByDir($news['dir']);

		?>
		<a href="<?= kGetNewsPermalink(); ?>">
			<div class="secondaryNews <?= $i%2==0?'even':'odd' ?>">
				<div class="grid w1 column">
					<div class="date"><?= kGetNewsDate("<strong>%d</strong><small>%B</small>"); ?></div>
				</div>
				<div class="grid w<?= $GLOBALS['loricaColumnWide']-1; ?> column">
					<div class="preview">
						<h2><?= kGetNewsTitle(); ?></h2>
						<? if(kGetNewsSubtitle()!="") { ?><h3><?= kGetNewsSubtitle(); ?></h3><? } ?>
						<div class="excerpt"><?= kGetNewsPreview(); ?></div>
					</div>
				</div>
			<div class="clearBoth"></div>
			</div>
		</a>
		<?php
	}
	?>

	<div class="aligncenter">
		<div class="button"><a href="<?= kGetNewsDir(); ?>"><?= kTranslate('Tutti i post'); ?></a></div>
	</div>
</div>