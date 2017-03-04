<?php
include(kGetTemplatePath()."config.php");

/* LOGIN */
if(isset($_POST['login_username'])&&isset($_POST['login_password']))
{
	kMemberLogIn($_POST['login_username'],$_POST['login_password']);
	if(isset($_SESSION['orderData'])) unset($_SESSION['orderData']);
} elseif(isset($_GET['logout'])) {
	kMemberLogOut();
}
?>
<!DOCTYPE html>
<html lang="<?= kGetLanguage(); ?>">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= kGetTitle(); ?></title>
<? $metadata=kGetSeoMetadata(); ?>
<meta name="description" content="<?= $metadata['description']; ?>" />
<meta name="keywords" content="<?= $metadata['keywords']; ?>" />
<meta name="revisit-after" content="<?= $metadata['changefreq']; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=.8, user-scalable=yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" href="<?= kGetTemplateDir(); ?>img/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="RSS News" href="<?= kGetBaseDir().strtolower(kGetLanguage()); ?>/feed/" />
<?php
foreach(kGetLanguages() as $t)
{
	if($t['ll']!=kGetLanguage())
	{ ?>
		<link rel="alternate" hreflang="<?= strtolower($t['ll']); ?>" href="<?= $t['url']; ?>" title="This document in <?= $t['lingua']; ?>">
	<? }
} ?>

<script type="text/javascript">
	var TEMPLATEDIR='<?= kGetTemplateDir(); ?>';

	kAddEvent=function(obj,event,func,model)
	{
		if(!model) model=true;
		if(obj.addEventListener) return obj.addEventListener(event,func,model);
		if(obj.attachEvent) return obj.attachEvent('on'+event,func);
		return false;
	}
	
	function embedJSonDomReady() {
		var elm = document.createElement("script");
		elm.src = TEMPLATEDIR+"js/main.min.js";
		elm.setAttribute("charset","UTF-8");
		document.body.appendChild(elm);
	}
	
	function removePreloader()
	{
		var preloader = document.getElementById('preloader');
		preloader.style.opacity = 0;
		setTimeout(function () {
			preloader.parentNode.removeChild(preloader,true);
		},
		1000);
	}
	
	kAddEvent(document,'DOMContentLoaded',embedJSonDomReady);
	kAddEvent(window,'load',removePreloader);
	
	var loadDeferredStyles = function() {
		var addStylesNode = document.getElementById("deferred-styles");
		var replacement = document.createElement("div");
		replacement.innerHTML = addStylesNode.textContent;
		document.body.appendChild(replacement)
		addStylesNode.parentElement.removeChild(addStylesNode);
	};
	
	var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
	
	if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
	else window.addEventListener('load', loadDeferredStyles);

</script>

<noscript id="deferred-styles">
	<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/fontschemes/<?= $font_scheme; ?>.css">
	<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/screen.css">
	<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/colorschemes/<?= $color_scheme; ?>.css">
	<?php if(file_exists(kGetTemplatePath().'css/custom.css')) { ?><link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/custom.css"><?php } ?>
</noscript>

<style>#preloader{position:fixed;top:0;left:0;width:100%;height:100%;z-index:10000;opacity:1;background:#fff;transition:opacity .3s ease-out;}</style>

<?= kGetExternalStatistics(); ?>
</head>

<body>
<div id="preloader"></div>

<section id="topstripe">
	<?php loricaIncludeModules($topbar_row, 'topbar'); ?>
</section>

<section id="header">
	<?php
	foreach($GLOBALS['header_rows'] as $row)
	{
		loricaIncludeModules($row, 'header');
	}
	?>
</section>

<section id="contents">