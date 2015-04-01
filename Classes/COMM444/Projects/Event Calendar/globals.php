<?php

/************************************
* MySQL Connection Info             *
************************************/
$title="Event Calendar";

$DB_HOST="localhost";
$DB_USER="comm444";
$DB_PASS="student";
$DB_NAME="calendar";

// Initialize Session
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Create Database Connection
$conn = NULL;
if($conn == NULL){
	$conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME",$DB_USER,$DB_PASS);
}

?>

