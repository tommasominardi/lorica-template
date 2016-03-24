<?
/********************************************
CONFIGURAZIONE DEL TEMA
********************************************/
global $color_scheme, $font_scheme, $display_logo, $socials, $home_rows, $page_rows, $newsarchive_rows, $news_rows, $footer_rows;


/*
schema colore: uno tra quelli presenti nella directory "css/colorschemes"
*/

$color_scheme = "grey";

/*
schema font: uno tra quelli presenti nella directory "css/fontschemes"
*/

$font_scheme = "varela";


/*
mostra il logo o mostra una scritta
(il logo si trova dentro img/ ed è in due dimensioni diverse: logo.png e logo_small.png
*/

$display_logo = false;


/*
social networks: gli indirizzi dei vari social
*/
$socials = array();
$socials['facebook'] = "http://www.facebook.com";
$socials['twitter'] = "http://www.twitter.com";
$socials['instagram'] = "http://www.instagram.com";
$socials['pinterest'] = "http://www.pinterest.com";
$socials['plus'] = "http://plus.google.com";
$socials['medium'] = "http://www.medium.com";



/********************************************
HOME PAGE
********************************************/

/*
cosa mostrare in home page?

Le opzioni sono:
 "slideshow" -> slideshow della galleria di foto della pagina home
 "newsgallery" -> galleria di foto delle ultime news linkate
 "photogallery" -> galleria di foto della pagina home
 "documentgallery" -> galleria di foto della pagina home
 "page" -> titolo, sottotitolo e testo della pagina home
 "fullpage" -> tutta la pagina: titolo, sottotitolo, excerpt, testo, photogallery, document gallery...
 "featuredimage" -> l'immagine di presentazione della pagina home
 "pagetitle" -> il titolo della pagina home
 "pagesubtitle" -> il sottotitolo della pagina home
 "pageexcerpt" -> l'anteprima della pagina home
 "pagecontent" -> il contenuto della pagina home
 "newslist" -> elenco di news con paginazione
 "latestnews[(int)]" -> le ultime notizie, tra parentesi quadra indicare quante (default = 5)
 "latestnews_compact[(int)]" -> le ultime notizie in versione compatta
 "banner[(string)]" -> i banner nella categoria indicata tra parentesi quadra
 "socialshare" -> condivisione sui social
 "comments" -> commenti alla pagina
 "newsletter[(int)]" -> modulo di iscrizione alla newsletter (id della lista, default = 1)
 "footer" -> il testo del footer impostato nel pannello di controllo
 
Prima di ogni opzione può essere scritto un numero da 1 a 12, che indica la larghezza della colonna
*/

$home_rows = array();
$home_rows[] = "slideshow"; // prima riga
$home_rows[] = "2 pageexcerpt, 6 pagecontent, 4 latestnews[3]"; // seconda riga
$home_rows[] = "newsletter[1], banner[home]"; // terza riga



/********************************************
PAGINE INTERNE
********************************************/

/*
cosa mostrare in ogni colonna?
*/

$page_rows = array();
$page_rows[] = "8 fullpage, 4 socialshare banner[sidebar]";



/********************************************
PAGINE DELLE NEWS
********************************************/

/*
cosa mostrare in ogni colonna della pagina dell'archivio delle news?
*/

$newsarchive_rows = array();
$newsarchive_rows[] = "12 newslist";


/*
cosa mostrare in ogni colonna della pagina della singola news?
*/

$news_rows = array();
$news_rows[] = "8 fullpage, 4 socialshare banner[sidebar] latestnews_compact[3]";



/********************************************
FOOTER
********************************************/

/*
cosa mostrare nel footer?
*/

$footer_rows = array();
$footer_rows[] = "footer";




/********************************************
FUNZIONI PER IL TEMPLATE... NON TOCCARE QUI SOTTO!
********************************************/

function loricaIncludeModules($mods)
{
	global $loricaOptions, $loricaColumnWide;
	
	$mods = explode(",", $mods);
	if(empty($mods)) return false;
	
	?><div class="row"><?php

	$columns = 12;

	foreach($mods as $i=>$mod)
	{
		$mod = trim($mod);
		if(empty($mod)) continue;
		
		// extract the wide of column, or detect it
		if(intval(substr($mod,0,1)) > 0)
		{
			preg_match("/(\d+)(.*)/", $mod, $match);
			$mod = trim($match[2]);
			$loricaColumnWide = intval($match[1]);
			
		} else {
			$loricaColumnWide = floor($columns / (count($mods) - $i)) ;
			
		}
		
		// slipt the modules in each column
		$modules = explode(" ", $mod);
		
		?><div class="grid w<?= $loricaColumnWide; ?> nomargin column"><?php

			foreach($modules as $m)
			{
				$loricaOptions = "";
				$m = trim($m);

				if(strpos($m, "[") !== false)
				{
					preg_match("/(.*?)\[(.*?)\]/", $m, $match);
					$m = $match[1];
					$loricaOptions = $match[2];
				}
				
				include(kGetTemplatePath()."inc/modules/".$m.".php");
			}

		?></div><?php
	}
	
	?><div class="clearBoth"></div>
	</div><?php
}

