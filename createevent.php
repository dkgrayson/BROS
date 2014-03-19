<?php
//Create event
session_start();
if (!isset($_SESSION["name"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

	///////CONNECT TO DATABASE HERE///////

$user = $_SESSION["name"]; //this is the owner of the event

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
	<title>Create New Event</title>
	<link rel = "stylesheet" type = "text/css" href = "login.css"/>
	<script type="text/javascript" language="javascript"></script>
	<script src="http://maps.googleapis.com/maps/api/js?&sensor=false"></script>
	<script>


	function badInsert(){
		alert("Venue, Date, Time, and Maximum Players must contain a value.  Please make sure you have entered a value for every option!");
	}

	function initialize()
	{
		var mapProp = 
		{
  			center:new google.maps.LatLng(40.438847,-79.947193),
  			zoom:11,
  			mapTypeId:google.maps.MapTypeId.ROADMAP
  		};

  		var map= new google.maps.Map(document.getElementById("googleMap"),mapProp);

	  	var oak=new google.maps.Marker({position: new google.maps.LatLng(40.437018,-79.958893)});
	  	oak.setMap(map);
	  	var bloom = new google.maps.Marker({position: new google.maps.LatLng(40.464581,-79.945133)});
	  	bloom.setMap(map); 
	    var shady = new google.maps.Marker({position: new google.maps.LatLng(40.455503,-79.927439)});
	    shady.setMap(map);
	    var squirrel = new google.maps.Marker({position: new google.maps.LatLng(40.438259,-79.923233)});
	    squirrel.setMap(map);
	    var monroe = new google.maps.Marker({position: new google.maps.LatLng(40.425781,-79.789978)});
	    monroe.setMap(map);  


		var Oakland = new google.maps.InfoWindow({content:'<div style="color:#0000FF"> OAKLAND '}); 
	  	var Bloomfield = new google.maps.InfoWindow({content:'<div style="color:#0000FF"> BLOOMFIELD'});
	  	var Shadyside = new google.maps.InfoWindow({content:'<div style="color:#0000FF"> SHADYSIDE'});
	  	var SquirrelHill = new google.maps.InfoWindow({content:'<div style="color:#0000FF"> SQURREL HILL'});
	 	var Monroeville = new google.maps.InfoWindow({content:'<div style="color:#0000FF"> MONROEVILLE'});

	  	google.maps.event.addListener(oak, 'click', function() {Oakland.open(map,oak)});
	  	google.maps.event.addListener(bloom, 'click', function() {Bloomfield.open(map,bloom)}); 
	    google.maps.event.addListener(shady, 'click', function() {Shadyside.open(map,shady)}); 
	    google.maps.event.addListener(squirrel, 'click', function() {SquirrelHill.open(map,squirrel)});
	    google.maps.event.addListener(monroe, 'click', function() {Monroeville.open(map,monroe)});

	}

	google.maps.event.addDomListener(window, 'load', initialize);

	</script>


</head>
<div id="googleMap" style="width:500px; height:380px; float:right;"></div>
<body>

	<h1>Create New Event</h1>
	<form action="createevent.php"
		method="POST">

<table>
	<tr>
		<td>
			<b>City<b>
		</td>
		<td>
			<select name = "city">
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
			<b>Venue</b>
		</td>
		<td>
			<input type="text" name="location"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Date & Time</b>
		</td>
		<td>
			<input type="datetime-local" name="date"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Maximum Players</b>
		</td>
		<td>
			<input type="number" name="max"/>
		</td>
	</tr>
	<tr>
		<td>
			<b>Sport</b>
		</td>
		<td>
			<select name = "sport">
  			<option value="basketball">Basketball</option>
  			<option value="football">Football</option>
  			<option value="soccer">Soccer</option>
			</select>
		</td>
	</tr>
</table>
	<br/>
	<input type="submit" class = 'button' value="Enter"/>
	<a href="profile.php" class = 'button'>Back</a>
	<a href="login.php?lo=1" class = 'button'>Log Out</a>
</form>
	
	<?php
		if (!isset($_POST["location"]) || !isset($_POST["max"]) || !isset($_POST["date"]))
		{

		}
		else if (strlen($_POST["location"]) < 1 || $_POST["max"] < 1 || strlen($_POST["date"]) < 1)
		{
			echo "<script> badInsert() </script>";
		}
		else
		{
			
			$a = $_POST["city"];
			$b = $_POST["location"];
			$c = $_POST["date"];
			$d = $_POST["max"];
			$d--;
			$e = $_POST["sport"];

			$q = "'$a','$b','$c','$d','$e','$user'";

			$sql = "INSERT INTO EVENTS(city, location, date, max, sport, owner) VALUES (".$q.")";
			echo mysqli_error();
			mysqli_query($con, $sql);
			$newly_inserted = mysqli_insert_id($con);
			$w = "'$newly_inserted','$user'";
			$sql2 = "INSERT INTO ROSTER(event, user) VALUES (".$w.")";
			mysqli_query($con, $sql2);
			$result = $con->error;
			if($result){
				mysqli_close($con);
			}
			header("Location: viewevents.php");
		}
	?>
	<br/>
	<br/>

</body>
</html>