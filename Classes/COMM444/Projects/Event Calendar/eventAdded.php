<?php
	include ('globals.php');
	session_start();
	if($_SESSION['user']==NULL)									// If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: login.php");
	$user=$_SESSION['user'];									// Set's the logged in user for the page
	if(isset($_POST['logout'])){
		session_unset($_SESSION['user']);
		session_destroy();
		header("Location: login.php");
	}
	else if(isset($_POST['settings']))
		header("Location: settings.php");
?>
<html>
	<head>
		<head>
			<title>Export</title>
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
			<b><h3><?php echo $title; ?> | Add Event</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php include ('navigation.php'); ?>
			<br />
			<?php

			$con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);
			// Check connection
			if (mysqli_connect_errno())
			{
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			$month=$_POST["month"];
			$day=$_POST["day"];
			$year=$_POST["year"];
			$hour=$_POST["hour"];
			$minute=$_POST["minute"];
			$description=$_POST['description'];
			$user_id=$_SESSION['uid'];
			$date=$year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':00';

			$sql="INSERT INTO Event (event_ID, user_ID, date, description) VALUES ('DEFAULT', '$user_id', '$date', '$description')";

			if (!mysqli_query($con,$sql))
			{
			  die('Error: ' . mysqli_error($con));
			} else {
				echo "Event Added!<br />";
			}

			mysqli_close($con);

			?>
		</div>
	</body>
</html>




