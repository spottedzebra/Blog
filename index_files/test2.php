<?php

$con = mysql_connect("localhost", "db", "pw");
$db = "db";
$table = "tb";

$time = date("F") . " " . date("d") . " " . date("Y") . " " . date("H:i");
$timestamp = strtotime($time);
$title = isset($_POST['title']) ? stripslashes($_POST['title']) : "";
$title = htmlspecialchars($title, ENT_QUOTES);
$category = isset($_POST['category']) ? stripslashes($_POST['category']) : ""; 
$category = htmlspecialchars($category, ENT_QUOTES);
$entry = isset($_POST['entry']) ? stripslashes($_POST['entry']) : "";
$entry = nl2br($entry);
$entry = htmlspecialchars($entry, ENT_QUOTES);
$postno = isset($_POST['postno']) ? stripslashes($_POST['postno']) : "";

$post_array = array($title, $title, $entry, $timestamp);

//creating new table
mysql_select_db($db, $con);
$create_tb = "CREATE TABLE $table
(
	Number int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(Number),
	timestamp int(20) NOT NULL,
	title varchar(255) NOT NULL,
	category varchar(30),
	entry longtext NOT NULL
	
)";

//insert new entries to table
$insert = "INSERT INTO $table
(
	timestamp,
	title,
	category,
	entry,
	link
)
VALUES
(
	'$timestamp',
	'$title',
	'$category',
	'$entry',
	'$post_link'
)";

function create_category_page($category)
	{
		$tpl_path = "/home2/whackand/public_html/blog/index_files/templates/";
		$tpl_file = "category_template.php";
		$save_path = "/home2/whackand/public_html/blog/index_files/category_pages/";
		$placeholders = "{category}";
		
		$tpl = file_get_contents($tpl_path.$tpl_file);

		$new_category_page = str_replace($placeholders, $category, $tpl);

		$new_category_page_name = $category . ".php";

		$fp = fopen($save_path.$new_category_page_name, "w");
		fwrite($fp, $new_category_page);
		fclose($fp);
	}
	
function create_new_post($post_array)
	{
		$tpl_path = "/home2/whackand/public_html/blog/index_files/templates/";
		$tpl_file = "post_template.php";
		$save_path = "/home2/whackand/public_html/blog/index_files/post_pages/";
		$placeholders = "{title}, {title}, {entry}, {date}"
		
		$tpl = file_get_contents($tpl_path.$tpl_file);
		
		$new_post_page = str_replace($placeholders, $post_array, $tpl);
		
		$new_post_page_name = $title . "php";
		
		$fp = fopen($save_path.$new_post_page_name, "w");
		fwrite($fp, $new_post_page);
		fclose($fp);
	}

//action to create new entry
if($action == "newentry")
{
	//executing table existance function
	if(!table_exists($table, $db))
		{
		mysql_query($create_tb,$con) or die("Could not create table:" . mysql_error());
		}
		
	if(check_category($table, $category))
		{
			create_category_page($category);
		}
	
	create_new_post($post_array);
	//executing insert new entry
	mysql_query($insert, $con) or die("Could not complete insertion:" . mysql_error());
	//header("Location: /");
}

?>
