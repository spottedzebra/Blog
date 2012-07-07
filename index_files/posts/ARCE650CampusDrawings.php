<?php

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true)
	{
	header("Location: new_browser.php");
	}

/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);*/

				$con = mysql_connect("localhost", "whackand_szblog", "Goose");
				$db = "whackand_szblog";
				$comment_table = "comments";
				
				$title = "ARCE 650 Campus Drawings";
				$title = stripslashes($title);
				$title = htmlspecialchars_decode($title);
				
				$comment_number = get_num($comment_table, $db, $con, $title);
				
				$time = date("F") . " " . date("d") . " " . date("Y") . " " . date("H:i");
				$timestamp = strtotime($time);
				
				$user_comment_name = isset($_POST['user_comment_name']) ? stripslashes($_POST['user_comment_name']) : "";
				$user_comment_name = htmlspecialchars($user_comment_name);
				$user_comment_name =  mysql_real_escape_string($user_comment_name);
				$user_comment_email = isset($_POST['user_comment_email']) ? stripslashes($_POST['user_comment_email']) : "";
				$user_comment_email = htmlspecialchars($user_comment_email);
				$user_comment_email = mysql_real_escape_string($user_comment_email);
				$user_comment_website = isset($_POST['user_comment_website']) ? stripslashes($_POST['user_comment_website']) : "";
				$user_comment_website = mysql_real_escape_string($user_comment_website);
				$user_comment_text = isset($_POST['user_comment']) ? stripslashes($_POST['user_comment']) : "";
				$user_comment_text = htmlspecialchars($user_comment_text);
				$user_comment_test = mysql_real_escape_string($user_comment_text);
				
				$action = isset($_GET['action']);
				
				if(!get_magic_quotes_gpc())
				{
					$user_comment_text = addslashes($user_comment_text);
				}
				
				mysql_select_db($db, $con);
				$create_comment_table = "CREATE TABLE $comment_table
				(
					Number int NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(Number),
					Name varchar(30) NOT NULL,
					Email varchar(50) NOT NULL,
					Website varchar(60) NOT NULL,
					Comment longtext NOT NULL,
					Timestamp NOT NULL,
					Post_Title varchar(255) NOT NULL,
					Comment_Number int NOT NULL
				)";
				
				$insert_comment = "INSERT INTO $comment_table
				(
					Name,
					Email,
					Website,
					Comment,
					Timestamp,
					Post_Title,
					Comment_Number
				)
				VALUES
				(
					'$user_comment_name',
					'$user_comment_email',
					'$user_comment_website',
					'$user_comment_text',
					'$timestamp',
					'$title',
					'$comment_number'
				)";
				
				$pattern_std =  "#[\/\,\.\\\<\>\?\;\'\:\"\[\]\{\}]#";
				$pattern_email = "#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$#";
				$pattern_name = "#[^A-z\s]#";
				$pattern_message = "#[\/\\\<\>\:\"\[\]\{\}]#";
				
				function validate($user_comment_name, $user_comment_email, $user_comment_text, $pattern_std, $pattern_email, $pattern_name, $pattern_message)
					{
						if(strlen($user_comment_name) == 0 || $user_comment_name == "" || preg_match($pattern_name, "$user_comment_name"))
						{
						die("You forgot to enter your first name.");
						header("Location: ".$_SERVER["PHP_SELF"]);
						}
						else if(strlen($user_comment_email) == 0 || $user_comment_email == "" || !preg_match($pattern_email, "$user_comment_email"))
						{
						die("You forgot to enter your email address.");
						}
						else if($user_comment_website != "")
						{
							if(preg_match($pattern_message, "$user_comment_website"))
							{
							die("You didn't correctly enter your website. Only letters, numbers, '.', '?', ',', and apostrophies are allowed.");
							}
						}
						else if(strlen($user_comment_text) == 0 || $user_comment_text == "" || preg_match($pattern_message, "$user_comment_text"))
						{
						die("You didn't correctly enter your comment. Only letters, numbers, '.', '?', ',', and apostrophies are allowed.");
						}
					return true;

					}
					
				function get_num($comment_table, $db, $con, $title)
					{
						mysql_select_db($db, $con);
						$sql = "SELECT Comment_Number FROM $comment_table WHERE Post_Title = '$title' ORDER BY Comment_Number DESC LIMIT 0,1";
						$result = mysql_query($sql);
						//echo "Result: " . $result . "<br />";
						if($result == FALSE)
						{
							$num = 1;
						}
						if($result != FALSE)
						{
							$arr = mysql_fetch_array($result);
							//echo "Mysql Fetch Array: " . $arr . "<br />";
							$num = $arr['Comment_Number'] + 1;
							//echo "Num: " . $num . "<br />";
						}
						return $num;
					}
				
				function comment_table_exists($comment_table, $db)
					{
					//retrives the whole list of tables from database
					$sql = "SHOW tables FROM $db";
					$tables_check = mysql_query($sql);
					//cycles through the list checking each entry
					while (list($temp) = mysql_fetch_array($tables_check))
						{
						if ($temp == $comment_table)
							{
							return true;
							}
						}
						
					return false;
					}
				
				if($action == "add_comment")
					{
						//executing table existance function
						if(!comment_table_exists($comment_table, $db))
							{
							mysql_query($create_comment_table, $con) or die("Could not create table:" . mysql_error());
							}
						if(validate($user_comment_name, $user_comment_email, $user_comment_text, $pattern_std, $pattern_email, $pattern_name, $pattern_message))
							{
						//executing insert new post
						mysql_query($insert_comment, $con) or die("Could not complete insertion:" . mysql_error());
						header("Location: ".$_SERVER["PHP_SELF"]);
							}
						else
							{
								die("Your formatting was incorrect and your comment was not submitted.");
							}
					}
					
				mysql_close();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/index_files/format.css" />
	<link rel="icon" type="png" href="/index_files/images/favicon.ico" />
	<title>SZ /posts</title>
<script type="text/javascript">

	var illegalName = /[^A-z0-9\s]/;
	var illegalText = /[^A-z0-9?.,\s]/;
	var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

function valid(add_comment)
{
	if(document.forms['add_comment'].user_comment_name.value.length == 0 || illegalName.test(document.forms['add_comment'].user_comment_name.value))
	{
	alert("You didn't correctly enter your name.")
	return false;
	}
	else if(document.forms['add_comment'].user_comment_email.value.length == 0 || !pattern.test(document.forms['add_comment'].user_comment_email.value))
	{
	alert("You didn't correctly enter your email address.")
	return false;
	}
	else if(document.forms['add_comment'].user_comment.value.length == 0 || illegalText.test(document.forms['add_comment'].user_comment.value))
	{
	alert("You didn't correctly enter your comment. Only letters, numbers, '.', '?', ',', and apostrophies are allowed. ")
	return false;
	}
}

</script>
</head>

<body>

<div id="wrapper">
		<div id="header" >
			<!--Name of my blog-->
			<a href="/"><h1 id="head">SZ /post</h1></a>
		</div>
		
			<!-- Including navigation file -->
			<?php 
			$path = "/home2/whackand/public_html/blog/index_files/links";
			set_include_path($path);
			include("nav.php"); 
			?>

		<?php
		ini_set('display_errors',1);
		error_reporting(E_ALL|E_STRICT);
		
			$con = mysql_connect("localhost", "whackand_szblog", "Goose") or die("Could not connect.");
			$db = "whackand_szblog";
			$table = "b_entries";
			
			$title = stripslashes("ARCE 650 Campus Drawings");
			$title = htmlspecialchars_decode($title);
			$no_space_title = str_replace(" ", "", $title);
			
			mysql_select_db($db, $con);
			$sql = "SELECT * FROM $table WHERE title = '$title'";
			$query = mysql_query($sql);
			$arr = mysql_fetch_array($query);
			
			$entry = stripslashes($arr['entry']);
			$entry = htmlspecialchars_decode($entry);
			
			$time = date("F d Y", $arr['timestamp']);
			
			mysql_close();
		?>
		<div id="content">
			<p>
				<div id="title"><strong><?php echo $title; ?></strong></div>
				<div id="date"><?php echo $time; ?></div>
					<br />
					<br />
				<div id="entry"><?php echo $entry; ?></div>
					<br />
					<br />
			</p>
		</div>
<!-- Comments -->
		<div id="comments">
			<div id="add_comment">
				<h3>Get involved in the Discussion</h3>
				<hr id="line1" />
				<h4>Add a New Comment</h4>
				<form name="add_comment" enctype="multipart/form-data" method="post" onsubmit="return valid()" action="<?php echo $no_space_title; ?>.php?action=add_comment">
					<label> Name: </label><input type="text" name="user_comment_name" /><div id="comment_notes">
					(Required)</div> 
					<br />
					<br />
					<label> Email: </label> <input type="text" name="user_comment_email" /><div id="comment_notes">(Required but will NOT be displayed in the comment section.)</div> <!-- MUST NOTE THAT THIS WILL NOT BE DISPLAYED -->
					<br />
					<br />
					<label> Website: </label> <input type="text" name="user_comment_website" /> <div id="comment_notes">(Not required and will NOT be displayed in the comment section.)</div>
					<br />
					<br />
					<label> Comment: </label> <div id="comment_notes">(Required)</div> 
					<br />
					<textarea rows="7" cols="35" name="user_comment"></textarea>
					<br />
					<br />
					<input type="submit" value="Comment" />
				</form>
				<hr id="line2" />
			</div>
		
			<div id="dis_comments">
				<?php
					$con = mysql_connect("localhost", "whackand_szblog", "Goose");
					$db = "whackand_szblog";
					$comment_table = "comments";
					
					$title = stripslashes("ARCE 650 Campus Drawings");
					$title = htmlspecialchars_decode($title);
					
					mysql_select_db($db, $con);
					$sql = "SELECT * FROM $comment_table WHERE Post_Title = '$title' ORDER BY Comment_Number DESC";
					$query = mysql_query($sql);
					
					while( $row = mysql_fetch_array($query))
					{
						$name = htmlspecialchars_decode($row['Name']);
						$name = addslashes($name);
						$comment = htmlspecialchars_decode($row['Comment']);
						$comment = addslashes($comment);
						$date = date("F d Y H:i", $row['Timestamp']);
						
				?>
						
						<div id="individual_comment">
								<div id="display_name">
									<p><?php echo $name; ?> said ....</p>
								</div>
								<div id="display_comment">
									<?php echo $comment; ?>
								</div>
						</div>			
						<div id="comment_date">
							<?php echo $date; ?>
						</div>
						<hr id="line2"/>
				<?php
				}
				
				mysql_close();
				?>
			</div>
		</div>
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
