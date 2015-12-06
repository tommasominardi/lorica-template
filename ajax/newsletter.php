<?php

/* NEWSLETTER GATEWAY */
if(!empty($_POST['nl_leaveEmpty'])) die();

$args = array();
$args['name'] = $_POST['nl_name'];
$args['email'] = $_POST['nl_email'];
$args['code'] = substr($_POST['nl_code'],4);

if(empty($args['email'])) die();
if(empty($args['code'])) die();

if(is_numeric($args['code'])) $args['listid'] = $args['code'];
else $args['listname'] = $args['code'];


require_once('../../../inc/tplshortcuts.lib.php');
kInitBettino('../../../');

$vars = array(
	"name" => $args['name'],
	"email" => $args['email'],
);
if(isset($args['listid'])) $vars['listid'] = intval($args['listid']);
else $vars['listname'] = trim($args['listname']);

if(kNewsletterSubscribe($vars)) echo "1";
