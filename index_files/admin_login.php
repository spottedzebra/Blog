<?php
//checking if admin is logged in or not
session_start();
if($_SESSION['authenticate_admin'] == 1)
	{
	header("Location: new_entry.php");
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
<script type="text/javascript" language="javascript">
//Variable Declaration
	//character string to be tested against
var illegalChar = /[\/\,\.\\\<\>\?\;\'\:\"\[\]\{\}]/;

	//client side validation for speed
function validate_login(admin_login)
{
	if(document.admin_login.admin_username.value == "" || document.admin_login.admin_username.value.length == 0 || illegalChar.test(document.admin_login.admin_password.value))
	{
	alert("You forgot to enter a username or you have illegal characters.");
	return false;
	}
	else if(document.admin_login.admin_password.value == "" || document.admin_login.admin_password.value.length == 0 || illegalChar.test(document.admin_login.admin_password.value))
	{
	alert("You forgot to enter a password or you have illegal characters.");
	return false;
	}
}

</script>
</head>

<body>
<div id="wrapper" >
	<div id="header">
		<header>
			<!--Name of my blog-->
		<a href="/"><h1>SZ /login</h1></a>
		</header>
	</div>
	
	<div id="main">
	
		<!-- Including navigation file -->
		<?php 
		$path = "/home2/whackand/public_html/blog/index_files/links";
		set_include_path($path);
		include("nav.php"); 
		?>
		
		<div id="content">
			<!--Login form-->
			<div id="login">
				<h3>SZ Login</h3>
				<form name="admin_login" onSubmit="return validate_login()" action="admin_login_function.php" enctype="multipart/form-data" method="post">
					Username: <input type="text" name="admin_username" />
						<br />
					Password: <input type="password" name="admin_password" />
						<br />
						<br />
					<input type="submit" value="Login" />
				</form>
			</div>
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