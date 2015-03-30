<?php
	session_start();
	if($_SESSION['user']==NULL)									// If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: login.php");
	$user=$_SESSION['user'];									// Set's the logged in user for the page
	session_unset($_SESSION['user']);
	session_destroy();
	header("Location: login.php");
?>
