<?php
	include ('globals.php');
	session_start();
	if($_SESSION['user']==NULL)									// If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: /login.php");
	$user=$_SESSION['user'];									// Set's the logged in user for the page
	if(isset($_POST['logout'])){
		session_unset($_SESSION['user']);
		session_destroy();
		header("Location: /login.php");
	}
	else if(isset($_POST['settings']))
		header("Location: /settings.php");
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
				ul {
				list-style: none;
				padding:0;
				margin:0;
				}

				li { 
					padding-left: 1em; 
					text-indent: -.7em;
				}

				li:before {
					content: "*  ";
					padding-top: 4px;
					color: #D3D3D3;
				}
			</style>
		</head>
	</head>
	<body>
		<div style="width: 500px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
			<b><h3><?php echo $title; ?> | Export</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php include ('navigation.php'); ?>
			<br />
			You may export events using our API in several ways;
			<br />
			<br />
			<ul>
				<li>All Events</li>
				<div style="font-size: small; text-align: center;"><i>This call will return every single event stored on the database in JSON format.</i></div>
				<div style="height: 18px; width: 300px; margin: auto; padding-top: 2px; text-align: center; background-color: #D3D3D3; font-size: small;">
					http://<?php echo $_SERVER['SERVER_ADDR']; ?>/API/Events/All
				</div>
				<br />
				<li>My Events</li>
				<div style="font-size: small; text-align: center;"><i>This call will return only your events in JSON format.</i></div>
				<div style="height: 18px; width: 300px; margin: auto; padding-top: 2px; text-align: center; background-color: #D3D3D3; font-size: small;">
					http://<?php echo $_SERVER['SERVER_ADDR']; ?>/API/Events/User/?User=<?php echo $_SESSION['uid']; ?>
				</div>
				<br />
			</ul>
		</div>
	</body>
</html>
