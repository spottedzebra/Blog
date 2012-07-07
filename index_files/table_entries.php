<?php

session_start();
if($_SESSION['authenticate_admin'] != 1)
	{
	header("Location: /");
	die();
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
	<title>SZ</title>
</head>

<body>

<div id="wrapper">
	<div id="header">
		<h1>SZ</h1>
	</div>
	
	<div id="main">
		<!--Links and other info-->
		<div id="nav">
			
			<label name="home"><a href="/">Home</a></label>
			
			<h4 class="sites">My Other Sites</h4>
				<a href="http://www.whackandblite.com/" target="_blank" >Whack and Blite</a>
				
			<h4 class="category">Categories</h4>
				<a href="/index_files/testing.php">Testing</a>
					<br />
				<!--<a href="index_files/construction.php">Cosntruciton</a>-->

			<h4 class="archive">Archive</h4>
				<a href="/index_files/lotd.php">Links of the Day</a>
					<br />
			
			<h4 class="other">Other</h4>
				<a href="/">About</a>
					<br />
				<a href="/index_files/contact.php">Contact</a>
					<br />
				<a href="/index_files/admin_login.php">Login</a>

		<!--Include an RSS Feed, Facebook et al link here-->
		</div>

		<div id="content">
			<table id="table" >
				<tr>
					<th>Post Number</th>
					<th>Title</th>
				</tr>
			</table>

			<?php
				//declaration of variables
				$con = mysql_connect("localhost","whackand_szblog","Goose") or die("Connection Lost");
				$db = "whackand_szblog";
				$table = "b_entries";

				//function to list entries
				mysql_select_db($db, $con);
				$sql = "SELECT * FROM $table";
				$result = mysql_query($sql) or die("List Entries Error:" . mysql_error());

				while($row = mysql_fetch_array($result))
				{
					$number = $row['Number'];
					$title = $row['title'];
				
			?>

				<table id="table" >
					<tr>
						<td id="post_no"><?php echo $number ?></td>
						<td id="posttitle"><?php echo $title ?></td>
					</tr>
				</table>
				
			<?php
			}
			?>
		</div>
	</div>
</div>

</body>
</html>