			<?php	
				$con = mysql_connect("localhost", "whackand_szblog", "Goose");
				$db = "whackand_szblog";
				$comment_table = "comments";
				
				ini_set('display_errors',1);
				error_reporting(E_ALL|E_STRICT);
				
				mysql_select_db($db, $con);
				$create_comment_table = "CREATE TABLE $comment_table
				(
					Number int NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(Number),
					Name varchar(30) NOT NULL,
					Email varchar(50) NOT NULL,
					Website varchar(60) NOT NULL,
					Comment longtext NOT NULL,
					Timestamp int(20) NOT NULL,
					Post_Title varchar(255) NOT NULL,
					Comment_Number int NOT NULL
				)";
				
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
					
				if(!comment_table_exists($comment_table, $db))
				{
					mysql_query($create_comment_table) or die("Could not create table, " . mysql_error());
				}
				
				mysql_close();
				?>