<?php
	include ('globals.php');
	$error="";
	if(isset($_POST['login']))
	{
		if($_POST['accname']!=NULL)
		{
			if($_POST['accpass']!=NULL)
			{
				if(!$conn){
					$error = "Unable to connect at this time.\n";
				}
				else {
					$account = $_POST['accname'];
					$password = $_POST['accpass'];			
					// Prepare Query
					$result = $conn->prepare("SELECT * FROM User WHERE user_name=:Us3Rn4M3 AND password=:Pa55W0rD");
					$result->bindParam(':Us3Rn4M3', $account);
					$result->bindParam(':Pa55W0rD', $password);
					// Execute Query
					$result->execute();
					$rows = $result->fetch(PDO::FETCH_NUM);
					if($rows > 0){
						// GET THE USER_ID
						//$_SESSION['uid']=$row['user_ID'];
						$_SESSION['user']=$account;
						$_SESSION['month']=date('n');
						$_SESSION['year']=date('Y');
						header("Location: home.php");
					} // closing result query for authentication 
					else
					{
						$error = "Username or Password were not found in the system.<br>";
					} // closing result for query authentication invalid check
				} // closing successful connection to server
			} // closing accpass post
		} // closing accname post
	} // closing login button post
?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="container">
		<b><h3><?php echo $title; ?> | Login</h3></b>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<!-- TABLE LOGIN -->
			<table>
				<tr><td>Account Name:</td>
				<td><input type="text" name="accname" maxlength="50" size="30"></td>
				</tr>
				<tr><td>Account Password:</td>
				<td><input type="password" name="accpass" maxlength="50" size="30"></td>
				</tr>
				<tr><td><input type="submit" name="login" value="Login"></td></tr>
			</table>
			<font color="red"><?php echo $error; ?></font>
			<p>Not registered? <a href="register.php">Click here to sign up!</a></p>
		</form>
		</div>
	</body>
</html>

