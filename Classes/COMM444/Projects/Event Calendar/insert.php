<html>
<body>

<?php
$con=mysqli_connect("localhost","ee462","ee462pw","assess");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$firstname = mysqli_real_escape_string($_POST['firstname']);
$lastname = mysqli_real_escape_string($_POST['lastname']);
$age = mysqli_real_escape_string($_POST['age']);

$sql="INSERT INTO Persons (FirstName, LastName, Age)
VALUES ($firstname, $lastname, $age)";

if (!mysqli_query($con,$sql))
{
  die('Error: ' . mysqli_error($con));
}
echo "1 record added";

mysqli_close($con);
?>

</html>
</body>
