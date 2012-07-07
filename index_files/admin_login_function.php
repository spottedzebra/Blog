<?php

if($_SESSION['authenticate_admin'] == false)
{
$con = mysql_connect("localhost","whackand_szblog","Goose") or die('Could not connect to server' . mysql_error());
$db = "whackand_szblog";
mysql_select_db($db, $con);
//Variable Declaration
	//NOTE:admin_username and admin_password have character restrictions
	//retrieving username and password from post
$admin = mysql_real_escape_string($_POST['admin_username']);
$admin = htmlentities($admin);
$pass = mysql_real_escape_string($_POST['admin_password']);
$pass = htmlentities($pass);
$pattern =  "#[\/\,\.\\\<\>\?\;\'\:\"\[\]\{\}]#";

if(strlen($admin) == 0 || $admin == "" || preg_match($pattern,"$admin"))
	{
	die("You forgot to enter your user name or you included an illegal character. Please return to the previous page and try again.");
	}
else if(strlen($pass) == 0 || $pass == "" || preg_match($pattern,"$pass"))
	{
	die("You forgot to enter your password or included an illegal character. Please return to the previous page and try again.");
	}

if($admin == 'Screw' && $pass == 'ChapStick#1')
	{
	session_start();
	$_SESSION['authenticate_admin'] = 1;
	header("Location: new_entry.php");
	}
/*else if($admin == 'Alex' && $pass == 'Whitten')
	{
	session_start();
	$_SESSION['authenticate_admin'] = 1;
	header("Location: new_entry.php");
	}*/
else
	{
	session_start();
	$_SESSION['authenticate_admin'] = "";
	header("Location: /");
	}
}
?>