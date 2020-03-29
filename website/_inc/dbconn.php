<?php
	$serverName = "localhost";
	$db_username = "UKeepUser";
	$db_password = "UKeepPassword";
	mysql_connect($serverName,$db_username,$db_password)/* or die('the website is down for maintainance')*/;
	// no mysql_select_db($dbname), because two databases are connected to the same user (UNotesDAT & UNotesMAIN)

	// New salt location (variable in one place only)
	$salt = "@3hRziJK**&KO&2D";
?>