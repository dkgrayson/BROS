<?php
//REGISTER A NEW ACCOUNT

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
	<script type="text/javascript" language="javascript">

	function badName(){
		alert("Username already taken!");
	}
	function badInsert(){
		alert("Username, password, and social security fields may not be empty.  Social security number must be exactly 4 digits.");
	}
	function badSS(){
		alert("Please enter the correct social security number.  Someone has already claimed the social security number you entered");
	}

	</script>
	<title>Register New Profile</title>
</head>
<body>
	<h1>Register New Profile</h1>
	<form action="register.php"
		  method="POST"
		  enctype="multipart/form-data">
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
			<b>Password</b>
		</td>
		<td>
			<input type="password" name="password"/>
		</td>
	</tr>
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
  			<option value="oakland">Oakland</option>
  			<option value="bloomfield">Bloomfield</option>
  			<option value="shadyside">Shadyside</option>
  			<option value="squirrel">Squirrel Hill</option>
  			<option value="monroeville">Monroeville</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<b>Last 4 Digits of SS#</b>
		</td>
		<td>
			<input type='password' name='ss'/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Upload Profile Picture</b>
		</td>
		<td>
			<input type = 'file' id='file' name='file'/>
		</td>
	</tr>
</table>
			<b>Please Select Any Sports You Are Interested In Playing<br>
			<input type='checkbox' name='football' value='foot'/>Football
			<input type='checkbox' name='soccer' value='soccer'/>Soccer
			<input type='checkbox' name='basketball' value='basket'/>Basketball
		<br/>
		<input type="submit" class='button' value="Enter"/>
		<a href="login.php?lo=1" class = 'button'>Back</a>
</form>
	<?php
		if (!isset($_POST["uname"]) || !isset($_POST["password"]) || !isset($_POST["ss"]))
		{
			
		}
		else if (strlen($_POST["uname"]) < 1 || strlen($_POST["password"]) < 1 || strlen($_POST["ss"]) != 4){
			echo "<script> badInsert() </script>";
		}
		else
		{	
			$g = "";
			if(isset($_POST["soccer"])){
				$g = $g."1";
			}
			else{
				$g = $g."0";
			}
			if(isset($_POST["basketball"])){
				$g = $g."1";
			}
			else{
				$g = $g."0";
			}if(isset($_POST["football"])){
				$g = $g."1";
			}
			else{
				$g = $g."0";
			}

			$a = $_POST["uname"];
			$b = $_POST["password"];
			$c = $_POST["location"];
			$d = $_POST["fname"];
			$e = $_POST["lname"];
			$f = $_POST["ss"];
			$h = "pics/".$_FILES["file"]["name"];

			$q = "'$a','$b','$c','$d','$e','$f','$g', '$h'";

			$sql = "INSERT INTO USERS(username, password, location, FName, LName, soc, sports, pic) VALUES (".$q.")";
			echo mysql_error();
			mysqli_query($con, $sql);
			$result = $con->error;

			if(strcmp($result, "Duplicate entry '".$_POST["uname"]."' for key 'username'")==0){
				echo '<script> badName() </script>';
			}
			else if(strcmp($result, "Duplicate entry '".$_POST["ss"]."' for key 'SOC'")==0){
				echo '<script> badSS() </script>';
			}
			else{
				mysqli_close($con);
			  	move_uploaded_file($_FILES["file"]["tmp_name"], "pics/" . $_FILES["file"]["name"]);
			    $_SESSION["name"]=$_POST["uname"];
				header("Location: profile.php"); //go to profile
			}
		}
	?>

</body>
</html>