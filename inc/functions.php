<?php

class instagram
{
	
	public function __construct()
	{
		$this->checkDBTable();
	}
	
	// check if db table exists, and create it if not
	public function checkDBTable()
	{
		$results=ksql_query("SHOW TABLES LIKE 'ig_posts'");
		$row=ksql_fetch_array($results);
		if($row==false)
		{
			ksql_query("CREATE TABLE IF NOT EXISTS `ig_posts` (
			  `idpost` int(16) NOT NULL AUTO_INCREMENT,
			  `author` varchar(64) NOT NULL,
			  `link` varchar(255) NOT NULL,
			  `text` text NOT NULL,
			  `datetime` datetime NOT NULL,
			  `filename` varchar(255) NOT NULL,
			  `videofilename` varchar(255) NOT NULL,
			  `lat` decimal(16,8) NOT NULL,
			  `lng` decimal(16,8) NOT NULL,
			  `city` varchar(128) NOT NULL,
			  `tags` text NOT NULL,
			  PRIMARY KEY (`idpost`),
			  UNIQUE KEY `link` (`link`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8");
		}
	}
	
	public function addPost($vars)
	{
		$link=ksql_real_escape_string($vars['link']);
		$author=ksql_real_escape_string(trim($vars['author']));
		$text=ksql_real_escape_string(nl2br(trim($vars['text'])));
		if(!isset($vars['datetime'])) $vars['datetime']=date("Y-m-d H:i:s");
		$datetime=ksql_real_escape_string($vars['datetime']);
		$filename=ksql_real_escape_string($vars['filename']);
		$videofilename=ksql_real_escape_string($vars['videofilename']);
		$lat=ksql_real_escape_string($vars['lat']);
		$lng=ksql_real_escape_string($vars['lng']);
		$tags=ksql_real_escape_string($vars['tags']);
		$city=ksql_real_escape_string($vars['city']);
		
		$query="SELECT `idpost` FROM `ig_posts` WHERE `link`='".$link."' LIMIT 1";
		$results=ksql_query($query);
		$row=ksql_fetch_array($results);
		if(!empty($row['idpost'])) return false;
		
		$query="INSERT INTO `ig_posts` (`link`,`author`,`text`,`datetime`,`filename`,`videofilename`,`lat`,`lng`,`city`,`tags`)
				VALUES('".$link."','".$author."','".$text."','".$datetime."','".$filename."','".$videofilename."','".$lat."','".$lng."','".$city."','".$tags."')";
		if(ksql_query($query)) return ksql_insert_id();
		else return false;
	}
	
	public function getPosts($vars=array()) {
		$output=array();

		if(empty($vars['limit'])) $vars['limit']=10;
		if(!isset($vars['tags'])) $vars['tags']=array();
		if(!is_array($vars['tags'])) $vars['tags']=array($vars['tags']);

		$query="SELECT * FROM `ig_posts` WHERE filename<>'' ";
		
		if(count($vars['tags']>0))
		{
			foreach($vars['tags'] as $t)
			{
				$query.=" AND `tags` LIKE '%#".ksql_real_escape_string($t)."#%' ";
			}
		}
		
		$query.=" ORDER BY `datetime` DESC LIMIT ".$vars['limit'];
		$results=ksql_query($query);
		while($row=ksql_fetch_array($results))
		{
			$row['tags']=explode("#",trim($row['tags'],"#"));
			$row['date']=strftime("%d %B %Y",mktime(1,0,0,substr($row['datetime'],5,2),substr($row['datetime'],8,2),substr($row['datetime'],0,4)));
			$row['time']=strftime("%H:%i",mktime(substr($row['datetime'],11,2),substr($row['datetime'],14,2),substr($row['datetime'],17,4),substr($row['datetime'],5,2),substr($row['datetime'],8,2),substr($row['datetime'],0,4)));
			$output[]=$row;
		}
		return $output;
	}

	public function getPost($vars) {
		$query="";
		if(isset($vars['idpost'])) {
			if(!is_numeric($vars['idpost'])) return false;
			$query="SELECT * FROM `ig_posts` WHERE `idpost`='".ksql_real_escape_string($vars['idpost'])."' LIMIT 1";
			}
		elseif(isset($vars['filename'])) {
			$query="SELECT * FROM `ig_posts` WHERE `filename`='".ksql_real_escape_string($vars['filename'])."' LIMIT 1";
			}

		if($query!="") {
			$results=ksql_query($query);
			$row=ksql_fetch_array($results);
			return $row;
			}
		return false;
	}
}
?>