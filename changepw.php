<?php
//Change password
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
	<title>Change Password</title>
	<script type="text/javascript" language="javascript">

	function badName(){
		alert("Username not found!");
	}

	function badPW(){
		alert("Incorrect password!");
	}

	function badNEW(){
		alert("Please enter a new password!");
	}
	</script>
</head>
<body>
	<h1>Change Password</h1>
	<form action="changepw.php"
		  method="POST">
<table>
	<tr>
		<td>
			<b>User Name</b>
		</td>
		<td>
			<input type="text" name="uname"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Old Password</b>
		</td>
		<td>
			<input type="password" name="password"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>New Password</b>
		</td>
		<td>
			<input type="password" name="newpw"/>
		</td>
	</tr>
</table>
			<input type="submit" class = 'button' value="Enter"/>
			<a href="login.php?lo=1" class = 'button'>BACK</a>
</form>
	<?php
		if (!isset($_POST["password"]) || !isset($_POST["newpw"]))
		{
		}
		else if(strlen($_POST["newpw"]) < 1){
			echo '<script> badNEW() </script>';
		}
		else
		{
			$sql = "SELECT * FROM Users WHERE username = '".$_POST["uname"]."'";
			$result = mysqli_query($con, $sql);
			$num_rows = $result->num_rows;
			if($num_rows > 0){
				while($row = mysqli_fetch_array($result)){
					$pw = $row['password'];
				}
				if(strcmp($pw, $_POST["password"]) == 0){
					$update = "UPDATE Users SET password = '".$_POST["newpw"]."' WHERE username = '".$_POST["uname"]."'";
					mysqli_query($con, $update);
					header("Location: login.php");
				}
				else{
					echo "<script> badPW() </script>";
				}
			}
			else{
				echo "<script> badName() </script>";
			}
		}
		mysqli_close($con);
	?>


</body>
</html>