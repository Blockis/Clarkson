<?php
	include ('globals.php');
	session_start();
	if($_SESSION['user']==NULL) // If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: login.php");
	$user=$_SESSION['user']; // Set's the logged in user for the page
	$error="";
	if(isset($_POST['submit'])){
		if($_POST['newPassword']==$_POST['confirmNewPassword'] && $_POST['newPassword']!="" && $_POST['currentPassword']!=""){
			//$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_DB);
			
			/* check connection */
			if (!$conn) {
				printf("Unable to connect at this time.\n");
				exit();
			}
			//$checkUser = $conn->prepare("SELECT * FROM User WHERE user_name='$user' AND password='$currentPassword';");
			//$checkUser->execute();
			//$rows = $checkUser->fetch(PDO::FETCH_NUM);
			//$queryUserCheck="SELECT * FROM User WHERE user_name='$user' AND password='$currentPassword';";
			//if($rows > 0){
				$password=$_POST['newPassword'];
				$query = $conn->prepare("UPDATE User SET password='$password' WHERE user_ID=" . $_SESSION['uid'] . ";");
				
				$query->execute();
				//$query = "UPDATE User SET password='$password' WHERE user_ID=" . $_SESSION['uid'] . ";";
				
				//$result=mysqli_query($link,$query);
				
				if(!$query) // Check to see if there were any errors with inserting
					$error="An error has occurred while trying to update your password. Please try again.";
				else{
					$error="Password changed!";
					//mysqli_free_result($result);
				}
			//}
		} // closing if password fields
		else
			$error="New passwords do NOT match.";
	} // closing submit button
?>
<html>
	<head>
		<head>
			<title>Settings</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
	</head>
	<body>
		<div id="container">
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
			<font color="red"><?php echo $error; ?></font>
		</form>
		</div>
	</body>
</html>




