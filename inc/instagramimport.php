<?
require_once('../../../inc/tplshortcuts.lib.php');
kInitBettino('../../../');
require_once('../inc/functions.php');

error_reporting(E_ALL);
$instagram=new instagram();

if(isset($_GET['hub_mode'])&&$_GET['hub_mode']=='subscribe'&&isset($_GET['hub_challenge'])) {
	echo $_GET['hub_challenge'];
	die();
	}
$clientID='0d4788d97d3d4f74af57f9654c4b2742';
$userid='1554280483';


// get recent images
// Initialize session and set URL.
$url="https://api.instagram.com/v1/users/".$userid."/media/recent?&count=10&client_id=".$clientID."";
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false); // accept any SSL certificate
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); // Set so curl_exec returns the result instead of outputting it.

$response=curl_exec($ch);
curl_close($ch);

$photos=json_decode($response);
if($photos->{'meta'}->{'code'}==200)
{
	foreach($photos->{'data'} as $photo)
	{
		//print_r($photo);
		//echo '<br><br>';

		//if(!isset($photo->{'location'})) continue; // skip non-geotagged posts
		
		$link=$photo->{'link'};

		$text=$photo->{'caption'}->{'text'};
		//remove hashtags
		//$text=preg_replace("/#[[:alnum:]]+/","",$text);
		$text=trim($text);
		
		$author=$photo->{'user'}->{'full_name'};
		$filename=$photo->{'images'}->{'standard_resolution'}->{'url'};
		$videofilename="";
		if($photo->{'type'}=="video") $videofilename=$photo->{'videos'}->{'standard_resolution'}->{'url'};
		
		$datetime=date("Y-m-d H:i:s",$photo->{'created_time'});

		$lat=(!empty($photo->{'location'}->{'latitude'}) ? $photo->{'location'}->{'latitude'} : 0);
		$lng=(!empty($photo->{'location'}->{'longitude'}) ? $photo->{'location'}->{'longitude'} : 0);
		
		$city=isset($photo->{'location'}->{'name'}) ? $photo->{'location'}->{'name'} : '';

		$tags="#";
		foreach($photo->{'tags'} as $tag)
		{
			$tags.=$tag."#";
		}
		
		$vars=array();
		$vars['link']=$link;
		$vars['author']=$author;
		$vars['text']=$text;
		$vars['filename']=$filename;
		$vars['videofilename']=$videofilename;
		$vars['lat']=$lat;
		$vars['lng']=$lng;
		$vars['tags']=$tags;
		$vars['datetime']=$datetime;
		$vars['city']=$city;

		$result=$instagram->addPost($vars);
		if($result==false) echo "Error while importing ".$filename;
	}


} else {
	echo '!';
	echo '<strong>Error '.$photos->{'meta'}->{'code'}.'</strong><br />';
	echo $photos->{'meta'}->{'error_message'};
}


?>