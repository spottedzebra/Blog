<?php
	$con = mysql_connect("localhost", "whackand_szblog", "Goose");
	$db = "whackand_szblog";
	$table = "b_entries";
	


if(!is_dir("/home2/whackand/public_html/blog/index_files/posts/"))
{
	mkdir("/home2/whackand/public_html/blog/index_files/posts/");
}

if(is_dir("/home2/whackand/public_html/blog/index_files/posts"))
{
	mysql_select_db($db, $con);
	$sql = "SELECT * FROM $table ORDER BY Number";
	$query = mysql_query($sql);
	
	while($row = mysql_fetch_array($query))
	{
		$title = stripslashes($row['title']);
		$title = htmlspecialchars_decode($title);
		$no_space_title = str_replace(" ", "", $title);
		
		$tpl_path = "/home2/whackand/public_html/blog/index_files/templates/";
		$tpl_file = "post_template.php";
		$placeholder = "{title}";
		$save_path = "/home2/whackand/public_html/blog/index_files/posts/";
		
		$tpl = file_get_contents($tpl_path.$tpl_file);
		
		$new_post_page = str_replace($placeholder, $title, $tpl);
		
		$new_post_page_name = $no_space_title . ".php";
		
		$fp = fopen($save_path.$new_post_page_name, "w");
		fwrite($fp, $new_post_page);
		fclose($fp);	
	}
}

?>