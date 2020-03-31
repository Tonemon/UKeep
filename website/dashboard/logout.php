<?php 
	session_start();
	include 'essentials.php';

	// Set information for logout process & last login
	$date = date('Y-m-d h:i:s');
	$id = $_SESSION['session_keep_id'];
	$sql = "UPDATE UKeepMAIN.users SET lastlogin='$date' WHERE id='$id'";
	mysql_query($sql) or die("Could not set your lastlogin time. Please try to logout again later.");
	
	// set user status to offline
	$setoffline = "UPDATE UKeepMAIN.users SET status='offline' WHERE id='$id'";
	mysql_query($setoffline) or die("Could not set your status to offline. Please try to logout again later.");

	// destroy session and redirect to message 'logged out successfully'
	session_destroy();
	header('location:../login?success=1');
?>