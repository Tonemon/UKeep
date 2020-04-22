<?php 
	session_start();
	include 'essentials.php';

	// Set last login date and status to offline
	$date = date('Y-m-d h:i:s');
	$id = $_SESSION['session_keep_id'];
	$logoutsql = "UPDATE UKeepMAIN.users SET lastlogin='$date', status='offline' WHERE id='$id'";
	mysql_query($logoutsql) or die("Could not log you out properly. Please try logging out again later.");

	// destroy session and redirect to message 'logged out successfully'
	session_destroy();
	header('location:../login?success=1');
?>