<?php
	include ('globals.php');
	session_start();
	if($_SESSION['user']==NULL)									// If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: login.php");
	$user=$_SESSION['user'];									// Set's the logged in user for the page
	$globalPassError="";
	if(isset($_POST['submit'])){
		if($_POST['newPassword']==$_POST['confirmNewPassword'] && $_POST['newPassword']!="" && $_POST['currentPassword']!=""){
			$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_DB);

			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$queryUserCheck="SELECT * FROM User WHERE user_name='$user' AND password='$currentPassword';";
			
			/*$resultUserCheck=mysqli_query($link,$queryUserCheck);
			if(mysql_num_rows($resultUserCheck)!=1){						// If result returns anything other than 0, user already exists
				$globalPassError="Your current password was wrong.\n";
				mysqli_free_result($resultUserCheck);
			}else{*/
				//mysqli_free_result($resultUserCheck);
				$password=$_POST['newPassword'];
				$query = "UPDATE User SET password='$password' WHERE user_ID=" . $_SESSION['uid'] . ";";
				
				//mysqli_query($con,"UPDATE Persons SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
				
				$result=mysqli_query($link,$query);
				
				//$result = mysql_query($query,$link);
				if(!$result)											// Check to see if there were any errors with inserting
					$globalPassError="An error has occurred while trying to update your password. Please try again.";
				else{
					$globalPassError="Password changed!";
					mysqli_free_result($result);
				}
			//} // closing else username didn't already exist
		} // closing if password fields
		else
			$globalPassError="New passwords do NOT match.";
	} // closing submit button
?>
<html>
	<head>
		<head>
			<title>Settings</title>
			<style>
				a,a:visited{
					color: #80D9FF;
					text-decoration: none;
				}
				a:hover{
					color: #00B2FF;
					text-decoration: none;
				}
				a:active{
					color: #00B2FF;
					text-decoration: none;
				}
			</style>
		</head>
	</head>
	<body>
		<div style="width: 500px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
			<b><h3><?php echo $title; ?> | Settings</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php include ('navigation.php'); ?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table>
					<tr><td>Current Password:</td>
					<td><input type="password" name="currentPassword" maxlength="50" size="30"></td>
					</tr>
					<tr><td>New Password:</td>
					<td><input type="password" name="newPassword" maxlength="50" size="30"></td>
					</tr>
					<tr><td>Confirm New Password:</td>
					<td><input type="password" name="confirmNewPassword" maxlength="50" size="30"></td>
					</tr>
					<tr><td><input type="submit" name="submit" value="Submit"></td></tr>
				</table>
			<font color="red"><?php echo $globalPassError; ?></font>
		</form>
		</div>
	</body>
</html>




