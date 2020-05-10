<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
$current_username = $rws[3]; // from esssentials to compare with user view request

  if (isset($_GET['view'])){
    $viewuser = $_GET['view'];
    $viewme_sql = "SELECT * FROM UKeepMAIN.users WHERE username='$viewuser'";
    $viewme_result = mysql_query($viewme_sql) or die(mysql_error());
    $viewuser = mysql_fetch_array($viewme_result);

    // get status of all information that can be displayed (privacy settings)
    $display_usercode = $viewuser[8];
    $userpref_sql = "SELECT account_show_pic, account_show_fullname, account_show_email, account_show_dob, account_show_gender, account_show_status FROM UKeepMAIN.preferences WHERE account_usercode='$display_usercode'";
    $userpref_result = mysql_query($userpref_sql) or die(mysql_error());
    $userpref = mysql_fetch_array($userpref_result);

    $showpref_pic = $userpref[0];
    $showpref_fullname = $userpref[1];
    $showpref_email = $userpref[2];
    $showpref_dob = $userpref[3];
    $showpref_gender = $userpref[4];
    $showpref_badge = $userpref[5];

  } else {
    $viewme_sql = "SELECT * FROM UKeepMAIN.users WHERE usercode='$user_code'";
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

  if (isset($_REQUEST['change_persinfo'])){ // other information change request
    $pwd_check = sha1(mysql_real_escape_string($_REQUEST['edit_submit_pwd']).$salt); // password confirmation
    
    $edit_usercode = mysql_real_escape_string($_REQUEST['edit_submit_usercode']);
    $edit_fullname = $_POST['edit_fullname'];
    $edit_dob = $_POST['edit_dob'];
    $edit_address = $_POST['edit_address'];
    $edit_mobile = $_POST['edit_mobile'];
    $edit_gender = $_POST['edit_gender'];

    $query3 = "SELECT password FROM UKeepMAIN.users WHERE usercode='$edit_usercode'";
        $result3 = mysql_query($query3) or die(mysql_error());
        $passcheck = mysql_fetch_array($result3);
    
    if ($passcheck[0] == $pwd_check){ // submitted password matches
      $sql9 = "UPDATE UKeepMAIN.users SET name='$edit_fullname', dob='$edit_dob', address='$edit_address', mobile='$edit_mobile', gender='$edit_gender' WHERE usercode='$edit_usercode'";
      mysql_query($sql9) or die(mysql_error());
      header('location:profile?success=1');
    } else { // password does not match
      header('location:profile?error=1');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title><?php echo $display_fullname; ?> profile &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <?php
          if ($_GET['success'] == "1") { // created new task
            echo "<div class='alert alert-success alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-check'></i> User information changed. </div>";
          } elseif ($_GET['error'] == "1") { // error: something wrong
            echo "<div class='alert alert-warning alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
          }
        ?>

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Profile: 
        <div class="dropdown dropdown-lg no-arrow" style="display:inline-block;">
          <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
            <?php if ($display_username != ""){
              echo $display_username;
            } else {
              echo "<i>User not found</i>";
            } ?> 
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"  style="width: 450px">
            <!-- Search Users bar -->
            <form action="profile" method="GET">
              <div class="input-group dropdown-header text-<?php echo $theme_color; ?>">Search user by username</div>
              <div class="input-group dropdown-header">
                <input type="text" name="view" class="form-control bg-light border-0 small" placeholder="Username" aria-label="Search" required>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-<?php echo $theme_color; ?>">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </h1>



        <?php if (!isset($_GET['view'])){ // if view in URL, display all of this, else not. ?>
          <div class="row">

            <!-- View personal information -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user"></i> User Information</h6>
                </div>
                <div class="card-body">
                  <p>
                    <?php $display_own_badge = "<span class='badge badge-success'>Online</span>"; ?>
                    <h2><img class="rounded-circle img-thumbnail" width="100px" src="../usericons/<?php echo $display_profilepic; ?>.png">
                      <b><?php echo $display_fullname; ?></b> <?php echo $display_own_badge; ?>
                    </h2><br>
                    <span>Your Last login was on <b><?php echo date_format(date_create($display_lastlogin),"l, d F Y, H:i"); ?></b>.</span><br>
                    <span class="heading">
                      Your username is <b><?php echo $display_username; ?></b> and your email address is <b><?php echo $display_email; ?></b>.
                      Your account type is <b><?php echo $display_acctype; ?></b>. 
                    </span><br><br>
                    <span class="heading">
                      Your address is <b><?php echo $display_address; ?></b> and your phone number is <b><?php echo $display_phone; ?></b>. 
                      Your date of birth is <b><?php echo date_format(date_create($display_dob),"d F Y"); ?></b> and your gender is 
                        <b><?php 
                            if ($display_gender == "M"){ 
                              echo "male"; 
                            } elseif ($display_gender == "F") { 
                              echo "female"; 
                            } else {
                              echo "unknown";
                            } ?></b>. 

                      <br><br>
                      <div class='alert alert-info'>
                        <i class='fas fa-info-circle'></i> <a href="profile?view=<?php echo $display_username;?>" class="text-<?php echo $theme_color; ?>">This</a> is how other people see your profile.
                      </div>
                  </p>                  
                </div>
              </div>
            </div>

            <!-- Edit Account information -->
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user-plus"></i> Change user information</h6>
                </div>
                <div class="card-body">
                  <form action="profile" method="POST">
                    <small class="form-text">You can edit your personal information below. Your username and email <b>cannot</b> be changed manually at the moment. Please contact support to change this.</small><br>
                    <table>
                      <tr>
                        <td>Name:</td>
                        <td><input type="text" class="form-control" value="<?php echo $display_fullname; ?>" name="edit_fullname" required /></td>
                      </tr>
                      <tr>
                        <td>Dob:</td>
                        <td><input type="date" class="form-control" value="<?php echo $display_dob; ?>" name="edit_dob" required /></td>
                      </tr>
                      <tr>
                        <td>Address: &nbsp;</td>
                        <td><input type="text" class="form-control" value="<?php echo $display_address; ?>" name="edit_address" required /></td>
                      </tr>
                      <tr>
                        <td>Phone:</td>
                        <td><input type="text" class="form-control" value="<?php echo $display_phone; ?>" name="edit_mobile" required /></td>
                      </tr>
                      <tr>
                        <td>Gender:</td>
                        <td><select class="form-control" name="edit_gender">
                            <option value="M" <?php if ($display_gender == "M") { echo 'selected'; }?> >Male (M)</option>
                            <option value="F" <?php if ($display_gender == "F") { echo 'selected'; }?> >Female (F)</option>
                          </select>
                        </td>
                      </tr>
                    </table><br>
                    <small class="form-text">Confirm your current password below to change your personal information.</small>
                    <table><tr>
                        <td>Password: &nbsp;</td>
                        <td><input type="hidden" name="edit_submit_usercode" value="<?php echo $user_code; ?>"/>
                          <input type="password" class="form-control" name="edit_submit_pwd" required /></td>
                    </tr></table><br>

                    <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="change_persinfo">
                      <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Update my information</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>

          </div> <!-- / row -->

        <?php } elseif (isset($_GET['view']) && $display_fullname != ""){ // view others profile ?>
          <div class="row">

            <!-- View user info -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user"></i> User Information</h6>
                </div>
                <div class="card-body">
                  <?php // responsive badges: online/offline
                    if ($display_status == "online"){
                      $display_badge = "<span class='badge badge-success'>Online</span>";
                    } else {
                      $display_badge = "<span class='badge badge-secondary'>Offline</span>";
                    }

                    $display_own_badge = "<span class='badge badge-success'>Online</span>";
                  ?>
                  <p>
                    <h2>
                      <?php if ($showpref_pic == "1"){ // profile pic preference
                        echo '<img class="rounded-circle img-thumbnail" width="100px" src="../usericons/'.$display_profilepic.'.png">';
                      } else {
                        echo '<img class="rounded-circle img-thumbnail" width="100px" src="../usericons/unknown.png">';
                      } ?>
                      <b>
                        <?php if ($showpref_fullname == "1"){ // full name preference
                          echo $display_fullname; 
                        } else {
                          echo $display_username;
                        } ?>
                      </b> 
                        <?php if ($showpref_badge == "1"){ // full name preference
                          echo $display_badge; 
                        } else {
                          echo '<span class="badge badge-dark"><i>Private</i></span>';
                        } ?>
                    </h2><br>
                    <span>Users account type is <b><?php echo $display_acctype; ?></b>.</span><br><br>
                    <span class="heading">
                      Username is <b><?php echo $display_username; ?></b>.<br>
                      <?php if ($showpref_email == "1") { // email preference ?>
                        Email address is <b><?php echo $display_email; ?></b>.<br>
                      <?php } ?>
                    </span>
                    <span class="heading">
                      <?php if ($showpref_dob == "1") { // dob preference ?>
                        Date of birth is <b><?php echo date_format(date_create($display_dob),"d F Y"); ?></b>.<br>
                      <?php } if ($showpref_gender == "1") { // gender preference ?>
                        Gender is 
                        <?php 
                              if ($display_gender == "M"){ 
                                echo "<b>male</b>."; 
                              } else { 
                                echo "<b>female</b>."; 
                              }
                        ?>
                      <?php } ?>
                    </span>
                    <?php if ($_GET['view'] == $current_username){ ?><br><br>
                      <div class='alert alert-info'>
                        <i class='fas fa-info-circle'></i> Go <a href="profile" class="text-<?php echo $theme_color; ?>">back</a> to your profile.
                      </div>
                    <?php } ?>
                  </p>                  
                </div>
              </div>
            </div>

            <!-- User Actions -->
            <?php if ($_GET['view'] != $current_username){ ?>
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user-plus"></i> Contact Options</h6>
                </div>
                <div class="card-body">
                      Add user as contact
                    <div class="float-right">
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="add_contact">
                        <span class="icon text-white-50">
                          <i class="fas fa-user-plus"></i>
                        </span>
                        <span class="text">Add New Contact</span>
                      </button>
                    </div>
                </div>
              </div>
            </div>
            <?php } ?>


          </div>

        <?php } else { // profile does not exist ?>

          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user"></i> User Information</h6>
                </div>
                <div class="card-body">
                  User with the username '<span class="font-weight-bold text-<?php echo $theme_color; ?>"><?php echo $_GET['view']; ?></span>'' does not exist.
                </div>
              </div>
            </div>
          </div>

        <?php } ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'site-footer.php'; ?>

</body>
</html>