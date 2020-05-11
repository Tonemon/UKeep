<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'dashboard/essentials.php';

if ($user_acctype == "admin"){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	
    <?php include 'dashboard/addons/metadata.php'; ?>
  	<title>Where to go? &bull; UKeep</title>
    <link href="vendor/css/bootstrap-login.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

  </head>

  <body style="text-align: center; background-image:url(vendor/img/loginbackground.jpg); background-repeat:no-repeat; background-size:cover;">
    <div class="container">

      <!-- Login modal -->
      <div id="loginbox" style="margin-top:150px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" style="margin-bottom: 120px;">
          <div class="panel-heading">
            <div class="panel-title">Select location to continue...</div>
            <div style="float:right; font-size: 80%; position: relative; top:-15px"><a href="dashboard/logout">Logout</a></div>
          </div>
            <p style="margin-top: 20px;">Hi <b><?php echo $user_name; ?></b>. You have not set a default redirect URL yet.<br> Select one in the <a href="dashboard/settings?customize=main">settings</a> to stop seeing this page.<br><br> Select a page below to continue.</p>

            <div style="margin-top: 20px; margin-bottom: 40px;">
              <a id="btn-fblogin" href="/admin/" class="btn btn-danger" style="margin-left:8px; width: 140px">Admin Panel</a>
              <span style="margin-left:8px;">or</span>
              <a id="btn-fblogin" href="/dashboard/" class="btn btn-primary" style="margin-left:8px; width: 160px">SMART Dashboard</a>
            </div>
          </div>                     
        </div>  
      </div>

  </body>
</html>

<?php 
} else {
  header('location:../login?notice=2');
}

?>