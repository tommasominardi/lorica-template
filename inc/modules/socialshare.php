<?
$currentUrl=kGetSiteUrl().$_SERVER['REQUEST_URI'];
if(strpos($currentUrl,"?")!==false) $currentUrl=substr($currentUrl,0,strpos($currentUrl,"?"));
?>

<div class="pageSocials">
	<a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl); ?>" class="popup">
		<span class="icon"></span> Mi piace
	</a>
	<a href="https://twitter.com/share" class="popup">
		<span class="icon"></span> Twitta
	</a>
</div>

<div class="clearBoth"></div>