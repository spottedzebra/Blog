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

<div id="wrapper">
		<div id="header" >
			<!--Name of my blog-->
			<a href="/"><h1 id="head">SZ /about</h1></a>
		</div>
		
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>

		<!--The PHP will loop though the current entries in the table and display them in html-->
		

			<!--This is the entry for the blog-->
			<div id="content">

					<h3>About Me</h3>
					<p>
						Let me start off by saying that I am a huge believer in online privacy and not letting to much inforation out about yourself. Ironic, I know, because I have a blog but I like to think I am in some control about what is said and how much of this is on the internet. This preface is to apologize for any vague points on this page or others. 
						<br />
						<br />
						I am a student at a "four year university" but my degree is actually a required five years. I grew up in a small Mid-western town going to public school. My hobbies include DIY electronics, programming, internet culture, new gadgets, learning how to do new things, and building/repairing/working on computers. 
						<br />
						<br />					
						The purpose of this site is two-fold. I wanted something were I could post about things I am interested in and maybe write about some of them, that's the first fold. The second fold; as I said I like to program, and web developement is a lot of fun so I thought a blog, that could be challenging and fun at the same time. So far it has been a massive learning experience and I plan to continue development because if it isn't broke it doesn't have enough features. 
						<br />
						<br />					
						I am never very good at writing the 'About Me' page of a website. There is a lot more to a person than what can be included in a few paragraphs but I think you get the gist of who I am. If you stick around you will probably figure about a bunch more from the posts and links of the day.
						<br />
						<br />					
						...thanks for stopping by.
					</p>

			</div>
		
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
</body>
</html>