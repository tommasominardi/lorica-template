<div id="sidebar">

	<div class="fields">
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<fb:like-box href="https://www.facebook.com/pages/Anastagi-Bed-and-Breakfast-Ravenna/184767844881684" width="345px" show_faces="true" stream="false" header="true" height="370"></fb:like-box>
	</div>
	
	<div class="fields">
		<!-- Start of Instagram -->
		<div id="instagram_badge">
		<h4><img src="<?= kGetTemplateDir(); ?>img/instagram.png" width="96" height="28" alt="instagram"></h4>
		<?
		foreach($GLOBALS['instagram']->getPosts() as $photo)
		{
			?><a href="<?= $photo['link']; ?>" target="_blank">
				<img src="<?= $photo['filename']; ?>" alt="" /><br>
				<div class="text"><?= $photo['text']; ?></div>
			</a><?
		}
		?></div>
		<script type="text/javascript">
			var ig=new kFadeRoller();
			ig.init();
		</script>
		<!-- End of Instagram -->
	</div>

	<div class="clearBoth"></div>
</div>