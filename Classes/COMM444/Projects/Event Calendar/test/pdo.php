<html>
<body>
<?php

// Setup
$db_host = "localhost";
$db_name = "calendar";
$db_user = "comm444";
$db_password = "student";

// Create the PDO
$pdo = new PDO("mysql:dbname=$db_name;host=$db_host",$db_user,$db_password);
echo "Created new PHP Data Object.<br /><br />\n";

// Test connection
// NOTE: Typically use a try-catch here
echo "Connecting to Database using PDO... ";
if( $pdo ){
	echo "connected.<br /><br />\n";
}

// Iterate over User table
echo "Iterating over table 'User'";
echo "<pre>";
$query = "select * from User";
foreach( $pdo->query( $query ) as $data ){
	print_r( $data );
}
echo "</pre><br /><br />";

// Better syntax
// NOTE: Using bindParam prevents SQL-injections


// Using 'prepare' and 'execute'
$statement = $pdo->prepare( $query );
echo "<pre>";
if( $statement->execute() ){
	$rows = $statement->fetchAll( PDO::FETCH_OBJ );
	print_r( $rows );
}
echo "</pre>";

// More object stuff, like classes
echo "<br /><br />More: <a href='https://www.youtube.com/watch?v=VT62zRyCc2Y&index=3&list=PLyKBLKYqadGmD33SGjyk_MXrGAHVTVcqa'>Click</a>";
?>
</body>
</html>
