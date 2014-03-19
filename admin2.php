<?php
//View Events
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

$sql3 = sprintf("SELECT * FROM EVENTS WHERE date < '%s'", date('Y-m-d H:i:s'));
$result3 = mysqli_query($con, $sql3);
$deleted = array();
if($result3){
	while($row = mysqli_fetch_array($result3))
  	{
	  	array_push($deleted, $row['id']);
  	}
}
if($deleted){
	for($a=0;$a<sizeof($deleted);$a++){
		$sql2 = "DELETE FROM EVENTS WHERE id = $deleted[$a]";			//DELETE OLD EVENTS
		$sql4 = "DELETE FROM ROSTER WHERE EVENT = $deleted[$a]";
		$result2 = mysqli_query($con, $sql2);
		$result4 = mysqli_query($con, $sql4);
	}
}


$sql = "SELECT * FROM EVENTS";
$result = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
$num_rows = $result->num_rows;
$events = array();
for($a=0;$a<$num_rows;$a++)
{
   $events[$a] = $result->fetch_array();
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Remove Events</title>
	<link rel = "stylesheet" type = "text/css" href = "login.css"/>
</head>
<body>
	<h1>Remove Events</h1>
	<br/><br/>
		<table class='table'>
			<tr class='table'>
				<th class='table'>ID</th>
				<th class='table'>City</th>
				<th class='table'>Venue</th>
				<th class='table'>Date & Time</th>
				<th class='table'>Positions Remaining</th>
				<th class='table'>Sport</th>
				<th class='table'>Join Event</th>
			</tr>
			<?php
				for($i = 0; $i < $num_rows; $i++){
					$sql = "SELECT * FROM ROSTER WHERE user = '".$_SESSION["name"]."' AND event = '".$events[$i]["id"]."'";
					$result2 = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
					$num_rows2 = $result2->num_rows;
							echo "<tr class='table'><td class='table'>".$events[$i]["id"]."</td><td class='table'>".$events[$i]["city"]."</td>
							<td class='table'>".$events[$i]["location"]."</td><td class='table'>".$events[$i]["date"]."</td>
							<td class='table'>".$events[$i]["max"]."</td><td class='table'>".$events[$i]["sport"]."</td>
							<td class='table'><a href='admin2.php?id=".$events[$i]["id"]."' class = 'button'>Remove</a>
							</td></tr>";
				}
			
			?>
		</table>
			<br/><br/>
			<a href="profile.php" class = 'button'>Profile</a>
			<a href="login.php?lo=1" class = 'button'>Log Out</a>
			<?php
		if(isset($_GET["id"])){
			$sql = "DELETE FROM EVENTS WHERE id='".$_GET["id"]."'";
	   		$remove = mysqli_query($con, $sql) or die ("Invalid: ".$db->connect_error);
	   		$sql = "DELETE FROM ROSTER WHERE event='".$_GET["id"]."'";
	   		$remove = mysqli_query($con, $sql) or die ("Invalid: ".$db->connect_error);
	   		mysqli_close($con);
		}
	?>
</body>
</html>