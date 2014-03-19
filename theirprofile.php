<?php
//LOGIN PAGE
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

	$sql = "SELECT * FROM USERS WHERE id = '".$_GET["id"]."'";
	$result = mysqli_query($con, $sql)  or die ("Invalid: " . $db->connect_error);
	$account = mysqli_fetch_assoc($result);
	
	$_SESSION["id"] = $account["id"];
	$sql2 = "SELECT * FROM WALL WHERE rec = '".$account["id"]."'";
	$result2 = mysqli_query($con, $sql2) or die ("Invalid: " . $db->connect_error);
	$num_rows = $result2->num_rows;
	$messages = array();
	for($a=0;$a<$num_rows;$a++)
	{
	   $messages[$a] = $result2->fetch_array();
	}
	mysqli_close($con);

	
?>
<!DOCTYPE html>
<html>
<head>
    <link rel = "stylesheet" type = "text/css" href = "login.css"/>
    <title>Back Row Sports</title>
</head>
<body>

<?php
	if(strlen($account["FName"]) > 0){
		if(strlen($account["LName"]) > 0){
			echo "<center><h1>".$account["FName"]." ".$account["LName"]."'s Profile Page</h1></center>";
		}
		else{
			echo "<center><h1>".$account["FName"]."'s Profile Page</h1></center>";
		}
	}
	else{
		if(strlen($account["LName"]) > 0){
			echo "<center><h1>".$account["LName"]."'s Profile Page</h1></center>";
		}
		else{
			echo "<center><h1>Profile Page</h1></center>";
		}
	}
	
?>


<div class='divL'>
	<?php
		echo "<img src='".$account["pic"]."' align = 'left' height=50% width=100%/>"
	?>

	<opt>
		<br/><br/><br/>
	<strong>Sports Interests</strong>
	<br/>
		<?php

			if(substr($account["sports"], 0, 1)==1){
				echo "<img src='soccer.jpg' class = 'profileImage' align = 'center' height='20' width='35'/><br/>";
			}

			if(substr($account["sports"], 1, 1)==1){
				echo "<img src='basketball.jpg' class = 'profileImage' align = 'center' height='20' width='35'/><br/>";
			}

			if(substr($account["sports"], 2, 2)==1){
				echo "<img src='football.jpg' class = 'profileImage' align = 'center' height='20' width='35'/><br/>";
			}
	?>
	<br/><br/>
	<strong>Location:</strong>
	<br/>
	<?php
		if(strcmp($account["location"], "oakland")==0){
			echo "Pittsburgh(Oakland)";
		}
		if(strcmp($account["location"], "bloomfield")==0){
			echo "Pittsburgh(Bloomfield)";
		}
		if(strcmp($account["location"], "shadyside")==0){
			echo "Pittsburgh(Shadyside)";
		}
		if(strcmp($account["location"], "squirrel")==0){
			echo "Pittsburgh(Squirrel Hill)";
		}
		if(strcmp($account["location"], "monroeville")==0){
			echo "Pittsburgh(Moneroeville)";
		}
	?>
	</opt>
</div>


<div class='divR'>
	<div class='divR'><h2>Messages</h2>
		<form action="wall.php?sel=1"
		  	method="POST">	
			<textarea name='comments'  cols='45' rows='3'>Leave a message here!</textarea>
			<br/>
			<input type='Submit' class='button' value='Post Message'>
		</form>
		<br/><br/>
				<center>
		<table class='table'>
			<tr class='table'>
				<th class='table'>From</th>
				<th class='table'> </th>
				<th class='table'>Date</th>
				<th class='table'>Message</th>
			</tr>
			<?php
				for($b=$num_rows-1;$b>=0;$b--){
					echo "<tr class='table'><td class='table'>".$messages[$b]["fname"]."</td>
					<td class='table'>".$messages[$b]["lname"]."</td>
					<td class='table'>".$messages[$b]["datetime"]."</td>
					<td class='table'>".$messages[$b]["message"]."</td></tr>";
				}
			
			?>
		</table>
		</center>
	</div>
	
	<div class='divL'>
				<a href="profile.php" class = 'button'>Profile</a>
				<br/><br/><br/><br/>
				<a href="login.php?lo=1" class = 'button'>Log Out</a>
				<br/><br/><br/><br/>
	</div>
</div>
<img src="backrow_sports.jpg" class="specialImage" height="100" width="250"/>
</body>
</html>