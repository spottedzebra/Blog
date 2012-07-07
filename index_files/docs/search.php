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
		$result = "You should probably change your passwords A.S.A.P.";
	}
	else
	{
		$result = "Your email is not on the list.";
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
<html>
<head>
<script type="text/javascript">
function search()
{
	var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	if(document.forms['search_txt'].email.value.length == 0 || !pattern.test(document.forms['search_txt'].email.value))
	{
	alert("Your email address is not formatted correctly");
	return false;
	}
	
	return true;
}
</script>
<title> SZ /check </title>
</head>

<body>
	<p> Enter your email in the box and click the 'Check' button. A message will show up under the box informing you as to whether or not your email address shows up on the list.
	</p>
	<form name="search_txt" onSubmit="search()" action="search.php?action=search" enctype="multipart/form-data" method="post">
		<label> Email: </label><input type="text" name="email" onFocus="this.value=''" value="username@example.com"/>
		<input type="submit" value="Check" />
	</form>
	<br />
	<?php echo $result; ?>
</body>
</head>