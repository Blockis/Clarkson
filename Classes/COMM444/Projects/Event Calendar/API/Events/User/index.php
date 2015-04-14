<?php



/*************************************
* JSON Encoding						 *
* Outputs User Events To JSON Format *
*************************************/

if($_GET['User']==NULL)
	//die('You Must Supply A User ID!');	
	echo "You must supply a user ID!";
$user=$_GET['User'];

// Set Headers
header('Content-Type: application/json');
include('../../../globals.php');
// Connect To The Database
//$con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);
// Check Error-Free
if (!$conn)
{ echo "Unable to connect to database.\n"; }
// Query For ALL Events
$r = $conn->prepare("SELECT * FROM Event WHERE user_ID='$user'");
$r->execute();
//$result = mysqli_query($con, "SELECT * FROM Event WHERE user_ID='$user'") or die('Couldn\'t Query The Database!');
// Get Number Of Events
//$num_events = mysqli_num_rows($result);
//$num_events = $r->fetch(PDO::FETCH_ASSOC);
//echo "# Of Events: " . $num_events . "\n";
//print_r($num_events);

$current_event = 1;
$num_events = $r->rowCount();
// Echo [
echo "[";
// Loop Through Each EVENT
//while ($row = mysqli_fetch_assoc($result)) {
while($row = $r->fetch(PDO::FETCH_ASSOC)){
	echo json_encode($row);
	if($current_event < $num_events){
			echo ",";
	}
	$current_event++;
}
// Echo ]
echo "]";

// Close The Connection
//mysqli_close($con);

?>
