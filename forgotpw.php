<?php
//Forgot password
session_start();

$host = "localhost";
$username = "root";
$password = "";
$db = "brs";
$pw = "";

$con = mysqli_connect($host, $username, $password, $db);
if ($con->connect_error): 
    die ("Could not connect to db: " . $con->connect_error); 
endif;


?>


<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href = "login.css"/>
	<title>Forgot Password</title>
	<script type="text/javascript" language="javascript">

	function badName(){
		alert("Username not found!");
	}

	function badPW(){
		alert("Please enter a password!");
	}

	function badSS(){
		alert("Incorrect social security number!");
	}
	</script>
</head>
<body>
	<h1>Forgot Password</h1>
	<form action="forgotpw.php"
		  method="POST">
<table>
	<tr>
		<td>
			<b>User Name</b>
		</td>
		<td>
			<input type="uname" name="uname"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Last 4 Digits of SS#</b>
		</td>
		<td>
			<input type="password" name="ss"/>
		</td>
	<tr>
		<td>
			<b>New Password</b>
		</td>
		<td>
			<input type="password" name="password"/>
		</td>
	</tr>
</table>
	<br/>
	<input type="submit" class = 'button' value="Enter"/>
	<a href="login.php?lo=1" class = 'button'>BACK</a>
</form>
	<?php
		if (!isset($_POST["uname"]) || !isset($_POST["password"]))
		{
			//all of the crap hasn't been entered yet so just don't do anything
		}
		else
		{
			if(strlen($_POST["password"]) > 0){
				$sql = "SELECT * FROM USERS WHERE username = '".$_POST["uname"]."'";
				$result = mysqli_query($con, $sql);
				$num_rows = $result->num_rows;
				if($num_rows > 0){
					while($row = mysqli_fetch_array($result)){
						$ss = $row['SOC'];
					}
					if(strcmp($ss, $_POST["ss"]) == 0){
						$update = "UPDATE Users SET password = '".$_POST["password"]."' WHERE username = '".$_POST["uname"]."'";
						mysqli_query($con, $update);
						header("Location: login.php");
					}
					else{
						echo "<script> badSS() </script>";
					}
				}
				else{
					echo "<script> badName() </script>";
				}
			}
			else{
				echo "<script> badPW() </script>";
			}

		}
	?>
</body>
</html>