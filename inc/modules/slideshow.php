<div id="kSlideShow">
<?php
foreach(kGetPagePhotogallery() as $p)
{
	?><a href="<?= $p['url']; ?>"><?= $p['alt']; ?></a><br><?php
}
?>
</div>