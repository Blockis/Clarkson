<?php
	include ('globals.php');

	$globalUsernameError="";
	$globalPassError="";
	$globalGeneralError="";
	if(isset($_POST['submit'])){
		if($_POST['accountName']){
			if($_POST['password']==$_POST['confirmPassword'] && $_POST['password']!=""){
				$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_DB);

				/* check connection */
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				
				$accountName=$_POST['accountName'];
				$queryUserCheck="SELECT * FROM User WHERE user_name='$accountName';";
				
				$resultUserCheck=mysqli_query($link,$queryUserCheck);
				//if ($result = mysqli_query($link, "SELECT Name FROM City LIMIT 10")) {
				//	printf("Select returned %d rows.\n", mysqli_num_rows($result));

					/* free result set */
					//mysqli_free_result($result);
				//}
				
				//$resultUserCheck=mysql_query($queryUserCheck,$link);
				if(mysql_num_rows($resultUserCheck)>0){						// If result returns anything other than 0, user already exists
					$globalGeneralError="This user already exists. Please pick another.\n";
					mysqli_free_result($resultUserCheck);
				}else{
					mysqli_free_result($resultUserCheck);
					$deviceID=$_POST['deviceID'];
					$accountName=$_POST['accountName'];
					$password=$_POST['password'];
					$query = "INSERT INTO User(user_ID,password,user_name) VALUES ('DEFAULT','$password','$accountName');";
					
					$result=mysqli_query($link,$query);
					
					//$result = mysql_query($query,$link);
					if(!$result)											// Check to see if there were any errors with inserting
						$globalGeneralError="An error has occurred while trying to register. Please try again.";
					else{
						$globalUsernameError="";
						$globalPassError="";
						session_start();									// Start session, save login
						$_SESSION['uid']=mysqli_num_rows(mysqli_query($link, "SELECT * FROM User;"));
						$_SESSION['user']=$accountName;						// Set logged in user
						mysqli_free_result($result);
						header("Location: home.php");	// redirects page
					}
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
	</header>
	<body>
		<div style="width: 500px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
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
