<?php

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true)
	{
	header("Location: new_browser.php");
	}
?>

<html>
<head>
	<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("head.php"); 
	?>
</head>

<body>

<!--"wrapper" centers text and sets overall width-->
<div id="wrapper">

	<div id="header">
		<!--Name of my blog-->
		<a href="/"><h1>SZ /category</h1></a>
	</div>
	
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>
		
		<?php

		//declaration of variables
		$con = mysql_connect("localhost", "whackand_szblog", "Goose");
		$db = "whackand_szblog";
		$table = "b_entries";

		mysql_select_db($db, $con);
		$category = "";
		$sql = "SELECT * FROM $table WHERE category = '$category'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			$title = stripslashes($row['title']);
			$title = htmlspecialchars_decode($title, ENT_QUOTES);
			$no_space_title = str_replace(" ", "", $title);
			$entry = stripslashes($row['entry']);
			$entry = htmlspecialchars_decode($entry, ENT_QUOTES);	
			
			$date = date("l F d Y", $row['timestamp']);
			
		?>
		<!--This is the entry for the blog-->
		<div id="content">
			<p>
				<div id="title"><strong><a href="/index_files/posts/<?php echo $no_space_title; ?>.php"><?php echo $title; ?></a></strong></div>
				<div id="date"><?php echo $date; ?></div>
					<br />
					<br />
				<div id="entry"><?php echo $entry; ?></div>
					<br />
					<br />
			</p>
		</div>

		<?php
		}
		?>
	<!--Insert Next and Back Links here-->

	<!--Copy right and other links in the footer-->
<div class="clearfooter"></div>
</div>
<div id="footer">
		<?php
			$path = "/home2/whackand/public_html/blog/index_files/links/";
			set_include_path($path);
			include("footer.php"); 
		?>
</div>
</body>
</html>