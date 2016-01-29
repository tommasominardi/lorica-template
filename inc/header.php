<?php
include(kGetTemplatePath()."config.php");
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
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/fontschemes/<?= $font_scheme; ?>.css">
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/screen.css">
<link rel="stylesheet" media="only screen and (max-width: 480px)" href="<?= kGetTemplateDir(); ?>css/phone.css">
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/colorschemes/<?= $color_scheme; ?>.css">
<?php if(file_exists(kGetTemplatePath().'css/custom.css')) ?><link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/custom.css"><?php } ?>

<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/kalamun.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/lightbuzz.js" charset="UTF-8" defer></script>
<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/main.js" charset="UTF-8" defer></script>
<script type="text/javascript">var TEMPLATEDIR='<?= kGetTemplateDir(); ?>';</script>

<?= kGetExternalStatistics(); ?>
</head>

<body>

<div id="topstripe">
	<div class="row">
		<div class="grid w2 column">
			<a href="<?= kGetBaseDir(); ?>" class="logo"><?php
				if($display_logo == true) { ?><img src="<?= kGetTemplateDir(); ?>img/logo_small.png" alt="<?= kGetSiteName(); ?>"><? }
				else { echo kGetSiteName(); }
			?></a>
		</div>
		<div class="grid w10 column">
			<div class="socials">
				<?php if(!empty($socials['facebook'])) { ?><a href="<?= $socials['facebook']; ?>" target="_blank"></a><?php } ?>
				<?php if(!empty($socials['instagram'])) { ?><a href="<?= $socials['instagram']; ?>" target="_blank"></a><?php } ?>
				<?php if(!empty($socials['pinterest'])) { ?><a href="<?= $socials['pinterest']; ?>" target="_blank"></a><?php } ?>
				<?php if(!empty($socials['twitter'])) { ?><a href="<?= $socials['twitter']; ?>" target="_blank"></a><?php } ?>
				<a href="<?= kGetFeedDir(); ?>"></a>
			</div>
			<div class="languages">
				<? kPrintLanguages(); ?>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
</div>

<div id="header">
	<div class="row">
		<div class="grid w12">
			<div id="logo">
				<h2><a href="<?= kGetBaseDir(); ?>"><?php
				if($display_logo == true) { ?><img src="<?= kGetTemplateDir(); ?>img/logo.png" alt="<?= kGetSiteName(); ?>"><? }
				else { echo kGetSiteName(); }
				?></a></h2>
			</div>
		</div>
	</div>
	<div class="clearBoth"></div>
	<div class="row">
		<div class="grid w12">
			<div class="navBar"><a href="#" class="openMenu"><?= kTranslate('Menu'); ?></a><? kPrintMenu(array('ref'=>0,'recursive'=>true,'img'=>false,'collection'=>'')); ?></div>
		</div>
	<div class="clearBoth"></div>
	</div>
</div>

<div id="contents">