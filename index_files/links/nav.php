		<!--Links and other info-->
		<div id="nav">
			
			<label name="home"><a href="/">Home</a></label>
			
			<h4 class="sites">My Other Sites</h4>
				<a href="http://www.whackandblite.com/" target="_blank" >Whack and Blite</a>
				
			<h4 class="category">Categories</h4>
				<?php

				$con = mysql_connect("localhost","whackand_szblog","Goose");
				$db = "whackand_szblog";
				$table = "b_entries";
				
				mysql_select_db($db, $con);
				$sql = "SELECT DISTINCT category FROM $table";
				$result = mysql_query($sql);
				
				while( $row = mysql_fetch_array($result))
					{

						$category = $row['category'];
						$category = htmlspecialchars_decode($category, ENT_QUOTES);
				?>
							
						<a href="/index_files/category_pages/<?php echo $category ?>.php"><?php echo$category ?></a>
						<br />
							
				<?php
						
					}
					mysql_close();
				?>

			<h4 class="archive">Archive</h4>
				<a href="/index_files/links/lotd.php">Links of the Day</a>
					<br />
			
			<h4 class="other">Other</h4>
				<a href="/index_files/links/about.php">About</a>
					<br />
				<a href="/index_files/links/contact.php">Contact</a>
					<br />
				<a href="/index_files/admin_login.php">Login</a>
					<br />
			<h4 class="other">Friends</h4>
				<a href="http://xdproductions.com/" target="_blank"> XD Productions </a>
					<br />
				<a href="http://clintsinecuador.blogspot.com/" target="_blank"> Make Sure Your Shoes Are Tied </a>
			<h4 class="soc_media">Social Media</h4>
				<div id="soc_media">
					<a href="/index_files/links/rss.php"><img src="/index_files/images/rss.jpg" alt="RSS feed" /></a>
				</div>
				
		<!--Include an RSS Feed, Facebook et al link here-->
		</div>
