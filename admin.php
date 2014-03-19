
<?php
//Remove users
session_start();
if (!isset($_SESSION["name"]) || strcmp($_SESSION["name"], "admin")!=0) //Redirects to login page if trying to access this page before logging in
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

$sql = "SELECT * FROM USERS";
$result = mysqli_query($con, $sql) or die ("Invalid: " . $db->connect_error);
$num_rows = $result->num_rows;
$users = array();
for($a=0;$a<$num_rows;$a++)
{
   $users[$a] = $result->fetch_array();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel = "stylesheet" type = "text/css" href = "login.css"/>
    

    <title>Back Row Sports</title>
   </head>
   <body> 
   	<h1>Remove User</h1>
    <br/>
		<table class='table'>
			<tr class='table'>
				<th class='table'>First Name</th>
				<th class='table'>Last Name</th>
				<th class='table'>Location</th>
				<th class='table'>Remove User</th>
			</tr>
			
				<?php
					for($b=0;$b<$num_rows;$b++){
						if(strcmp($users[$b]["username"], $_SESSION["name"])!=0){
							echo "<tr class='table'>
									<td class='table'>".$users[$b]["FName"]."</td>
									<td class='table'>".$users[$b]["LName"]."</td>";
									if(strcmp($users[$b]["location"], "oakland")==0){
										echo "<td class='table'>Pittsburgh(Oakland)</td>";
									}
									else if(strcmp($users[$b]["location"], "bloomfield")==0){
										echo "<td class='table'>Pittsburgh(Bloomfield)</td>";
									}
									else if(strcmp($users[$b]["location"], "shadyside")==0){
										echo "<td class='table'>Pittsburgh(Shadyside)</td>";
									}
									else if(strcmp($users[$b]["location"], "squirrel")==0){
										echo "<td class='table'>Pittsburgh(Squirrel Hill)</td>";
									}
									else if(strcmp($users[$b]["location"], "monroeville")==0){
										echo "<td class='table'>Pittsburgh(Moneroeville)</td>";
									}
									else{
										echo "<td class='table'></td>";
									}
									echo "<td class='table'><a href='admin.php?id=".$users[$b]["id"]."' class = 'button'>Remove</a></td></tr>";
						}
					}
				?>
			
		</table>
	<br/><br/>
	<a href="profile.php" class = 'button'>Profile</a>
	<a href="login.php?lo=1" class = 'button'>Log Out</a>
	<?php
		if(isset($_GET["id"])){
			$sql = "DELETE FROM USERS WHERE id='".$_GET["id"]."'";
	   		$remove = mysqli_query($con, $sql) or die ("Invalid: ".$db->connect_error);
	   		mysqli_close($con);
		}
	?>
<body>
</body>
</html>