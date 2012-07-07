<?php
//checking if admin is logged in or not
session_start();
if($_SESSION['authenticate_admin'] != 1)
	{
	header("Location: /");
	die();
	}
	
?>
<!DOCTYPE html>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
<title>Admin Tools</title>
<script type="javascript" language="javascript">
//must make a call to the js to make the php work
function new_entry()
{
	return true;
}

function logout();
{
	return true;
}
</script> 

<style type="text/css" language="css">
#entry_form{display: inline}
h1{text-align: center}
</style>
</head>

<body>
<div id="wrapper">

	<div id="header">
		<!--Page Title-->
		<h1>Admin Tools</h1>
	</div>
	<div id="counter">
		<h3>Number of Hits</h3>
		<?php
		$count_my_page = ("/home2/whackand/public_html/blog/hitcounter.txt");
		$hits = file($count_my_page);
		fopen($count_my_page, "r");
		?>
		<div id="hits"><?php echo $hits[0]; ?></div>
	</div>
	<div id="main">
		<!--Links and other info-->
		<div id="nav">
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>
		
		
			<h3 class="tools">Admin Tools</h3>
			
				<a href="#link_sub">Submit Link</a>
				<br />
				<a href="#entry_form">New Post</a>
				<br />
				<a href="#delete_entries">Delete Post</a>
				<br />
				<a href="#list_entries">List Posts</a>
				<br />
				<a href="#edit">Edit Post</a>
				<br />
				<a href="#logout">Logout</a>
				<br />
			
	</div>

	<div id="content">
		<!--Link Submittal-->
		<div id="link_sub">
			<h3>Submit a new link</h3>
		
			<form name="link_sub" onsubmit="sub_link()" action="admin_tools_functions.php?action=add_link" enctype="multipart/form-data" method="post">
				<label>Link Title:</label> <!--add link title-->
				<br />
				<input type="text" name="link_title_add" />
				<br />
				<br />
				<label name="link">Insert link:</label>
				<br />
				<input type="text" name="link" />
				<br />
				<br />
				<input type="submit" value="Submit Link" />
			</form>
		</div>
		<!-- Form to insert new submissions in table -->
<!-- FIX THE NON ESCAPING CHARACTERS. SPECIFICALLY THIS '. VERY FRUSTRAITING NOT BEING ABLE TO HYPHENATE WORDS.

	-solution build loop to check for ' and " , they should be escaped with \' or \". will manually do this for now. -->
		<div id="entry_form">
			<h3>New Post</h3>
		
			<form name="new_entry" onSubmit="new_entry()" action="admin_tools_functions.php?action=new_post" enctype="multipart/form-data" method="post">
			
				<div id="title">
					<label name="title">Title:</label><input type="text" name="title" />
				</div>
				
				<br />
				
				<div id="category">
					<label name="category">Category:</label><input type="text" name="category" />
				</div>
				
				<br />
				
				<div id="entry">
					<label name="entry">Entry Text:</label>
				</div>
				
				<div id="textarea">
					<textarea cols="70" rows="30" name="entry"></textarea>
				</div>
				
				<br />
				
				<div id="input">
					<input type="Submit" value="Submit Entry" />
				</div>
				
				<br />
				
			</form>
		</div>
		
		<!--Deleting a blog entry-->
		<div id="delete_entries">
			<h3>Deleting Posts</h3>
		
			<form name="delete" onSubmit="delete_entry()" action="admin_tools_functions.php?action=delete_post" enctype="multipart/form-data" method="post">
			
			<div id="postno">
				<label name="postno" >Post Number:</label><input type="text" name="postno" />
			</div>
			
			<br />
			
			<div id="post_title">
				<label name="post_title">Title:</label><input type="text" name="post_title" />
			</div>
			
			<br />
			
			<div id="input">
				<input type="Submit" value="Delete Submission" /> 
			</div>
			
			</form>
		</div>
		
		<!--Deleting a link-->
		<div id="delete_links">
			<h3>Deleting Links</h3>
		
			<form name="delete_links" onSubmit="delete_links()" action="admin_tools_functions.php?action=delete_link" enctype="multipart/form-data" method="post">
			
			<div id="linkno">
				<label name="linkno" >Link Number:</label><input type="text" name="linkno" />
			</div>
			
			<br />
			
			<div id="link_title">
				<label name="link_title">Link Title:</label><input type="text" name="link_title" />
			</div>
			
			<br />
			
			<div id="input">
				<input type="Submit" value="Delete Link" /> 
			</div>
			
			</form>
		</div>

		<!-- List Entries -->
		<div id="list_entries">
			<h3>List Entries</h3>
				
			<a href="/index_files/table_entries.php" ><button type="button" value="List Entries" >List Entries</button></a>
		</div>
		<!-- List Links -->
		<div id="list_links">
			<h3>List Links</h3>
				
			<a href="/index_files/table_links.php" ><button type="button" value="List Links" >List Links</button></a>
		</div>		

			<!-- List IPs -->
		<div id="list_ips">
			<h3>List IP Addresses</h3>
				
			<a href="/index_files/table_ip.php" ><button type="button" value="List Links" >List IPs</button></a>
		</div>	
		
		<!--Editing a blog entry-->
		<div id="edit">
			<h3>Editing an Entry</h3>
		
			<form name="delete_entry" action="admin_tools_edit_entry.php" enctype="multipart/form-data" method="post">
			
			<div id="postno">
				<label name="postno" >Post Number:</label><input type="text" name="postno" />
			</div>
			
			<br />
			
			<div id="post_title">
				<label name="post_title">Title:</label><input type="text" name="post_title" />
			</div>
			
			<br />
			
			<div id="input">
				<input type="Submit" value="Edit" /> 
			</div>
			
			<br />
			
			</form>
		</div>
		
				<!--Editing a link-->
		<div id="edit">
			<h3>Editing a Link</h3>
		
			<form name="delete_link" action="admin_tools_edit_link.php" enctype="multipart/form-data" method="post">
			
			<div id="postno">
				<label name="link_postno" >Link Number:</label><input type="text" name="link_no" />
			</div>
			
			<br />
			
			<div id="post_title">
				<label name="link_post_title">Title:</label><input type="text" name="link_title" />
			</div>
			
			<br />
			
			<div id="input">
				<input type="Submit" value="Edit" /> 
			</div>
			
			<br />
			
			</form>
		</div>

		<!--Logout Button-->
		<div id="logout">
			<form name="logout" onSubmit="logout()" action="admin_tools_functions.php?action=logout" enctype="multipart/form-data" method="post">
			<input type="submit" value="Logout" />
			</form>
		</div>
	</div>
</div>

</body>

</html>
