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
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/fontschemes/<?= $font_scheme; ?>.css">
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/screen.css">
<link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/colorschemes/<?= $color_scheme; ?>.css">
<?php if(file_exists(kGetTemplatePath().'css/custom.css')) { ?><link rel="stylesheet" media="screen" href="<?= kGetTemplateDir(); ?>css/custom.css"><?php } ?>

<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/kalamun.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/lightbuzz.js" charset="UTF-8" defer></script>
<script type="text/javascript" src="<?= kGetTemplateDir(); ?>js/main.js" charset="UTF-8" defer></script>
<script type="text/javascript">var TEMPLATEDIR='<?= kGetTemplateDir(); ?>';</script>

<?= kGetExternalStatistics(); ?>
</head>

<body>

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