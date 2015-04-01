<?php
	include ('globals.php');
	$globalUsernameError="";
	$globalPassError="";
	$globalGeneralError="";
	if(isset($_POST['submit'])){
		if($_POST['accountName']){
			if($_POST['password']==$_POST['confirmPassword'] && $_POST['password']!=""){
				/* check connection */
				if (!$conn){
					printf("Connection to database failed.\n");
					exit();
				}
				
				$accountName = $_POST['accountName'];
				$result = $conn->prepare("SELECT * FROM User WHERE user_name=:Us3Rn4M3;");
				$result->bindParam(':Us3Rn4M3', $accountName);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				if($rows > 0){ // If we get any rows, the user exists already
					$globalGeneralError="This user already exists.  Please pick another username.\n";
				} else {
					$accountName = $_POST['accountName'];
					$password = $_POST['password'];
					// Syntax on binding param when INSERTing?
					//$insertUser->bindParam(':Pa55W0rD',$password);
					//$insertUser->bindParam(':Us3Rn4M3',$accountName);
					$insertUser = $conn->prepare("INSERT INTO User(user_ID,password,user_name) VALUES ('DEFAULT','$password','$accountName');");
					$insertUser->execute();
					// We need a check to see if user was actually inserted into the database.
					$globalUsernameError="";
					$globalPassError="";
					$uid = $conn->prepare("SELECT * FROM User;");
					$uid->execute();				
					$_SESSION['uid']=$uid->fetch(PDO::FETCH_NUM);
					$_SESSION['user']=$accountName;	// Set logged in user
					header("Location: home.php");	// redirects page
				} // closing else username didn't already exist
			} // closing if password fields
			else
				$globalPassError="Passwords do NOT match.";
		} // closing if account name
		else
			$globalUsernameError="Account name field has error(s)";
	} // closing submit button
?>
<html>
	<header>
		<title>Registration</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</header>
	<body>
		<div id="container">
		<b><h3><?php echo $title; ?> | Registration</h3></b>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<table> 
				<tr><th><i>Fill in all of the following fields: </i></th><th></th></tr> 
				<tr><td align="right"><font color="red"><?php echo $globalUsernameError;?></font></td></tr> 
				<tr><td>Username:</td><td><input type="text" name="accountName"></td></tr>
				<tr><td align="right"><font color="red"><?php echo $globalPassError;?></font></td></tr> 
				<tr><td>Password:</td><td><input type="password" name="password"></td></tr>
				<tr><td>Confirm Password:</td><td><input type="password" name="confirmPassword"></td></tr> 
				<tr><td></td><td><input type="submit" name="submit" value="Submit"></td></tr><tr><td align="right"><font color="red"><?php echo $globalGeneralError;?></font></td></tr> 
			</table> 
		</form>
		<br />	
		</div>
	</body>
</html>
