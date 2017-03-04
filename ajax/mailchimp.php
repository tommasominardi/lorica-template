<?php
/* load settings */
require_once('../config.php');

/* check the honeypot captcha */
if(!isset($_POST['nl_leaveEmpty']) || $_POST['nl_leaveEmpty']!="") die('Errore nel sistema antispam. Sei sicuro di essere un umano?');

/* check the mandatory fields */
if(!isset($_POST['nl_email'])) die('Devi indicare il tuo indirizzo e-mail');

$_POST['nl_name']=trim($_POST['nl_name']);
$_POST['nl_email']=trim($_POST['nl_email']);


/* subscribe to newsletter */
require_once('Mailchimp-v3/MailChimp.php');
use \DrewM\MailChimp\MailChimp;

$apikey = $GLOBALS['mailchimp_api_key'];
$listid = $_POST['nl_code'];

$MailChimp = new MailChimp($apikey);

$options = array();
$interests = array();
$groups = '';
if(!empty($_POST['nl_groupname'])) $groups = strtolower( ',' . implode(",", $_POST['nl_groupname']) . ',' );

// get interest id and set it to true
$result = $MailChimp->get("lists/".$listid."/interest-categories");
if(!empty($result['categories']))
{
	foreach($result['categories'] as $category)
	{
		if(empty($category['id'])) continue;
		//if(strtolower($category['title']) != strtolower($_POST['grouptitle'])) continue;
		$r = $MailChimp->get("lists/".$listid."/interest-categories/".$category['id']."/interests");
		foreach($r['interests'] as $interest)
		{
			if( strpos( $groups, ','.strtolower($interest['name']).',' ) !== false )
				$interests[ $interest['id'] ] = true;
		}
	}
}

// get member, if exists
$result = $MailChimp->get("lists/".$listid."/members/". md5(strtolower($_POST['nl_email'])));
if(!empty($result['interests']))
{
	// add already defined interests
	foreach($result['interests'] as $interest_id=>$selected)
	{
		if($selected == true)
			$interests[ $interest_id ] = true;
	}
	
	// delete pending users
	if($result['status']=='pending')
	{
		$MailChimp->delete("lists/".$listid."/members/". md5(strtolower($_POST['nl_email'])));
	}
}

// try to separate first name and last name
if(!isset($_POST['nl_name'])) $_POST['nl_name'] = '';
$_POST['nl_name'] = trim($_POST['nl_name']);
$_POST['nl_name'] = ucwords($_POST['nl_name']);

// split on first space
if(strpos($_POST['nl_name'], " ")!==false)
{
	$fname = substr($_POST['nl_name'], 0, strpos($_POST['nl_name'], " "));
	$lname = substr($_POST['nl_name'], strpos($_POST['nl_name'], " ")+1);
} else {
	$fname = $_POST['nl_name'];
	$lname = "";
}


$options['FNAME'] = $fname;
$options['LNAME'] = $lname;

// subscribe
$data = [
	"email_address" => $_POST['nl_email'],
	"email_type" => "html",
	"status_if_new" => "pending",
	"status" => "subscribed",
	];
if(!empty($options)) $data["merge_fields"] = $options;
if(!empty($interests)) $data["interests"] = $interests;

$result = $MailChimp->put("lists/".$listid."/members/". md5(strtolower($_POST['nl_email'])) , $data );


/* error occurred */
if(isset($result['error']))
{
	echo "Qualcosa è andato storto! Per favore riprova...";
	die();
}

echo "1";
