<?php

session_start();
if($_SESSION['authenticate_admin'] != 1)
	{
	header("Location: /");
	die();
	}

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

//declaration of variables
$con = mysql_connect("localhost","whackand_szblog","Goose") or die("Connection Lost");
$db = "whackand_szblog";
$table = "b_entries";
$table1= "links_sub";

//variables to add posts to blog
$time = date("F") . " " . date("d") . " " . date("Y") . " " . date("H:i");
$timestamp = strtotime($time);
$title = isset($_POST['title']) ? stripslashes($_POST['title']) : "";
$title = htmlspecialchars($title, ENT_QUOTES);
$category = isset($_POST['category']) ? stripslashes($_POST['category']) : ""; 
$category = htmlspecialchars($category, ENT_QUOTES);
$entry = isset($_POST['entry']) ? stripslashes($_POST['entry']) : "";
$entry = nl2br($entry);
$entry = htmlspecialchars($entry, ENT_QUOTES);

//variables to delete posts
$post_title = isset($_POST['post_title']) ? stripslashes($_POST['post_title']) : "";
$post_title = htmlspecialchars($post_title, ENT_QUOTES);
$postno = isset($_POST['postno']) ? stripslashes($_POST['postno']) : "";

//variables to add link to "Links of the Day"
$link = isset($_POST['link']) ? stripslashes($_POST['link']) : "";
$link_title_add = isset($_POST['link_title_add']) ? stripslashes($_POST['link_title_add']) : "";
$link_title_add = htmlspecialchars($link_title_add, ENT_QUOTES);

//variables to delete link from "Links of the Day"
$link_title_delete = isset($_POST['link_title']) ? stripslashes($_POST['link_title']) : "";
$link_title_delete = htmlspecialchars($link_title_delete, ENT_QUOTES);
$linkno = isset($_POST['linkno']) ? stripslashes($_POST['linkno']) : "";


//getting action to perform correct function
$action = $_GET['action'];

//auto-escaping quotes
if(!get_magic_quotes_gpc())
{
	$title = addslashes($title);
	$category = addslashes($category);
	$entry = addslashes($entry);
}

//creating new table for blog posts
mysql_select_db($db, $con);
$create_tb = "CREATE TABLE $table
(
	Number int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(Number),
	timestamp int(20) NOT NULL,
	title varchar(255) NOT NULL,
	category varchar(30) NOT NULL,
	entry longtext NOT NULL

)";

//insert new posts into blog posts table
$insert = "INSERT INTO $table
(
	timestamp,
	title,
	category,
	entry
)
VALUES
(
	'$timestamp',
	'$title',
	'$category',
	'$entry'
)";

//creating new table for "Links of the Day"
$create_tb1 = "CREATE TABLE $table1
(
	Number int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(Number),
	timestamp int(20) NOT NULL,
	link varchar(255) NOT NULL,
	link_title varchar(255) NOT NULL
)";

//insert new links in table for "Links of the Day"
$insert1 = " INSERT INTO $table1
(
	timestamp,
	link,
	link_title
)
VALUES
(
	'$timestamp',
	'$link',
	'$link_title_add'
)";

//variables to delete posts from Blog
$sql = "SELECT Number FROM $table WHERE Number = '$postno' AND title = '$post_title'";
$result = mysql_query($sql) or die("Could not select number for deletion: " . mysql_error());
$num = mysql_num_rows($result);
$delete = "DELETE FROM $table WHERE Number = '$postno' && title = '$post_title'";
$no_space_post_title = str_replace(" ", "", $post_title);
$file_path = "/home2/whackand/public_html/blog/index_files/posts/" . $no_space_post_title . ".php";

//variables to delete links from "Links of the Day"
$sql_link = "SELECT Number FROM $table1 WHERE Number = '$linkno' AND link_title = '$link_title_delete'";
$result_link = mysql_query($sql_link);
$num_link = mysql_num_rows($result_link);
$delete_link = "DELETE FROM $table1 WHERE Number = '$linkno' && link_title = '$link_title_delete'";

//variables to figure out if a new display page is needed
$sql_display = "SELECT * FROM $table";
$query_display = mysql_query($sql_display);
$num_rows_display = mysql_num_rows($query_display);


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

//Checking database for existance of "links" table
function table_exists1($table1, $db)
	{
	//retrives the whole list of tables from database
	$tables_check = mysql_list_tables($db);
	//cycles through the list checking each entry
	while (list($temp) = mysql_fetch_array($tables_check))
		{
		if ($temp == $table1)
			{
			return true;
			}
		}

	return false;
	}

//logout function
function logout()
{
	session_start();
	session_destroy();
	//header("Location: /");
}

//function to check for category page
function check_category($table, $category)
{
	$sql_check_category = "SELECT * FROM $table WHERE category = '$category'";
	$result_check_category = mysql_query($sql_check_category);
	$num_check_category = mysql_num_rows($result_check_category);

	if($num_check_category == 0)
	{
	return true;
	}

	return false;
}

//function to create a new category page
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

//creating an individual page for each post
function create_page_for_post($title)
{
		$no_space_title = str_replace(" ", "", $title);

		$tpl_path = "/home2/whackand/public_html/blog/index_files/templates/";
		$tpl_file = "post_template.php";
		$placeholder = "{title}";
		$save_path = "/home2/whackand/public_html/blog/index_files/posts/";

		$tpl = file_get_contents($tpl_path.$tpl_file);

		$new_post_page = str_replace($placeholder, $title, $tpl);

		$new_post_page_name = $no_space_title . ".php";

		$fp = fopen($save_path.$new_post_page_name, "w");
		fwrite($fp, $new_post_page);
		fclose($fp);	
}

//count number of files in pages directory
function count_files()
{
	$file = scandir("/home2/whackand/public_html/blog/index_files/pages/");

	foreach($file as $key => $value) 
	{
		if(is_file($value)) 
		{	
		$total++; // Counter
		}	
	}
	return $total;
}

//creating new pages to display snippets of posts
function create_display_page()
{
		$tpl_path = "/home2/whackand/public_html/blog/index_files/templates/";
		$tpl_file = "page_template.php";
		$num_files = count_files();
		$placeholder = "{number}";
		$save_path = "/home2/whackand/public_html/blog/index_files/pages/";

		$tpl = file_get_contents($tpl_path.$tpl_file);

		$new_post_page = str_replace($placeholder, $num_files, $tpl);

		$new_post_page_name = $num_files . ".php";

		$fp = fopen($save_path.$new_post_page_name, "w");
		fwrite($fp, $new_post_page);
		fclose($fp);	
}

//action to create new entry
if($action == "new_post")
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
	if(!is_dir("/home2/whackand/public_html/blog/index_files/posts/"))
		{
			mkdir("/home2/whackand/public_html/blog/index_files/posts/");
		}
	if(is_dir("/home2/whackand/public_html/blog/index_files/posts"))
		{
	//executing insert new post
	mysql_query($insert, $con) or die("Could not complete insertion:" . mysql_error());
	create_page_for_post($title);
	if($num_rows_display % 5 == 1)
		{
			create_display_page();
		}
		}
	//header("Location: /");
}

//Executing function to submit new link to "Links of the Day"
if($action == "add_link")
{
	//executing table existance function
	if(!table_exists($table1, $db))
		{
		mysql_query($create_tb1,$con) or die("Could not create table:" . mysql_error());
		}


	//executing insert new link to "Links of the Day"
	mysql_query($insert1, $con) or die("Could not complete insertion:" . mysql_error());
	//header("Location: /");
}

//Executing function to delete a post
if($action == "delete_post" && $num > 0)
{
	mysql_query($delete) or die("Could not delete post: " . mysql_error());
	unlink($file_path);
	//header("Location: new_entry.php");
}

//Executing function to delete a link from "Links of the Day"
if($action == "delete_link" && $num_link > 0)
{
	mysql_query($delete_link);
	//header("Location: new_entry.php");
}

//Executing function to logout
if($action == "logout")
{
	logout();
}

mysql_close();
?>



<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="refresh" content="1; URL= /"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title> SZ </title>
	</head>

	<body>
		<!-- Refreshes the page to the Home Page of the Blog -->
	</body>

</html>

	

