<?php
//LOGIN PAGE
	session_start();
	if (isset($_GET["lo"]) && $_GET["lo"] == 1) //User has logged out, clear data
	{
		session_unset();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href = "login.css"/>
	<title>BACKROW SPORTS</title>
	<script type="text/javascript" language="javascript">

	function badName(){
		alert("Username Not Found!");
	}

	function badPW(){
		alert("Incorrect Password!");
	}

	</script>
</head>
<body>
<br/><center>
<img src="brs2.png" alt="logo" height="200" width="400"> </center>
<center>
	<div style="in-line block" float="right">
	<form action="redirect.php"
		  method="POST">

	<opt><b>User Name</b><opt>
	<input type="text" name="name"/>
	<br/>
	<opt><b>Password&nbsp;&nbsp;</b></opt>
	<input type="password" name="password"/>
	<br/>
	<input class = 'button' type="submit" value="Login"/>
	<br><br><br><br>
	<a href='forgotpw.php' class='button'>Forgot Password</a>
	<a href='changepw.php' class='button'>Change Password</a>
	<a href='register.php' class='button'>Register New Profile</a>


</div></center>
<?php
		if (!isset($_GET["cm"]))
		{	
		}
		elseif ($_GET["cm"] == 2) //Unknown user
		{
			echo '<script> badName() </script>';
		}
		elseif ($_GET["cm"] == 3) //Incorrect pw
		{
			echo '<script> badPW() </script>';
		}
?>
		</form>
</body>
</html>