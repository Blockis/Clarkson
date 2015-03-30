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
			<title>Home</title>
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
				.linkButton { 
					 background: none;
					 border: none;
					 color: #0066ff;
					 text-decoration: underline;
					 cursor: pointer; 
				}
			</style>
		</head>
	</head>
	<body>
		<div style="width: 500px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
			<b><h3><?php echo $title; ?> | Home</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php include ('navigation.php'); ?>
			<br />
			Welcome to the <?php echo $title; ?> website!  This page serves as a hub for information regarding our calendar platform.
		</div>
	</body>
</html>
