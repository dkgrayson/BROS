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

	$sql = "SELECT * FROM EVENTS";
	$result = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
	$num_rows = $result->num_rows;
	$events = array();
	for($a=0;$a<$num_rows;$a++)
	{
	   $events[$a] = $result->fetch_array();
	   $button = 'join'.$events[$a]["id"];
	   $button2 = 'leave'.$events[$a]["id"];
	   if(isset($_POST[$button]))
	   {
	   	$sql = "INSERT INTO ROSTER(event, user) VALUES ('".$events[$a]["id"]."', '".$_SESSION["name"]."')";
	   	$add = mysqli_query($con, $sql) or die ("Invalid: ".$db->connect_error);
	   	echo "JOINED";


	   	$sql2 = "UPDATE EVENTS SET max = max - 1 WHERE id = '".$events[$a]["id"]."'";
	   	$result2 = mysqli_query($con, $sql2);

	   	break;
	   }
	   if(isset($_POST[$button2]))
	   {
	   	$sql = "DELETE FROM ROSTER WHERE event='".$events[$a]["id"]."' AND user='".$_SESSION["name"]."'";
	   	$add = mysqli_query($con, $sql) or die ("Invalid: ".$db->connect_error);

	   	$sql2 = "UPDATE EVENTS SET max = max + 1 WHERE id = '".$events[$a]["id"]."'";
	   	$result2 = mysqli_query($con, $sql2);

	   	break;
	   }
	}

	mysqli_close($con);
	header("Location: viewevents.php"); //go to profile
	
?>