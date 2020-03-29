<?php

  $query_id = $_SESSION['session_keep_id'];

  include '../_inc/dbconn.php';
  $sql = "SELECT * FROM UKeepMAIN.users WHERE id='$query_id'";
  $result = mysql_query($sql) or die(mysql_error());
  $rws = mysql_fetch_array($result);
                
  // logged in account id & users name and surname
  #$user_id = $rws[0];
  $user_name = $rws[1];
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

  $theme_color = $rws[14];
  $user_code = $rws[16];
        
  // checking for corrupted sessions
  /*if ($userdat_email = ""){ // often happends when user is deleted and still logged in or corrupted session
    session_destroy();
    header('location:login?notice=1');

  } elseif ($rws[10] == "DISABLED"){ // logs users out when they are disabled and still logged in
    $date = date('Y-m-d h:i:s');
    $exitsql = "UPDATE UTasksMAIN.users SET lastlogin='$date' WHERE id='$userdat_id'"; // last login
    mysql_query($exitsql) or die("Could not set your lastlogin time.");
    $exitsql2 = "UPDATE UTasksMAIN.users SET status='offline' WHERE id='$userdat_id'"; // set user status to offline
    mysql_query($exitsql2) or die("Could not set your status to offline.");

    session_destroy();
    header('location:login?error=3');
  } elseif ($status == "offline"){ // cookies cleared, but no official logout
    session_destroy();
    header('location:login?error=2');
  } */
?>