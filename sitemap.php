<?
/****************************/
/*         SITEMAP          */
/****************************/
header('Content-type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';

/* INDEX */
if(!isset($_GET['type']))
{ ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<sitemap>
<loc><?= kGetSiteURL().kGetBaseDir(); ?>sitemap.xml?type=pages</loc>
<lastmod><?= date("c"); ?></lastmod>
</sitemap>
<sitemap>
<loc><?= kGetSiteURL().kGetBaseDir(); ?>sitemap.xml?type=news</loc>
<lastmod><?= date("c"); ?></lastmod>
</sitemap>
<?

foreach(array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","other") as $letter)
{ ?>
<sitemap>
<loc><?= kGetSiteURL().kGetBaseDir(); ?>sitemap.xml?type=shop&amp;letter=<?= $letter; ?></loc>
<lastmod><?= date("c"); ?></lastmod>
</sitemap>
<?php
}

?>
</sitemapindex>
<?php

/* PAGES */
} elseif($_GET['type']=="pages") { ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
<?
foreach(kGetLanguages() as $l)
{
	foreach(kGetPageList($l['ll']) as $p)
	{
		kSetPageByDir($p['dir']);
		$md=kGetSeoMetadata($p['dir']);
		if(strpos($md['robots'],"noindex")===false)
		{
			?>
			<url>
			<loc><?= b3_unhtmlize(kGetSiteURL().kGetPagePermalink()); ?></loc>
			<lastmod><?= kGetPageDateModified()!=""?date("c",mktime(substr(kGetPageDateModified(),11,2),substr(kGetPageDateModified(),14,2),substr(kGetPageDateModified(),17,2),substr(kGetPageDateModified(),5,2),substr(kGetPageDateModified(),8,2),substr(kGetPageDateModified(),0,4))):date("c"); ?></lastmod>
			<changefreq><?= $md['changefreq']; ?></changefreq>
			<priority><?= $md['priority']; ?></priority>
			</url>
			<?
		}
	}
}
?></urlset><?


/* NEWS */
} elseif($_GET['type']=="news") { ?>
<urlset xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"> 
<?
foreach(kGetLanguages() as $l)
{
	foreach(kGetNewsList("*",false,9999,0,"","","",$l['ll']) as $p)
	{
		kSetNewsByDir($p['dir']);
		$md=kGetSeoMetadata(kGetNewsDir($l['ll']).'/'.$p['categorie'][0]['dir'].'/'.$p['dir']);
		if(strpos($md['robots'],"noindex")===false)
		{
			?>
			<url>
			<loc><?= b3_unhtmlize(kGetSiteURL().kGetNewsPermalink()); ?></loc>
			<lastmod><?= kGetNewsDateModified()!=""?date("c",mktime(substr(kGetNewsDateModified(),11,2),substr(kGetNewsDateModified(),14,2),substr(kGetNewsDateModified(),17,2),substr(kGetNewsDateModified(),5,2),substr(kGetNewsDateModified(),8,2),substr(kGetNewsDateModified(),0,4))):date("c"); ?></lastmod>
			<changefreq><?= $md['changefreq']; ?></changefreq>
			<priority><?= $md['priority']; ?></priority>
			</url>
			<?
		}
	}
}
?></urlset><?


/* SHOP */
} elseif($_GET['type']=="shop") { ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"> 
<?
foreach(kGetLanguages() as $l)
{
	$vars=array( "category"=>"*", "limit"=>9999, "ll"=>$l['ll'] );
	if(isset($_GET['letter']))
	{
		if($_GET['letter']!="other") $vars['conditions']="`titolo` LIKE '".mysql_real_escape_string($_GET['letter'])."%' ";
		else $vars['conditions']="`titolo` RLIKE '^[^[A-Za-z].*'";
	}
	
	foreach(kGetShopItemQuickList($vars) as $p)
	{
		$md=kGetSeoMetadata(substr($p['permalink'],strlen(kGetSiteURL().kGetBaseDir())));
		if(strpos($md['robots'],"noindex")===false)
		{
			?>
			<url>
			<loc><?= b3_unhtmlize(kGetSiteURL().$p['permalink']); ?></loc>
			<lastmod><?= date("c",mktime(substr($p['modified'],11,2),substr($p['modified'],14,2),substr($p['modified'],17,2),substr($p['modified'],5,2),substr($p['modified'],8,2),substr($p['modified'],0,4))); ?></lastmod>
			<changefreq><?= $md['changefreq']; ?></changefreq>
			<priority><?= $md['priority']; ?></priority>
			</url>
			<?
		}
	}
}
?></urlset><?

}?>