<?php

include('../../../globals.php');

/*************************************
* JSON Encoding						 *
* Outputs User Events To JSON Format *
*************************************/

if($_GET['User']==NULL)
	die('You Must Supply A User ID!');	
$user=$_GET['User'];

// Set Headers
header('Content-Type: application/json');
// Connect To The Database
$con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);
// Check Error-Free
if (mysqli_connect_errno())
{ echo "Failed To Connect To MySQL: " . mysqli_connect_error(); }
// Query For ALL Events
$result = mysqli_query($con, "SELECT * FROM Event WHERE user_ID='$user'") or die('Couldn\'t Query The Database!');
// Get Number Of Events
$num_events = mysqli_num_rows($result);
$current_event = 1;
// Echo [
echo "[";
// Loop Through Each EVENT
while ($row = mysqli_fetch_assoc($result)) {
	echo json_encode($row);
	if($current_event < $num_events){
			echo ",";
	}
	$current_event++;
}
// Echo ]
echo "]";
// Close The Connection
mysqli_close($con);

?>