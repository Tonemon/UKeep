<?php 
if (isset($_REQUEST['loginbutton'])){
  include '_inc/dbconn.php';
  $login_user = $_REQUEST['login_user'];
    
  // password salting (for security reasons)
  $login_password = sha1($_REQUEST['login_password'].$salt);

  if (preg_match("/@/", $login_user)) { // check for @, if present:
    // getting usefull information for session creation (with email)
    $sqlquery = "SELECT username,email,password,accstatus,status,id,account,name,red_login FROM UKeepMAIN.users WHERE email='$login_user' AND password='$login_password'";
    $result = mysql_query($sqlquery) or die(mysql_error());
    $arr =  mysql_fetch_array($result);

  } else { // no @ present, so user is trying to login with username:
    // getting usefull information for session creation (with username)
    $sqlquery = "SELECT username,email,password,accstatus,status,id,account,name,red_login FROM UKeepMAIN.users WHERE username='$login_user' AND password='$login_password'";
    $result = mysql_query($sqlquery) or die(mysql_error());
    $arr =  mysql_fetch_array($result);
  }
    
  $db_username = $arr[0];
  $db_email = $arr[1];
  $db_pass = $arr[2];
	$db_accstatus = $arr[3];
	$status = $arr[4];
  $db_id = $arr[5];
  $db_acctype = $arr[6];
  $db_name = $arr[7];
  $redirect = $arr[8];

  if (($login_user == $db_username || $login_user == $db_email) && $login_password == $db_pass){ // check if submitted information is correct
    if ($db_accstatus == "ACTIVE"){ // check if account status is active or not
      session_start();
      $_SESSION['session_keep_start'] = 1;
      $_SESSION['session_keep_username'] = $db_user;
      $_SESSION['session_keep_email'] = $db_email;
      $_SESSION['session_keep_id'] = $db_id;
      $_SESSION['session_keep_name'] = $db_name;
        
      // setting user status to online
      $setonline = "UPDATE UKeepMAIN.users SET status='online' WHERE email='$db_email'";
      mysql_query($setonline) or die(mysql_error());
      header('location:/dashboard/'.$redirect);

    } else { // account status is set to disabled
      header('location:login?error=3');
    }

  } elseif ($db_id == NULL) { // user login information is incorrect
    // This query checks if user is permanently deleted (from 'usersclosed' table)
    $del_sql = "SELECT username FROM UKeepMAIN.usersclosed WHERE username='$login_user'";
    $del_result = mysql_query($del_sql) or die(mysql_error());
    $del_rws = mysql_fetch_array($del_result);

    if (isset($del_rws[0])){
      header('location:login?notice=1');
    } else {
      header('location:login?error=1');
    }     
  }
} else { // when no login button pressed, logged in and on login page --> redirect to home
  session_start(); // check if session active to redirect user from login page
  if (isset($_SESSION['session_keep_start'])) 
    header('location:/dashboard/');
}    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<link rel="shortcut icon" type="image/png" href="vendor/img/favicon.png"/>
  	<meta name="description" content="UTasks - Online planner and advanced note taking software.">
  	<meta name="author" content="UKeep Inc.">

  	<!-- Bootstrap core CSS-->
    <link href="vendor/css/bootstrap-login.min.css" rel="stylesheet" id="bootstrap-css">
  		
  	<!-- Custom fonts/styles for this template-->
  	<script src="https://kit.fontawesome.com/65d0b9813c.js" crossorigin="anonymous"></script>
  	<link href="vendor/css/sb-admin.css" rel="stylesheet">
  		
  	<title>Sign In or Register &bull; UKeep</title>
  </head>

  <body style="text-align: center; background-image:url(vendor/img/loginbackground.jpg); background-repeat:no-repeat; background-size:cover;">
    <div class="container">

      <!-- Login modal -->
      <div id="loginbox" style="margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
          <div class="panel-heading">
            <div class="panel-title">Sign In</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="#" onClick="$('#loginbox').hide(); $('#forgotbox').show()">Forgot password?</a></div>
          </div>

          <?php
            if ($_GET['success'] == "1") { // logged out
              echo "<div class='alert alert-success'> <i class='fas fa-check'></i> Successfully logged out.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['error'] == "1") { // wrong credentials
              echo "<div class='alert alert-danger'>
                <i class='fas fa-exclamation-triangle'></i> Wrong credentials. Please try again.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['error'] == "2") { // session expired
              echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle'></i> Your session is expired. <br>Please login again to continue.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['error'] == "3") { // account disabled
              echo "<div class='alert alert-danger'>
                <i class='fas fa-exclamation-triangle'></i> Account temporarily disabled. <br>Please <a href='http://ukeep.me/#contact'>contact us</a> for more information.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['notice'] == "1") { // account might be deleted or weird error
              echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle'></i> Your account might be permanently removed. <a href='#' id='pagesDropdown' role='button' data-toggle='modal' data-target='#infoModal' aria-haspopup='true' aria-expanded='false'>Read more</a>.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['notice'] == "2") { // account might be deleted or weird error
              echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle'></i> Please login first to continue.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } else { // normal login text (when no error shown)
              echo '<div style="padding-top:30px" class="panel-body">';
            }
          ?>

            <p style="margin-bottom: 20px;">Sign in to your account to continue to your personalized dashboard.</p>
            <form action="login" method="POST" name="login_form" class="form-horizontal">

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                <input id="login-username" type="text" class="form-control" name="login_user" value="" placeholder="username or email">                                        
              </div>
                                
              <div style="margin-bottom: 5px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-key"></i></span>
                <input id="login-password" type="password" class="form-control" name="login_password" placeholder="password">
              </div>
                             
              <div style="margin-bottom: 35px; margin-left: 50px;" class="input-group">
                <div class="checkbox">
                  <label><input id="login-remember" type="checkbox" name="remember" value="1"> Remember me</label>
                </div>
              </div>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <button class="btn btn-success" type="submit" name="loginbutton" style="width: 80px">Login</button>
                  <span style="margin-left:8px;">or</span>
                  <a id="btn-fblogin" href="#" class="btn btn-primary" style="margin-left:8px; width: 140px" onClick="$('#loginbox').hide(); $('#signupbox').show()">Create account</a>
                </div>
              </div>

            </form>     
          </div>                     
        </div>  
      </div>

      <!-- Register/account creation modal -->
      <div id="signupbox" style="display:none; margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="panel-title">Sign Up</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="#" onClick="$('#signupbox').hide(); $('#forgotbox').show()">Forgot password?</a></div>
          </div>  
          
          <div style="padding-top:30px" class="panel-body">
            <p style="margin-bottom: 20px;">Enter the following information to create an account.</p>
            <form id="signupform" class="form-horizontal" role="form">
                                
              <div id="signupalert" style="display:none" class="alert alert-danger">
                <p>Error:</p>
                <span></span>
              </div>

              <div class="form-group">
                <label for="firstname" class="col-md-3 control-label">Full Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="firstname" placeholder="First Name and Last name">
                </div>
              </div>
                                     
              <div class="form-group">
                <label for="email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="email" placeholder="Email Address">
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                  <input type="password" class="form-control" name="passwd" placeholder="Password">
                </div>
              </div>
                                    
              <div class="form-group">
                <label for="icode" class="col-md-3 control-label">Invitation Code</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="icode" placeholder="Invitation code">
                </div>
              </div>

              <div style="margin-bottom: 35px; margin-left: 50px;" class="input-group">
                <div class="checkbox">
                  <label><input id="login-remember" type="checkbox" name="remember" value="1"> I accept the <i>Terms and Conditions</i></label>
                </div>
              </div>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <a id="btn-login" href="#" class="btn btn-info" style="width: 140px">Create account</a>
                  <span style="margin-left:8px;">or</span>
                  <a id="btn-fblogin" href="#" class="btn btn-success" style="margin-left:8px; width: 80px" onclick="$('#signupbox').hide(); $('#loginbox').show()">Login</a>
                </div>
              </div>

            </form>
          </div>
        </div>      
      </div>

      <!-- Forgot password modal -->
      <div id="forgotbox" style="display:none; margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
          <div class="panel-heading">
            <div class="panel-title">Forgot Password</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="#"  onClick="$('#forgotbox').hide(); $('#loginbox').show()">Sign In</a></div>
          </div>     

          <div style="padding-top:30px" class="panel-body" >
            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
            <p style="margin-bottom: 20px;">Please enter the email address associated with your account below.</p>
            <form id="forgetform" class="form-horizontal" role="form">

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-paper-plane"></i></span>
                <input id="forget-email" type="email" class="form-control" name="username" value="" placeholder="Recovery Email Address">                                        
              </div>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <a id="btn-login" href="#" class="btn btn-success">Send Recovery Email</a>
                </div>
              </div>

            </form>     
          </div>                     
        </div>  
      </div>

    </div> <!-- /container -->

    <!-- Permanent deleted account Modal-->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-fw fa-trash-alt"></i> Permanently removed account</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">If you see this page, your account <b>might</b> be permantly removed.<br><br> If you don't recognize this activity or don't know how this happended, <b>please try logging in again</b>. If that doesn't work, <b>contact us</b> using the contact information on <a href='http://utasks.me/contact'>this page</a>.<br><br> Some reasons why your account <b>could</b> be deleted:
          <ol>
          	<li>Inactive for a long period (+2 years).</li>
          	<li>Unusual or fraudulent activity.</li>
          	<li>User was exploiting (premium) features.</li>
          </ol>
          Or other (unlisted) reasons.
          </div>
        </div>
      </div>
    </div>

    <!-- Credits footer on every page 
    <div style="position: fixed;bottom: 0;right: 15px;background-color: #fff;box-shadow: 0 4px 8px rgba(0,0,0,.05);border-radius: 3px 3px 0 0;font-size: 12px;padding: 5px 10px;">Created by Tony.</div>-->

    <!-- Core plugin JavaScript-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="vendor/js/jquery.easing.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  </body>
</html>