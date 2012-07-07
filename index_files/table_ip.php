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
			<a href="/"><h1 id="head">SZ /visitors</h1></a>
	</div>
	
	<div id="main">
				<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>

		<div id="content">
			<table id="table" >
				<tr>
					<th>Visitor Number</th>
					<th>IP Address</th>
				</tr>
			</table>

			<?php
				//declaration of variables
				$con = mysql_connect("localhost","whackand_szblog","Goose") or die("Connection Lost");
				$db = "whackand_szblog";
				$table = "ip_log";

				//function to list entries
				mysql_select_db($db, $con);
				$sql = "SELECT * FROM $table";
				$result = mysql_query($sql) or die("List Entries Error:" . mysql_error());

				
				function ip_locate($ip)
				{
				require_once('/home2/whackand/public_html/API/ip2locationlite.class.php');
				$ipLite = new ip2location_lite;
				$ipLite->setKey('7224e73a9f1b285fd0cfd5c786e5a281b7f8346777200c883fefce3175b9cedf');
				
				$locations = $ipLite->getCountry($ip);
				$errors = $ipLite->getError();

				if(!empty($locations) && is_array($locations))
				{
						return $locations['countryName'] . " ";
						return $locations['cityName'];
				}
				}



				while($row = mysql_fetch_array($result))
				{
					$number = $row['Number'];
					$ip = $row['ip_address'];
					$date = date("F d Y", $row['timestamp']);
					$info = ip_locate($ip);
				
			?>

				<table id="table" >
					<tr>
						<td id="post_no"><?php echo $number; ?></td>
						<td id="posttitle"><?php echo $ip; ?></td>
						<td id="ipaddress"><?php echo $date; ?></td>
						<td id="location"><?php echo $info; ?></td>
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