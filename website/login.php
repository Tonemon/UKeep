<?php 
if (isset($_REQUEST['loginbutton'])){
  include '_inc/dbconn.php';

  $login_user = $_REQUEST['login_user'];  
  $login_password = sha1($_REQUEST['login_password'].$salt); // password salting (for security reasons)

  if (preg_match("/@/", $login_user)) { // check for @, if present, probably user is logging in using email
    $sqlquery = "SELECT id,email,username,accstatus,password,redirect_url FROM UKeepMAIN.users WHERE email='$login_user' AND password='$login_password'";
    $result = mysql_query($sqlquery) or die(mysql_error());
    $arr =  mysql_fetch_array($result);

  } else { // no @ present, user is probably trying to login with username
    $sqlquery = "SELECT id,email,username,accstatus,password,redirect_url FROM UKeepMAIN.users WHERE username='$login_user' AND password='$login_password'";
    $result = mysql_query($sqlquery) or die(mysql_error());
    $arr =  mysql_fetch_array($result);
  }
  
  // setting important variables which were received from database
    $db_id = $arr[0];
    $db_email = $arr[1];
    $db_username = $arr[2];
    $db_accstatus = $arr[3];
    $db_pass = $arr[4];
    $redirect = $arr[5];

  if (($login_user == $db_username || $login_user == $db_email) && $login_password == $db_pass){ // submitted information is correct
    if ($db_accstatus == "ACTIVE"){ // check if account status is active or not
      session_start();
      $_SESSION['session_keep_start'] = 1;
      $_SESSION['session_keep_id'] = $db_id;
        
      // setting user status to online and redirecting to their set homepage
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

    if (isset($del_rws[0])){ // account found in 'deleted users' table, so probably permanently removed
      header('location:login?notice=1');
    } else { // not found in 'deleted users' table, so credentials are probably wrong
      header('location:login?error=1');
    }     
  }
} else { // when no login button pressed, but user is logged in and visits the login page --> redirect to home
  session_start();
  if (isset($_SESSION['session_keep_start'])) 
    header('location:/dashboard/');
}    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	
    <?php include 'dashboard/addons/metadata.php'; ?>
  	<title>Sign In or Register &bull; UKeep</title>
    <link href="vendor/css/bootstrap-login.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

  </head>

  <body style="text-align: center; background-image:url(vendor/img/loginbackground.jpg); background-repeat:no-repeat; background-size:cover;">
    <div class="container">

      <!-- Login modal -->
      <div id="loginbox" style="margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
          <div class="panel-heading">
            <div class="panel-title">Sign In</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="#" onClick="$('#loginbox').hide(); $('#forgotbox').show();">Forgot password?</a></div>
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
                <i class='fas fa-exclamation-triangle'></i> Account (temporarily) disabled. <br>Please <a href='http://ukeep.me/#contact'>contact us</a> for more information.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } elseif ($_GET['notice'] == "1") { // account might be deleted or weird error ?>
              <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Your account might be permanently removed. <a href="#" onClick="$('#loginbox').hide(); $('#noticebox').show()">Read more</a>.</div>
              <div style="padding-top:10px" class="panel-body">
            <? } elseif ($_GET['notice'] == "2") { // account might be deleted or weird error
              echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle'></i> Please login first to continue.</div>";
              echo '<div style="padding-top:10px" class="panel-body">';
            } else { // normal login text (when no error shown)
              echo '<div style="padding-top:30px" class="panel-body">';
            }
          ?>

            <p style="margin-bottom: 20px;">Sign in to your account to continue to your personalized dashboard.</p>
            <form action="login" method="POST"  class="form-horizontal">

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="login_user" placeholder="username or email" required>
              </div>
                                
              <div style="margin-bottom: 5px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-key"></i></span>
                <input type="password" class="form-control" name="login_password" placeholder="password" required>
              </div>
                             
              <div style="margin-bottom: 35px;" class="input-group">
                <label><input id="login-remember" type="checkbox" name="remember" value="1"> Remember me</label>
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

      <!-- Register modal -->
      <div id="signupbox" style="display:none; margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
          <div class="panel-heading">
            <div class="panel-title">Sign Up</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="#" onClick="$('#signupbox').hide(); $('#forgotbox').show()">Forgot password?</a></div>
          </div>
          <div style="padding-top:30px" class="panel-body">
            <p style="margin-bottom: 20px;">Enter the following information to create an account.</p>
            <form action="processing" method="POST" class="form-horizontal">

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-id-card"></i></span>
                <input type="text" class="form-control" name="register_name" placeholder="First and Last Name" required>
              </div>

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" name="register_email" placeholder="Email Address" required>                       
              </div>

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="register_username" placeholder="Username">                       
              </div>
                                
              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-key"></i></span>
                <input type="password" class="form-control" name="register_password" placeholder="password">
              </div>

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-user-secret"></i></span>
                <input type="password" class="form-control" name="register_code" placeholder="Invitation code" required>
              </div>
                             
              <div style="margin-bottom: 35px;" class="input-group">
                <label><input id="login-remember" type="checkbox" name="remember" value="1"> Remember me</label>
              </div>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <button class="btn btn-success" type="submit" name="registerbutton" style="width: 140px">Register account</button>
                  <span style="margin-left:8px;">or</span>
                  <a id="btn-fblogin" href="#" class="btn btn-primary" style="margin-left:8px; width: 80px" onClick="$('#signupbox').hide(); $('#loginbox').show()">Login</a>
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
            <p style="margin-bottom: 20px;">Please enter the email address associated with your account below.</p>
            <form action="processing" method="POST" class="form-horizontal">

              <div style="margin-bottom: 15px; width: 80%; margin-left: 50px;" class="input-group">
                <span class="input-group-addon"><i class="fas fa-paper-plane"></i></span>
                <input type="email" class="form-control" name="recovery_email" placeholder="Recovery Email Address" required>
              </div>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <button class="btn btn-success" type="submit" name="recoverybutton">Send Recovery Email</button>
                </div>
              </div>

            </form>     
          </div>                     
        </div>  
      </div>

      <!-- 'Permanently removed' modal -->
      <div id="noticebox" style="display:none; margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
          <div class="panel-heading">
            <div class="panel-title">Account permanently removed</div>
          </div>     

          <div style="padding-top:30px" class="panel-body" >
            <p>
              If you see this page, your account <b>might</b> be permantly removed.<br><br> If you don't recognize this activity or don't know how this happended, <b>please try logging in again</b>. If that doesn't work, <b>contact us</b> using the contact on the homepage</a>.<br><br> Some reasons why your account <b>could</b> have been deleted:<br>
              1. Inactive for a long period (+2 years).<br>
              2. Unusual or fraudulent activity.<br>
              3. User was exploiting (premium) features.<br>
              Or other (unlisted) reasons.
            </p><br>

              <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                  <a class="btn btn-secondary" href="#"  onClick="$('#noticebox').hide(); $('#loginbox').show()"> &laquo; Back</a>
                </div>
              </div>

          </div>                     
        </div>  
      </div>

  </body>
</html>