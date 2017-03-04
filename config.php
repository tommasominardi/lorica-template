<?
/********************************************
CONFIGURAZIONE DEL TEMA
********************************************/
global $color_scheme, $font_scheme, $display_logo, $socials, $home_rows, $page_rows, $newsarchive_rows, $news_rows, $shoparchive_rows, $shop_rows, $cart_rows, $topbar_row, $header_rows, $footer_rows;


/*
schema colore: uno tra quelli presenti nella directory "css/colorschemes"
*/

$color_scheme = "grey";

/*
schema font: uno tra quelli presenti nella directory "css/fontschemes"
*/

$font_scheme = "varela";


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
$socials['rss'] = "true"; // "true" per attivare il tasto dei feed rss, "false" per disattivarlo

/*
mailchimp
*/
$mailchimp_api_key = ''; // se usi mailchimp, qui devi mettere l'api key. La crei su Account > Extras > API keys > Create a key


/********************************************
ISTRUZIONI GENERALI
********************************************/
/*

Moduli disponibili:

 "slideshow" -> slideshow della galleria di foto
 "fullpage" -> tutta la pagina: titolo, sottotitolo, excerpt, testo, photogallery, document gallery...
 "page" -> titolo, sottotitolo e testo
 "featuredimage" -> l'immagine di presentazione della pagina home
 "pagetitle" -> il titolo della pagina home
 "pagesubtitle" -> il sottotitolo della pagina home
 "pageexcerpt" -> l'anteprima della pagina home
 "pagecontent" -> il contenuto della pagina home
 "photogallery" -> galleria di foto della pagina
 "documentgallery" -> galleria di documenti della pagina
 "comments" -> commenti alla pagina
 
 "newsgallery" -> galleria di foto delle ultime news, con rispettivi link
 "newslist" -> elenco di news con paginazione
 "latestnews[(int)]" -> le ultime notizie, tra parentesi quadra indicare quante (default = 5)
 "latestnews_compact[(int)]" -> le ultime notizie in versione compatta
 
 "catalogue[2]" -> catalogo degli articoli in vendita, tra parentesi quadre la larghezza del singolo articolo (default = 3)
 "minicart" -> il carrello in forma compatta, da usare dentro alle pagine
 "cart" -> il carrello in forma completa
 "cartform" -> la pagina del carrello, incluso il form di acquisto
 "itemprice" -> shop: il prezzo del singolo articolo
 "addtocart" -> shop: il tasto di aggiunta al carrello
 "customfield[nome del campo]" -> shop: campo personalizzato. Tra parentesi quadre il nome del campo da mettere
 
 "banner[(string)]" -> i banner nella categoria indicata tra parentesi quadra
 
 "logo" -> mostra il logo, linkato all'home page
 "empty" -> vuoto :-)
 "string[(string)]" -> una breve linea di testo, che verrà processata dal dizionario
 "menu[(string)]" -> menù: se specificato il nome, mostra quel menù, altrimenti il principale
 "languages" -> link alle lingue, se più di una
 "sociallinks" -> collegamenti ai social abilitati
 "socialshare" -> condivisione sui social
 "newsletter[(int)]" -> modulo di iscrizione alla newsletter (id della lista, default = 1)
 "mailchimp[list id]" -> modulo di iscrizione a mailchimp (l'id della lista a cui iscrivere, si trova su Settings > List name and defaults)
 "footer" -> il testo del footer impostato nel pannello di controllo
 
Prima di ogni opzione può essere scritto un numero da 1 a 12, che indica la larghezza della colonna

*/


/********************************************
HEADER - SI VEDE IN TUTTE LE PAGINE
********************************************/

/*
cosa mostrare nella fascia superiore?
*/
$topbar_row = "3 logo minicart";

/*
cosa mostrare nell'header?
*/
$header_rows = array();
$header_rows[] = "3 empty, 6 logo";
$header_rows[] = "12 menu[]";

/*
mostra il logo (se true) o mostra una scritta (se false)
(il logo si trova dentro img/ ed è in due dimensioni diverse: logo.png e logo_small.png
*/
$display_logo = false;



/********************************************
HOME PAGE
********************************************/

/*
cosa mostrare in home page?
*/

$home_rows = array();
$home_rows[] = "slideshow"; // prima riga
$home_rows[] = "2 pageexcerpt, 6 pagecontent, 4 latestnews[3]"; // seconda riga
$home_rows[] = "12 banner[home]"; // terza riga



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


/********************************************
PAGINE DEL NEGOZIO
********************************************/

/*
mostra nell'header il link al carrello: true o false
*/
$header_display_cart = true;


/*
cosa mostrare in ogni colonna della pagina dello shop?
*/

$shoparchive_rows = array();
$shoparchive_rows[] = "12 catalogue[4]";


/*
cosa mostrare in ogni colonna della pagina del singolo articolo?
*/

$shop_rows = array();
$shop_rows[] = "8 fullpage, 4 socialshare minicart banner[sidebar]";


/*
cosa mostrare nella pagina del carrello?
*/

$cart_rows = array();
$cart_rows[] = "2 empty, 8 cart";
$cart_rows[] = "2 empty, 8 cartform";



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

function loricaIncludeModules($mods, $context="")
{
	global $loricaOptions, $loricaColumnWide, $loricaContext;
	
	$loricaContext = $context;
	
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

