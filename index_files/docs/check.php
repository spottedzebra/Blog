<?php

/*ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);*/

function validate()
{	
	$email = $_POST['email'];
	$pattern_email = "#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$#";
	if(strlen($email) == 0 || $email == "" || !preg_match($pattern_email, "$email"))
	{
	die("You forgot to enter your email address.");
	}
	return true;
}

function search()
{	
	if(validate())
	{
		$email = $_POST['email'];
		$file_path = "LulzSecDelivers.txt";
		$str = file_get_contents($file_path);
		if(strpos($str, $email) > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
}

if(isset($_GET['action']) && $_GET['action'] == 'search')
{

	if(search())
	{
		die("You should probably change your passwords A.S.A.P.");
	}
	else
	{
		die("Your email is not on the list.");
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title> SZ /check</title>
	</head>

	<body>
		
	</body>
</html>