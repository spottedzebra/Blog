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

<script type="text/javascript" >
var illegalName = /[^A-z0-9\s]/;
var illegalText = /[^A-z0-9?.,:;!@#'"$%^&*\(\)\-\s]/;
var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

function valid(email_form)
{
	if(document.forms['email_form'].First_name.value.length == 0 || illegalName.test(document.forms['email_form'].First_name.value))
	{
	alert("You didn't correctly enter your first name.")
	return false;
	}
	else if(document.forms['email_form'].Last_name.value.length == 0 || illegalName.test(document.forms['email_form'].Last_name.value))
	{
	alert("You didn't correctly enter your last name.")
	return false;
	}
	else if(document.forms['email_form'].Email.value.length == 0 || !pattern.test(document.forms['email_form'].Email.value))
	{
	alert("You didn't correctly enter your email address.")
	return false;
	}
	else if(document.forms['email_form'].Email_subject.value.length == 0 || illegalName.test(document.forms['email_form'].Email_subject.value))
	{
	alert("You didn't correctly enter your email subject. Only spaces, commas, periods, and question marks are allowed.")
	return false;
	}
	else if(document.forms['email_form'].Comments.value.length == 0 || illegalText.test(document.forms['email_form'].Comments.value))
	{
	alert("You didn't correctly enter your comment. Only letters, numbers, and these symbols {.,:;'\"!@#$%^&*()-} are allowed. ")
	return false;
	}
}


</script>
</head>

<body>

<div id="wrapper">
		<div id="header" >
			<!--Name of my blog-->
			<a href="/"><h1 id="head">SZ /contact</h1></a>
		</div>
		
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>

			<div id="content">
				<h3>Contact</h3>
				<form name="email_form" method="post" onsubmit="return valid()" action="/index_files/subemail.php" enctype="multipart/form-data">
				<label name="fname">First Name:</label><input name="First_name" type="text"/>
				
				<br />
				<br />
				
				<label name="lname">Last Name:</label><input name="Last_name" type="text" />
				
				<br />
				<br />
				
				<label name="email">Email:</label><input name="Email" type="email" value="username@example.com onFocus="this.value=''"" />
				
				<br />
				<br />
				
				<label name="subject">Email Subject:</label><input name="Email_subject" type="text" />
					
				<br />
				<br />
				
				Comments: 
				<br />
				<textarea cols="40" rows="10" name="Comments" value="Add your request or comment here."></textarea>
				
				<br />
				<br />
				
				<input type="submit" value="Submit Email" />
				</form>
			</div>
<div class="clearfooter"></div>
</div>
<div id="footer">
		<p> This site is meant to be open source, take whatever you want. The source will be uploaded <a href="#">here</a> eventually. All I ask is that you don't claim work as your own and if you make money off it I wouldn't mind some, I'm a broke college student.
<br />

<br />
Giving credit where credit is due this footer came from this <a href="http://fortysevenmedia.com/blog/archives/making_your_footer_stay_put_with_css/" target="_blank">tutorial</a>. It is a very nifty design and works very well with my site.
<br />
<br />
</p></div>
</body>
</html>