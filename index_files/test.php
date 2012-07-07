<?php

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true)
	{
	header("Location: new_browser.php");
	}

/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);*/

//declaration of variables
$con = mysql_connect("localhost","whackand_szblog","Goose") or die("Connection Lost");
$db = "whackand_szblog";
$table = "ip_log";

$ip = $_SERVER['REMOTE_ADDR'];
//echo $ip . "<br />";
$time = date("F") . " " . date("d") . " " . date("Y") . " " . date("H:i");
$timestamp = strtotime($time);

//submitting a new link
mysql_select_db($db, $con);
$create_tb = "CREATE TABLE $table
(
	Number int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(Number),
	timestamp int(20) NOT NULL,
	ip_address varchar(25) NOT NULL
)";

//insert new links in table
mysql_select_db($db, $con);
$insert = " INSERT INTO $table
(
	
	timestamp,
	ip_address
)
VALUES
(
	'$timestamp',
	'$ip'
)";

	//Checking database for existance of "new posts" table
function table_exists($table, $db)
	{
	//retrives the whole list of tables from database
	$sql = "SHOW tables FROM $db";
	$tables_check = mysql_query($sql);
	//cycles through the list checking each entry
	while (list($temp) = mysql_fetch_array($tables_check))
		{
		if ($temp == $table)
			{
			return true;
			}
		}
		
	return false;
	}

	//executing table existance function
	if(!table_exists($table, $db))
		{
		mysql_query($create_tb,$con) or die("Could not create table:" . mysql_error());
		}


mysql_select_db($db, $con);
$sql = "SELECT * FROM $table WHERE ip_address = '$ip'";
$query = mysql_query($sql);
$row = mysql_num_rows($query);
/*echo var_dump($query) . "<br />";
echo var_dump($row) . "<br />";
echo $row . "<br />";*/


/*while($row = mysql_fetch_array($query))
	{
		echo $row['ip_address'] . "<br />";
	}*/

if($row == 0)
{
		$count_my_page = ("hitcounter.txt");
		$hits = file($count_my_page);
		$hits[0] ++;
		file_put_contents($count_my_page, $hits[0]);

	//executing insert ip address to log table
	mysql_query($insert, $con) or die("Could not complete insertion:" . mysql_error());
	
}
mysql_close();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
	<title>SZ</title>
</head>

<body>

<div id="wrapper">
		<div id="header" >
			<!--Name of my blog-->
			<a href="/"><h1 id="head">SZ /blog</h1></a>
		</div>
		
		<div id="links">
			<h4>Links of the Day</h4>
			<?php

			//declaration of variables
			$con = mysql_connect("localhost","whackand_szblog","Goose");
			$db = "whackand_szblog";
			$table = "links_sub";
			
			//sql arguments
			mysql_select_db($db);
			$sql = "SELECT * FROM $table ORDER BY timestamp DESC";
			$result = mysql_query($sql) or die("Result Error:" . mysql_error());
			
			$time = date("F") . " " . date("d") . " " . date("Y");
			
			
			//getting entries from table and placing them on the page in the html
			while($row = mysql_fetch_array($result))
			{
				$date = date("F d Y", $row['timestamp']);
				$link = stripslashes($row['link']);
				$lnk_title = stripslashes($row['link_title']);
				$lnk_title = htmlspecialchars_decode($lnk_title, ENT_QUOTES);
				
				
				if( $date == $time)
				{
			?>

					<!--These are links of the day-->
						<p>
							<a href="<?php echo $link; ?>" target="_blank"><?php echo $lnk_title; ?></a>
								<br />
						</p>
						
			<?php
				}
			}
			?>
		</div>
	
<?php 
$path = "/home2/whackand/public_html/blog";
set_include_path($path);
include("nav.php"); 
?>

		<!--The PHP will loop though the current entries in the table and display them in html-->
		<?php

			//declaration of variables
			$con = mysql_connect("localhost","whackand_szblog","Goose");
			$db = "whackand_szblog";
			$table = "b_entries";
			
			//sql arguments
			mysql_select_db($db);
			$sql = "SELECT * FROM $table ORDER BY timestamp DESC LIMIT 5";
			$result = mysql_query($sql) or die("Result Error:" . mysql_error());
			
			//getting entries from table and placing them on the page in the html
			while($row = mysql_fetch_array($result))
			{
				$date = date("l F d Y", $row['timestamp']);
				
				$title = stripslashes($row['title']);
				$title = htmlspecialchars_decode($title, ENT_QUOTES);
				$entry = stripslashes($row['entry']);
				$entry = htmlspecialchars_decode($entry, ENT_QUOTES);
			?>

			<!--This is the entry for the blog-->
			<div id="content">
				<p>
					<div id="title"><strong><?php echo $title; ?></strong></div>
						<br />
						<br />
					<div id="entry"><?php echo $entry; ?></div>
						<br />
						<br />
					<div id="date"><?php echo $date; ?></div>
						<br />
						<br />
				</p>
			</div>

		<?php
		}
		?>
		
		<!--Insert Next and Back Links here-->
		<div id="more_posts">
		
		<?php
		/*
		//connect to server
		$con = mysql_connect("localhost", "whackand_szblog", "Goose");
		$db = "whackand_szblog";
		$table = "b_entries";
		
		$sql = "SELECT * FROM $table"; 
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);
		
		if($num > 5)
			{
			
			$new_page = (
		?>
				<div id="next"><a href="#" >Next</a></div>
				<div id="back"><a href="#" >Back</a></div>
		<?php
			}*/
		?>
		</div>
		

		<!--Copy right and other links in the footer-->
	</div>
</div>
</body>
</html>
