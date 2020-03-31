<?php
  $serverName = "localhost";
  $db_username = "UKeepUser";
  $db_password = "UKeepPassword";
  mysql_connect($serverName,$db_username,$db_password)/* or die('the website is down for maintainance')*/;
  // no mysql_select_db($dbname), because two databases are connected to the same user (UNotesDAT & UNotesMAIN)

  // New salt location (variable in one place only)
  $salt = "@3hRziJK**&KO&2D";
  // Essential Variables and information is stored here for quick retrieval
  // This file is always present in the header of a page

  $query_id = $_SESSION['session_keep_id'];

  $sql = "SELECT * FROM UKeepMAIN.users WHERE id='$query_id'";
  $result = mysql_query($sql) or die(mysql_error());
  $rws = mysql_fetch_array($result);
  
  $user_name = $rws[1]; // used for header (top right)
  $theme_color = $rws[10]; // used for page theme
  $user_code = $rws[8]; // used for storing personal information
  $user_acctype = $rws[9]; // used to allow people to access admin & support page or not

  // logged in account id & users name and surname
  #$user_id = $rws[0];
  
  #$userdat_username = $rws[11];
  #$userdat_lastlogin = $rws[9];
  #$userdat_accstatus = $rws[10];
  #$status = $rws[12];
                
  #$userdat_address = $rws[5];
  #$userdat_acctype = $rws[4];
  #$userdat_gender = $rws[2];
  #$userdat_mobile = $rws[6];
  #$userdat_email = $_SESSION['session_tasks_email'];
  #$userdat_dob = $rws[3];
        
  // checking for corrupted sessions
  if ($query_id = ""){ // often happends when user is deleted and still logged in or corrupted session
    session_destroy();
    header('location:../login?notice=1');

  } elseif ($rws[4] == "DISABLED"){ // accstatus: logs users out when account status is set to 'disabled' and they are still logged in
    $date = date('Y-m-d h:i:s');
    $exitsql = "UPDATE UKeepMAIN.users SET lastlogin='$date',status='offline' WHERE id='$query_id'"; // last login
    mysql_query($exitsql) or die("Could not set your lastlogin time & status. Please delete all your cookies and login again.");

    session_destroy();
    header('location:../login?error=3');
  } elseif ($rws[5] == "offline"){ // cookies cleared, but no official logout
    session_destroy();
    header('location:../login?error=2');
  }
?>