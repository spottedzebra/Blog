<html>
<head>
	<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("head.php"); 
	?>
</head>

<body>

<div id="wrapper">
	<div id="header">
		<!--Name of my blog-->
		<a href="/"><h1>SZ /lotd</h1></a>
	</div>
	
	<div id="main">	
	
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>

		<!--This is the entry for the blog-->
		<div id="content">
		
		<p>I'm still working on this page but it will give you what you need for now.</p>
			<?php

				$con = mysql_connect("localhost","whackand_szblog","Goose") or die("Could not connect");
				$db = "whackand_szblog";
				$table = "links_sub";

				mysql_select_db($db, $con);
				$sql = "SELECT * FROM $table ORDER BY timestamp DESC";
				$result = mysql_query($sql) or die("Query Error: " . mysql_error());

				while($row = mysql_fetch_array($result))
					{
						$link = stripslashes($row['link']);
						$title = stripslashes($row['link_title']);
						$date = date("F d Y", $row['timestamp']);
						
				
			?>
			
			<strong><?php echo $date ?></strong>
			<br />
			<a href="<?php echo $link; ?>" target="_blank"><?php echo $title ?></a>
			<br />
			<br />
			
			<?php
					}
			?>
		</div>

	</div>
</div>
</body>
</html>