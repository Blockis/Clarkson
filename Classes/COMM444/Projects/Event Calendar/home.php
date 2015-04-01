<?php
	include ('globals.php');
	session_start();
	if($_SESSION['user']==NULL) // Prevent un-authorized entry
		header("Location: login.php");
	$user=$_SESSION['user']; // Set's the logged in user
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
			<title>Home</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
	</head>
	<body>
		<div id="container">
			<b><h3><?php echo $title; ?> | Home</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php include ('navigation.php'); ?>
			<br />
			Welcome to the <?php echo $title; ?>!  This page serves as a hub for information regarding our calendar platform.
		</div>
	</body>
</html>

