<?php
session_start();
if (!isset($_SESSION["name"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

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

if(isset($_POST["fname"]) && strlen($_POST["fname"]) > 0){
	$sql = "UPDATE USERS SET FName = '".$_POST["fname"]."' WHERE username = '".$_SESSION["name"]."'";
	$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
}
if(isset($_POST["lname"]) && strlen($_POST["lname"]) > 0){
	$sql = "UPDATE USERS SET LName = '".$_POST["lname"]."' WHERE username = '".$_SESSION["name"]."'";
	$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
}
if(isset($_POST["ss"]) && strlen($_POST["ss"]) == 4){
	$sql = "UPDATE USERS SET SOC = '".$_POST["ss"]."' WHERE username = '".$_SESSION["name"]."'";
	$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
}
if(strlen($_FILES["file"]["name"]) > 0){
	$h = "pics/".$_FILES["file"]["name"];
	$sql = "UPDATE USERS SET pic = '".$h."' WHERE username = '".$_SESSION["name"]."'";
	$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
	move_uploaded_file($_FILES["file"]["tmp_name"], "pics/" . $_FILES["file"]["name"]);
}
$sql = "UPDATE USERS SET location = '".$_POST["location"]."' WHERE username = '".$_SESSION["name"]."'";
$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);

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

$sql = "UPDATE USERS SET sports = '".$g."' WHERE username = '".$_SESSION["name"]."'";
$update = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
mysqli_close($con);
header("Location: profile.php");

?>