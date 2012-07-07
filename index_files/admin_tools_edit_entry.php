<?php

//checking if admin is logged in or not
session_start();
if($_SESSION['authenticate_admin'] != 1)
	{
	header("Location: /");
	die();
	}
/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);*/

$con = mysql_connect("localhost","whackand_szblog","Goose");
$db = "whackand_szblog";
$table = "b_entries";

$title = stripslashes($_POST['post_title']);
$postno = stripslashes($_POST['postno']);
$entry = $_POST['post'];
$post_no = $_POST['post_no'];
$post_title = $_POST['posttitle'];

$action = $_GET['action'];


//SQL for getting current post
mysql_select_db($db, $con);
$sql = "SELECT * FROM $table WHERE title = '$title'  AND Number = '$postno'";
$result = mysql_query($sql) or die("Current post error: " . mysql_error());
$row = mysql_fetch_array($result);
$post = $row['entry'];


//SQL for editing a post
mysql_select_db($db, $con);
$sql = "UPDATE $table SET entry = '$entry', title = '$post_title' WHERE Number = '$post_no'"; 


if ($action == "update_post")
{
	mysql_query($sql) or die("Update error: " . mysql_error());
}
?>

<html>
<head>
	<title>Edit Post</title>
	<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
	
	<script type="text/javascript" language="javasript">
		function update_post()
			{
				if(document.getElementById("save").value == "Save")
					{
						return true;
					}
				else
					{
						return false;
					}
			}
	</script>
	
</head>


<body>

<div id="wrapper">

	<div id="header">
		<h1>Editing the post</h1>
	</div>
	
	<div id="main">
	
		<div id="nav">
			<label name="home"><a href="/">Home</a></label>
			
			<h3 class="sites">My Other Sites</h3>
				<a href="http://www.whackandblite.com/" target="_blank">Whack and Blite</a>
				
			<h3 class="category">Categories</h3>
				<a href="/index_files/testing.php">Testing</a>
					<br />
				<!--<a href="index_files/construction.php">Cosntruciton</a>-->
				
			<h3>Awesomeness</h3>
			
			<h3 class="other">Other</h3>
				<a href="/">About</a>
					<br />
				<a href="/index_files/contact.php">Contact</a>
					<br />
				<a href="/index_files/admin_login.php">Login</a>

		<!--Include an RSS Feed, Facebook et al link here-->		
		</div>
		
		<div id="content">
			<form name="edit_post" onSubmit="update_post()" action="admin_tools_edit_entry.php?action=update_post" enctype="multipart/form-data" method="post">
				<label name="edit">Edit the post</label>
					<br />
					<br />
				<label name="postnum">Post Number:</label><input name="post_no" type="text" value="<?php echo $postno; ?>" />
					<br />
					<br />
				<label name="posttit">Post Title:</label><input name="posttitle" type="text" value="<?php echo $title; ?>" />
					<br />
					<br />
				<textarea name="post" cols="70" rows="30"><?php echo $post; ?></textarea>
					<br />
					<br />
				<input type="submit" value="Save" id="save" />
				<input type="submit" value="Cancel" id="cancel" />
			</form>
		</div>
		
	</div>
	
	<div id="footer">
	
	</div>
	
</div>
</body>
</html>
