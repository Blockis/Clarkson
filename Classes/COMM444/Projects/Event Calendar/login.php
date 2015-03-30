<?php
	include ('globals.php');
	$globalGeneralErr="";
	if(isset($_POST['login']))
	{
		if($_POST['accname']!=NULL)
		{
			if($_POST['accpass']!=NULL)
			{
				$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
				if(!$link){
					$globalGeneralErr = "Unable to connect at this time.\n";
				}
				else {
					mysql_select_db($DB_DB) or die(mysql_error()); 
					$account = $_POST['accname'];
					$password = $_POST['accpass'];			
					$query_check_auth = "select * from User where user_name='$account' and password='$password';";
					$result_auth = mysql_query($query_check_auth,$link);
					if($result_auth!=NULL){
						$row = mysql_fetch_array($result_auth); 
						$num_results = mysql_num_rows($result_auth); 
						if($num_results>0) { 
							session_start();
							// GET THE USER_ID
							$_SESSION['uid']=$row['user_ID'];
							$_SESSION['user']=$account;
							$_SESSION['month']=date('n');
							$_SESSION['year']=date('Y');
							header("Location: /home.php");
						} // closing valid credentials
						else{
							$globalGeneralErr = "Invalid credentials<br>";
						} // closing invalid credentials
					} // closing result query for authentication 
					else
					{
						$globalGeneralErr = "Check for authentication was not successful<br>";
					} // closing result for query authentication invalid check
				} // closing successful connection to server
			} // closing accpass post
		} // closing accname post
	} // closing login button post
?>
<html>
	<head>
		<title>Login</title>
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
	<body>
		<div style="width: 500px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
		<b><h3><?php echo $title; ?> | Login</h3></b>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<!-- TABLE LOGIN -->
			<table>
				<tr><td>Account Name:</td>
				<td><input type="text" name="accname" maxlength="50" size="30"></td>
				</tr>
				<tr><td>Account Password:</td>
				<td><input type="password" name="accpass" maxlength="50" size="30"></td>
				</tr>
				<tr><td><input type="submit" name="login" value="Login"></td></tr>
			</table>
			<font color="red"><?php echo $globalGeneralErr; ?></font>
			<p>Not registered? <a href="register.php">Click here to sign up!</a></p>
		</form>
		</div>
	</body>
</html>

