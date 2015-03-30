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
			<title>Add Event</title>
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
			<form action="eventAdded.php" method="post">
				Add Your Event:

				Date:<br>
				<select name=month>
					<option value="01"> January </option>
					<option value="02"> February </option>
					<option value="03"> March </option>
					<option value="04"> April </option>
					<option value="05"> May </option>
					<option value="06"> June </option>
					<option value="07"> July </option>
					<option value="08"> August </option>
					<option value="09"> September </option>
					<option value="10"> October </option>
					<option value="11"> November </option>
					<option value="12"> December </option>
				</select>
				<select name=day>
					<option value="01"> 1 </option>
					<option value="02"> 2 </option>
					<option value="03"> 3 </option>
					<option value="04"> 4 </option>
					<option value="05"> 5 </option>
					<option value="06"> 6 </option>
					<option value="07"> 7 </option>
					<option value="08"> 8 </option>
					<option value="09"> 9 </option>
					<option value="10"> 10 </option>
					<option value="11"> 11 </option>
					<option value="12"> 12 </option>
					<option value="13"> 13 </option>
					<option value="14"> 14 </option>
					<option value="15"> 15 </option>
					<option value="16"> 16 </option>
					<option value="17"> 17 </option>
					<option value="18"> 18 </option>
					<option value="19"> 19 </option>
					<option value="20"> 20 </option>
					<option value="21"> 21 </option>
					<option value="22"> 22 </option>
					<option value="23"> 23 </option>
					<option value="24"> 24 </option>
					<option value="25"> 25 </option>
					<option value="26"> 26 </option>
					<option value="27"> 27 </option>
					<option value="28"> 28 </option>
					<option value="29"> 29 </option>
					<option value="30"> 30 </option>
					<option value="31"> 31 </option>
				</select>
				<select name=year>
					<option value="2014"> 2014 </option>
					<option value="2015"> 2015 </option>
					<option value="2016"> 2016 </option>
					<option value="2017"> 2017 </option>
					<option value="2018"> 2018 </option>
					<option value="2019"> 2019 </option>
					<option value="2020"> 2020 </option>
				</select>
				<br>
				Time:<br>
				<select name=hour>
					<option value="00"> Midnight </option>
					<option value="01"> 1am </option>
					<option value="02"> 2am </option>
					<option value="03"> 3am </option>
					<option value="04"> 4am </option>
					<option value="05"> 5am </option>
					<option value="06"> 6am </option>
					<option value="07"> 7am </option>
					<option value="08"> 8am </option>
					<option value="09"> 9am </option>
					<option value="10"> 10am </option>
					<option value="11"> 11am </option>
					<option value="12"> Noon </option>
					<option value="13"> 1pm </option>
					<option value="14"> 2pm </option>
					<option value="15"> 3pm </option>	
					<option value="16"> 4pm </option>
					<option value="17"> 5pm </option>
					<option value="18"> 6pm </option>
					<option value="19"> 7pm </option>
					<option value="20"> 8pm </option>
					<option value="21"> 9pm </option>	
					<option value="22"> 10pm </option>
					<option value="23"> 11pm </option>
				</select>
				<select name=minute>
					<option value="00"> :00 </option>
					<option value="15"> :15 </option>
					<option value="30"> :30 </option>
					<option value="45"> :45 </option>
				</select>
				<br>
				Description:<br>
				<textarea rows="4" cols="50" name="description" maxlength="500"></textarea>
				<br>
				<input type="submit" value="Add Event!">
			</form>
		</div>
	</body>
</html>




