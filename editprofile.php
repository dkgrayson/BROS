<?php
//Edit Profile
session_start();
if (!isset($_SESSION["name"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

	///////CONNECT TO DATABASE HERE///////


$host = "localhost";
$username = "root";
$password = "";
$db = "brs";
$pw = "";

$con = mysqli_connect($host, $username, $password, $db);
if ($con->connect_error): 
    die ("Could not connect to db: " . $con->connect_error); 
endif;

$sql = "SELECT * FROM USERS WHERE username = '".$_SESSION["name"]."'";
$result = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error); 
$account = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel = "stylesheet" type = "text/css" href = "login.css"/>
	<script type="text/javascript" language="javascript">

	</script>
</head>
<body>
	<h1>Edit Profile</h1>
	<br/>
	<form action="update.php"
		  method="POST"
		  enctype="multipart/form-data">
<table>
	<tr>
		<td>
			<b>First Name</b>
		</td>
		<td>
			<input type="text" name="fname"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Last Name</b>
		</td>
		<td>
			<input type="text" name="lname"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Location(City)</b>
		</td>
		<td>
			<select name = "location">
			<?php 
				//This is logic to make sure the select option is automatically
				//set to the person's location
				if(strcmp($account["location"], "oakland")==0){
					echo "<option selected value='oakland'>Oakland</option>";
				}
				else{
					echo "<option value='oakland'>Oakland</option>";
				}

				if(strcmp($account["location"], "bloomfield")==0){
					echo "<option selected value='bloomfield'>Bloomfield</option>";
				}
				else{
					echo "<option value='bloomfield'>Bloomfield</option>";
				}

				if(strcmp($account["location"], "shadyside")==0){
					echo "<option selected value='shadyside'>Shadyside</option>";
				}
				else{
					echo "<option value='shadyside'>Shadyside</option>";
				}

				if(strcmp($account["location"], "squirrel")==0){
					echo "<option selected value='squirrel'>Squirrel Hill</option>";
				}
				else{
					echo "<option value='squirrel'>Squirrel Hill</option>";
				}

  				if(strcmp($account["location"], "monroeville")==0){
  					echo "<option selected value='monroeville'>Monroeville</option>";
				}
				else{
					echo "<option value='monroeville'>Monroeville</option>";
				}
  			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<b>Last 4 Digits of SS#</b>
		</td>
		<td>
			<input type="password" name="ss"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Change Profile Picture</b>
		</td>
		<td>
			<input type = 'file' id='file' name='file'/>
		</td>
	</tr>
</table>
	<b>Please Select Any Sports You Are Interested In Playing<br>
	<?php

	if(substr($account["sports"], 0, 1)==1){
		echo "<input checked type='checkbox' name='soccer' value='soccer'/>Soccer";
	}
	else{
		echo "<input type='checkbox' name='soccer' value='soccer'/>Soccer";
	}
	if(substr($account["sports"], 1, 1)==1){
		echo "<input checked type='checkbox' name='basketball' value='basket'/>Basketball";
	}
	else{
		echo "<input type='checkbox' name='basketball' value='basket'/>Basketball";
	}
	if(substr($account["sports"], 2, 2)==1){
		echo "<input checked type='checkbox' name='football' value='foot'/>Football";
	}
	else{
		echo "<input type='checkbox' name='football' value='foot'/>Football";
	}	
	mysqli_close($con);		
	?>
	<br/>
	<input type="submit" class='button' value="Update"/>
	<a href="profile.php" class = 'button'>Profile</a>
	<a href="login.php?lo=1" class = 'button'>Log Out</a>
	</form>
	
</body>
</html>