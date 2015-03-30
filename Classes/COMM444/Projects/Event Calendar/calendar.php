<?php
	include ('globals.php');
	error_reporting(E_ERROR | E_PARSE);
	$con1=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_DB);
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	session_start();
	if($_SESSION['user']==NULL)									// If user is trying to access a logged in dependent page- Redirect to login page
		header("Location: login.php");
	$user=$_SESSION['user'];									// Set's the logged in user for the page
	//bool date_default_timezone_set ( 'EST' )
	$currentmonth = date('n');
	$currentyear = date('Y');
	if($_SESSION['month']==NULL){
		$_SESSION['month']=date('n');
	}
	if($_SESSION['year']==NULL){
		$_SESSION['year']=date('Y');
	}
	if(isset($_POST['LastMonth'])){
		if($_SESSION['month']-1 == 0){ 
			--$_SESSION['year'];
		}
	$_SESSION['month'] = ($_SESSION['month']-1 > 0) ? --$_SESSION['month'] : 12;

	}
	if(isset($_POST['NextMonth'])){
		if ($_SESSION['month']+1 == 13){
			++$_SESSION['year'];
		}
		$_SESSION['month'] = ($_SESSION['month']+1 < 13) ? ++$_SESSION['month'] : 1;
	}
	if(isset($_POST['Today'])){
		$_SESSION['year'] = $currentyear;
		$_SESSION['month'] = $currentmonth;
	}
	ini_set('error_reporting', E_ALL|E_STRICT);
	ini_set('display_errors', 1);
?>
<html>
	<head>
		<head>
			<title>Calendar</title>
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
				table.calendar		{ border-left:1px solid #999; }
				tr.calendar-row	{  }
				td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
				td.calendar-day:hover	{ background:#eceff5; }
				td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
				td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
				div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
				/* shared */
				td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
			</style>
		</head>
	</head>
	<body>
		<div style="width: 800px; height: auto; border: 1px solid #D3D3D3; margin: auto; padding: 10px;">
			<b><h3><?php echo $title; ?> | Calendar</h3></b><div style="float: right;">Welcome back, <?php echo $user; ?>!</div>	
			<br />
			<?php
			include ('navigation.php');
			error_reporting(E_ERROR | E_PARSE);
			$months = array('January','February','March','April','May','June','July','August','September','October','November','December');
			$years = array('2010','2011','2012','2013','2014','2015','2016','2017','2018','2019','2020');
			//sets initial value of SESSION variables to current month and year
			
			//increments or decrements year based on user input
			
			//print calendar based on SESSION variables
			echo '<h3>'. $months[$_SESSION['month']-1] .' '. $_SESSION['year'].'</h3>';
			echo draw_calendar($_SESSION['month'],$_SESSION['year'],$con1);
			//buttons to move around
			echo '<form method="post">
				<br />
				<input type="submit" name="LastMonth" value="<< Last Month" />
				<input type="submit" name="NextMonth" value="Next Month >>" />
				<input type="submit" name="Today" value="Today" />
				</form>
			';
			/* date settings */
			//$month = (int) ($_POST['month'] ? $_POST['month'] : date('m'));
			//$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));
			$month = empty($_GET['month']) ? date('n') : $_GET['month'];
			$year = empty($_GET['year']) ? date('Y') : $_GET['year'];
			/* select month control */
			$select_month_control = '<select name="month" id="month">';
			for($x = 1; $x <= 12; $x++) {
				$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
			}
			$select_month_control.= '</select>';
			/* select year control */
			$year_range = 7;
			$select_year_control = '<select name="year" id="year">';
			for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
				$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
			}
			$select_year_control.= '</select>';
			/* bringing the controls together */
			//$controls = '<form method="get">'.$select_month_control.$select_year_control.' <input type="submit" name="submit" value="Go" />      '.$previous_month_link.'     '.$next_month_link.' </form>';
			/* draws a calendar */
			function draw_calendar($month,$year,$con1){
				/* draw table */
				$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
				/* table headings */
				$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
				/* days and weeks vars now ... */
				$running_day = date('w',mktime(0,0,0,$month,1,$year));
				$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
				$days_in_this_week = 1;
				$day_counter = 0;
				$dates_array = array();
				/* row for week one */
				$calendar.= '<tr class="calendar-row">';
				/* print "blank" days until the first of the current week */
				for($x = 0; $x < $running_day; $x++):
					$calendar.= '<td class="calendar-day-np"> </td>';
					$days_in_this_week++;
				endfor;
				/* keep going with days.... */
				for($list_day = 1; $list_day <= $days_in_month; $list_day++):
					$calendar.= '<td class="calendar-day">';
						/* add in the day number */
						$calendar.= '<div class="day-number">'.$list_day.'</div>';

						/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
						//$calendar.= str_repeat('<p>DAY</p>',1);
						
						/* MySQL Query For ALL Events On This Day */

						
						if($_SESSION['month'] < 10){
							if($list_day < 10){
								$event_sql="SELECT * FROM Event WHERE user_ID=" . $_SESSION['uid'] . " AND date LIKE '" . $_SESSION['year'] . "-0" . $_SESSION['month'] . "-0" . $list_day . " %'";
							} else {
								$event_sql="SELECT * FROM Event WHERE user_ID=" . $_SESSION['uid'] . " AND date LIKE '" . $_SESSION['year'] . "-0" . $_SESSION['month'] . "-" . $list_day . " %'";
							}
						} else {
							if($list_day < 10){
								$event_sql="SELECT * FROM Event WHERE user_ID=" . $_SESSION['uid'] . " AND date LIKE '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "-0" . $list_day . " %'";
							} else {
								$event_sql="SELECT * FROM Event WHERE user_ID=" . $_SESSION['uid'] . " AND date LIKE '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "-" . $list_day . " %'";
							}
						}
						$day_events = mysqli_query($con1, $event_sql) or die('Couldn\'t Query The Database!');
						
						while ($row = mysqli_fetch_assoc($day_events)) {
							$tmp_time = explode(" ", $row['date']);
							$time=$tmp_time[1]; // So now we have the ##:## time!
							$calendar.='<p><b>'.$time.'</b><br /><i><span style="padding-left: 8px;">'.$row['description'].'</span></i></p>';
						}
						
					$calendar.= '</td>';
					if($running_day == 6):
						$calendar.= '</tr>';
						if(($day_counter+1) != $days_in_month):
							$calendar.= '<tr class="calendar-row">';
						endif;
						$running_day = -1;
						$days_in_this_week = 0;
					endif;
					$days_in_this_week++; $running_day++; $day_counter++;
				endfor;
				/* finish the rest of the days in the week */
				if($days_in_this_week < 8):
					for($x = 1; $x <= (8 - $days_in_this_week); $x++):
						$calendar.= '<td class="calendar-day-np"> </td>';
					endfor;
				endif;
				/* final row */
				$calendar.= '</tr>';	
				/* end the table */
				$calendar.= '</table>';
				/* all done, return result */
				return $calendar;
			}
			?>
		</div>
	</body>
</html>
