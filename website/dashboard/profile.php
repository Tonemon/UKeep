<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';

  if (isset($_GET['view'])){
    if ($_GET['view'] == "me"){ // User requested own profile
      $viewme_sql = "SELECT * FROM UKeepMAIN.users WHERE usercode='$user_code'";
      $viewme_result = mysql_query($viewme_sql) or die(mysql_error());
      $viewuser = mysql_fetch_array($viewme_result);
    } else {
      $viewuser = $_GET['view'];
      $viewme_sql = "SELECT * FROM UKeepMAIN.users WHERE username='$viewuser'";
      $viewme_result = mysql_query($viewme_sql) or die(mysql_error());
      $viewuser = mysql_fetch_array($viewme_result);
    }

    // variables for different fields on this page
    $display_profilepic = $viewuser[8]; // display profile pic using usercode
    $display_username = $viewuser[3];
    $display_status = $viewuser[5];
    $display_lastlogin = $viewuser[6];
    $display_fullname = $viewuser[1];
    $display_email = $viewuser[2];
    $display_acctype = $viewuser[9];
    $display_address = $viewuser[13];
    $display_phone = $viewuser[14];
    $display_dob = $viewuser[12];
    $display_gender = $viewuser[11];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title><?php echo $display_username; ?> profile &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <?php if (isset($_GET['view'])){ // if view in URL, display all of this, else not. ?>

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><span class="text-<?php echo $theme_color; ?>"><?php echo $display_username; ?></span> profile</h1>

          <div class="row">
            <div class="col-lg-6 mb-4">

              <!-- 'Label Usage' card -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user"></i> User Information</h6>
                </div>
                <div class="card-body">
                  <p>
                    <?php // responsive badges: online/offline
                      if ($display_status == "online"){
                        $display_badge = "<span class='badge badge-success'>Online</span>";
                      } else {
                        $display_badge = "<span class='badge badge-secondary'>Offline</span>";
                      }
                    ?>

                    <h2><img class="rounded-circle img-thumbnail" width="100px" src="../usericons/<?php echo $display_profilepic; ?>.png">
                      <b><?php echo $display_username; ?></b> <?php echo $display_badge; ?>
                    </h2><br>
                    <span>Your Last login was on <b><?php echo $display_lastlogin; ?></b>.</span><br>
                    <span class="heading">
                      Your full name is <b><?php echo $display_fullname; ?></b> and your email address is <b><?php echo $display_email; ?></b>.
                      Your account type is <b><?php echo $display_acctype; ?></b>. 
                    </span><br><br>
                    <span class="heading">
                      Your address is <b><?php echo $display_address; ?></b> and your phone number is <b><?php echo $display_phone; ?></b>. 
                      Your date of birth is <b><?php echo $display_dob; ?></b> and your gender is 
                        <b><?php 
                            if ($display_gender == "M"){ 
                              echo "male"; 
                            } elseif ($display_gender == "F") { 
                              echo "female"; 
                            } else {
                              echo "unknown";
                            } ?></b>. 

                    <?php if ($_GET['view'] == "me"){ ?>
                      <br><br>
                      <div class='alert alert-info'>
                        <div class="row">
                          <div class="col">
                            <i class='fas fa-info-circle'></i> 
                          </div>
                          <div class="col-11">
                            Want to change something? Go to the <a href="settings?action=other" class="text-<?php echo $theme_color; ?>">settings page</a>.
                            <br><a href="profile?view=<?php echo $display_username;?>" class="text-<?php echo $theme_color; ?>">This</a> is how other people see your profile.
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </p>                  
                </div>
              </div>

            </div>

            <?php if ($_GET['view'] != "me" AND $_GET['view'] != $display_username){ // contact actions ?>
            <div class="col-xl-6 col-lg-7">

              <!-- User Actions -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user-plus"></i> Contact Options</h6>
                </div>
                <div class="card-body">
                      Add user as contact
                    <div class="float-right">
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="advanced_search"><i class="fas fa-user-plus"></i> Add New Contact</button>
                    </div>
                </div>
              </div>

            </div>
            <?php } ?>
          </div>

        <?php } ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'site-footer.php'; ?>

</body>
</html>