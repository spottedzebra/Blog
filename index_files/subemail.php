<!DOCTYPE>

<?php
/* script to stop flooding
	log ip address and time.
	if ip address and time(day) > 5)
	{
		block ip address;
	}
*/
error_reporting(E_ALL);
//pattern variables
$pattern_std =  "#[\/\,\.\\\<\>\?\;\'\:\"\[\]\{\}]#";
$pattern_email = "#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$#";
$pattern_name = "#[^A-z\s]#";
$pattern_message = "#[^A-z\?\.\,\:\;\'\"\!\@\#\$\%\^\&\*\(\)\-\s]#";

//form and mail variables
$Fname = htmlspecialchars($_POST['First_name']);
$Lname = htmlspecialchars($_POST['Last_name']);
$Email = htmlspecialchars($_POST['Email']);
$Subject = htmlspecialchars($_POST['Email_subject']);
$Message = htmlspecialchars($_POST['Comments']);
$to = 'mwhit74@whackandblite.com';
$message = 	"First name: " . $Fname . 
							"\n" . "Last name: " . $Lname . 
							"\n" . "Message (blog): " . $Message;
							
function validate($Fname, $Lname, $Email, $Subject, $Message, $pattern_std, $pattern_email, $pattern_name, $pattern_message)
{
	if(strlen($Fname) == 0 || $Fname == "" || preg_match($pattern_name, "$Fname"))
	{
	die("You forgot to enter your first name.");
	}
	else if(strlen($Lname) == 0 || $Lname == "" || preg_match($pattern_name, "$Lname"))
	{
	die("You forgot to enter your last name.");
	}
	else if(strlen($Email) == 0 || $Email == "" || !preg_match($pattern_email, "$Email"))
	{
	die("You forgot to enter your email address.");
	}
	else if(strlen($Subject) == 0 || $Subject == "" || preg_match($pattern_name, "$Subject"))
	{
	die("You forgot to enter your email subject");
	}
	else if(strlen($Message) == 0 || $Message == "" || preg_match($pattern_message, "$Message"))
	{
	die("You forgot to your message or you entered illegal characters, please try again.");
	}
return true;

}
//display after message sent and forward to home page

		if(validate($Fname, $Lname, $Email, $Subject, $Message, $pattern_std, $pattern_email, $pattern_name, $pattern_message))
		{
			//sending email			
				mail($to, $Subject, $message, "From: $Email");
			
			//display after submission
				echo "Thanks for the email!";
		}
		?>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="refresh" content="2; URL= /"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title> SZ </title>
	</head>

	<body>
		
	</body>
</html>
