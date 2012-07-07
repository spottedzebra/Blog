<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL|E_STRICT);
	
	$con = mysql_connect("localhost", "whackand_szblog", "Goose");
	$db = "whackand_szblog";
	$table = "b_entries";
			

	
	$time = date("D") . ", " . date("d") . " " . date("M") . " " . date("Y") . " " . date("H") . ":" . date("i") . ":" . date("s") . " " . date("e");
			
echo '<?xml version="1.0" ?>
	<rss version="2.0">
	<channel>
		<title>SZ Blog RSS Feed</title>
		<link>http://blog.whackandblite.com</link>
		<description>RSS Feed for SZ Blog</description>
		<lastBuildDate>'.$time.'</lastBuildDate>
		<language>en-us</language>';			
			
			mysql_select_db($db);
			$sql = "SELECT * FROM $table ORDER BY timestamp DESC";
			$query = mysql_query($sql);
		
			while($row = mysql_fetch_array($query))
			{
				$title = $row[title];
				$category = $row[category];
				$post = $row[entry];
				$timestamp = date("D, d M Y H:i:s e", $row[timestamp]);
				$title_nospace = str_replace(" ", "", $title);

			echo '<item>
				<title>'.$title.'</title>
				<link>http://blog.whackandblite.com/index_files/posts/'.$title_nospace.'.php</link>
				<datePub>'.$timestamp.'</datePub>
				<description>[CDATA['.$category.'<br />'.$post.']]</description>
			</item>';
			

			}
			mysql_close();
			
	echo '</channel>
	</rss>';
?>

