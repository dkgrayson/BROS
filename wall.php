<?php
//Joins or leaves event for user
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

	
	$a = $_SESSION["FName"];
	$b = $_SESSION["LName"];
	$c = $_SESSION["id"];
	$d = date('Y-m-d H:i:s');
	$e = mysql_real_escape_string($_POST["comments"]);
	$q = "'$a','$b','$c','$d','$e'";

	$sql = "INSERT INTO WALL(fname, lname, rec, datetime, message) VALUES (".$q.")";
	$result = mysqli_query($con, $sql) or die ("Invalid: " . $con->error);;
	mysqli_close($con);
	if($_GET["sel"]==0){
		header("Location: profile.php"); //go to profile	
	}
	else{
		header("Location: theirprofile.php?id=".$_SESSION["id"]); //go to profile
	}
	
	
?>