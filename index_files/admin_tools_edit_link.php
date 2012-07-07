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
$table = "links_sub";

$title = stripslashes($_POST['link_title']);
$title = htmlspecialchars($title, ENT_QUOTES);
$link_no = stripslashes($_POST['link_no']);
$link = $_POST['new_link'];
$linkno = $_POST['linkno'];
$linktitle = $_POST['linktitle'];
$linktitle = htmlspecialchars($linktitle, ENT_QUOTES);

$action = $_GET['action'];


//SQL for getting current post
mysql_select_db($db, $con);
$sql = "SELECT * FROM $table WHERE link_title = '$title'  AND Number = '$link_no'";
$result = mysql_query($sql) or die("Current post error: " . mysql_error());
$row = mysql_fetch_array($result);
$org_link = $row['link'];


//SQL for editing a post
mysql_select_db($db, $con);
$sql = "UPDATE $table SET link_title = '$linktitle', link = '$link' WHERE Number = '$linkno'"; 


if ($action == "update_link")
{
	mysql_query($sql) or die("Update error: " . mysql_error());
}
?>

<html>
<head>
	<title>Edit Post</title>
	<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
	
	<script type="text/javascript" language="javasript">
		function update_link()
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
			<form name="edit_link" onSubmit="update_link()" action="admin_tools_edit_link.php?action=update_link" enctype="multipart/form-data" method="post">
				<label name="edit">Edit the post</label>
					<br />
					<br />
				<label name="linknum">Post Number:</label><input name="linkno" type="text" value="<?php echo $link_no; ?>" />
					<br />
					<br />
				<label name="linktit">Post Title:</label><input name="linktitle" type="text" value="<?php echo $title; ?>" />
					<br />
					<br />
				<textarea name="new_link" cols="70" rows="5"><?php echo $org_link; ?></textarea>
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
