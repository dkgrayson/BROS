<?php
//THIS FILE REDIRECTS LOGIN SELECTIONS
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

$sql = "SELECT * FROM Users WHERE username = '".$_POST["name"]."'";
$result = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
$user_info = mysqli_fetch_assoc($result);



if (isset($user_info["username"]))
{
	$_SESSION["name"] = $user_info["username"]; //Remember the userID
	$uname = $_POST["name"];

	if(strcmp($_POST["password"], $user_info["password"]) == 0){
	header("Location: profile.php");
	mysqli_close($con);
	exit;
	}
	else{
	header("Location: login.php?cm=3"); //password was incorrect
	mysqli_close($con);
	exit;
	}
}
else{
	header("Location: login.php?cm=2"); //userID was not found
	mysqli_close($con);
	exit;
}

?>