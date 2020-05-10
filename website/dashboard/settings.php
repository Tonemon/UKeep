<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
$current_username = $rws[3]; // from esssentials to compare with user view request

   if (isset($_REQUEST['customize_main'])){
    $custom_theme = $_POST['theme'];
    $custom_redirect = $_POST['redirect'];

    $side_trash = $_POST['cside_trash'];
    $side_teams = $_POST['cside_teams'];
    $side_contacts = $_POST['cside_contacts'];
    $side_support = $_POST['cside_support'];
    $side_settings = $_POST['cside_settings'];
    $side_notes_tasks = $_POST['cside_notes_tasks'];
    $side_notes = $_POST['cside_notes'];
    $side_tasks = $_POST['cside_tasks'];
    $side_guide = $_POST['cside_guide'];
    $side_suite = $_POST['cside_suite'];
    $side_labels = $_POST['cside_labels'];

    $custom_sql = "UPDATE UKeepMAIN.preferences SET user_theme='$custom_theme', redirect_url='$custom_redirect', side_trash='$side_trash', side_teams='$side_teams', side_contacts='$side_contacts', side_support='$side_support', side_settings='$side_settings', side_notes_tasks='$side_notes_tasks', side_notes='$side_notes', side_tasks='$side_tasks', side_guide='$side_guide', side_suite='$side_suite', side_labels='$side_labels' WHERE account_usercode='$user_code'";
    mysql_query($custom_sql) or die(header('location:settings?customize=main&error=1'));
    header('location:settings?customize=main&success=1');

  } elseif (isset($_REQUEST['customize_layout'])){
    $citems_layout = $_POST['citems_layout'];

    $custom2_sql = "UPDATE UKeepMAIN.preferences SET items_layout='$citems_layout' WHERE account_usercode='$user_code'";
    mysql_query($custom2_sql) or die(header('location:settings?customize=layout&error=1'));
    header('location:settings?customize=layout&success=1');

  } elseif (isset($_REQUEST['customize_dashboard'])){
    $cdashw_week = $_POST['cdash_week'];
    $cdashw_deadlines = $_POST['cdash_deadlines'];
    $cdashw_active = $_POST['cdash_active'];
    $cdashw_ratio = $_POST['cdash_ratio'];

    $cdash_start = $_POST['cdash_start'];
    $cdash_chart1 = $_POST['cdash_chart1'];
    $cdash_chart2 = $_POST['cdash_chart2'];
    $cdash_labels = $_POST['cdash_labels'];
    $cdash_bookmarked = $_POST['cdash_bookmarked'];

    $custom3_sql = "UPDATE UKeepMAIN.preferences SET dashw_show_week='$cdashw_week', dashw_show_deadlines='$cdashw_deadlines', dashw_show_active='$cdashw_active', dashw_show_ratio='$cdashw_ratio', dash_show_start='$cdash_start', dash_show_chart1='$cdash_chart1', dash_show_chart2='$cdash_chart2', dash_show_labels='$cdash_labels', dash_show_book='$cdash_bookmarked' WHERE account_usercode='$user_code'";
    mysql_query($custom3_sql) or die(header('location:settings?customize=dashboard&error=1'));
    header('location:settings?customize=dashboard&success=1');

  } elseif (isset($_REQUEST['customize_profile'])){
    $profile_pic = $_POST['prof_pic'];
    $profile_fullname = $_POST['prof_fullname'];
    $profile_email = $_POST['prof_email'];
    $profile_dob = $_POST['prof_dob'];
    $profile_gender = $_POST['prof_gender'];
    $profile_status = $_POST['prof_status'];

    $custom4_sql = "UPDATE UKeepMAIN.preferences SET account_show_pic='$profile_pic', account_show_status='$profile_status', account_show_fullname='$profile_fullname', account_show_email='$profile_email', account_show_dob='$profile_dob', account_show_gender='$profile_gender' WHERE account_usercode='$user_code'";
    mysql_query($custom4_sql) or die(mysql_error());
    header('location:settings?customize=profile&success=1');

  } elseif (isset($_REQUEST['customize_picture'])){
    // coming soon
    header('location:settings?error=1');

  } elseif (isset($_REQUEST['change_password'])){ // other information change request
    $old_password = sha1(mysql_real_escape_string($_REQUEST['old_password']).$salt); // password confirmation
    $new_password = sha1(mysql_real_escape_string($_REQUEST['new_password']).$salt); // new password
    $again_password = sha1(mysql_real_escape_string($_REQUEST['again_password']).$salt); // new password again

    // select current password from users table
    $getpass = "SELECT password FROM UKeepMAIN.users WHERE usercode='$user_code'";
    $getpass_result = mysql_query($getpass) or die(mysql_error());
    $pass_current = mysql_fetch_array($getpass_result);
    
    if ($pass_current[0] == $old_password && $new_password == $again_password){ // everything matches
      $updatepass_sql = "UPDATE UKeepMAIN.users SET password='$new_password' WHERE usercode='$user_code'";
      mysql_query($updatepass_sql) or die(mysql_error()); // execute query

      $setoffline = "UPDATE UKeepMAIN.users SET status='offline' WHERE usercode='$user_code'";
      mysql_query($setoffline) or die("Could not set your status to offline.");

      session_destroy(); // destroying session to let the user login again using new password
      header('location:../login?notice=2');
    } elseif ($getpass_current[0] != $old_password){ // old password does not match the database
      header('location:settings?action=password&error=2');
    } elseif ($new_password != $again_password){ // two new submitted passwords don't match
      header('location:settings?action=password&error=3');
    } else { // something is wrong
      header('location:settings?action=password&error=1');
    }

  } elseif (isset($_REQUEST['deactivate_account'])){ // deactivate your account
    // coming soon
    header('location:settings?error=1');

  } elseif (isset($_REQUEST['delete_account'])){ // delete user account
    // coming soon
    header('location:settings?error=1');

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Settings &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <?php
          if ($_GET['success'] == "1") { // user information updated
            echo "<div class='alert alert-success alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-check'></i> User information updated. </div>";
          } elseif ($_GET['error'] == "1") { // error: something wrong
            echo "<div class='alert alert-warning alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
          } elseif ($_GET['error'] == "2") { // error: something wrong
            echo "<div class='alert alert-warning alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-exclamation-triangle'></i> The old password does not match the database.</div>";
          } elseif ($_GET['error'] == "3") { // error: something wrong
            echo "<div class='alert alert-warning alert-dismissible'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <i class='fas fa-exclamation-triangle'></i> The two provided passwords do not match.</div>";
          }
        ?>

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Settings (customization and account settings)</h1>
          <div class="row">

            <!-- View personal information -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <?php
                    if ($_GET['customize'] == "main"){
                      $customize_header = '<i class="fas fa-home"></i> Theme, redirect and sidebar';
                    } elseif ($_GET['customize'] == "dashboard"){
                      $customize_header = '<i class="fas fa-tachometer-alt"></i> SMART Dashboard';
                    } elseif ($_GET['customize'] == "profile"){
                      $customize_header = '<i class="fas fa-user-circle"></i> Your Public Profile';
                    } elseif ($_GET['customize'] == "picture"){
                      $customize_header = '<i class="fas fa-camera"></i> Your Profile Picture';
                    } else {
                      $customize_header = '<i class="fas fa-palette"></i> Customization Settings';
                    }

                  ?>
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><?php echo $customize_header; ?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Select a feature to customize:</div>
                      <a class="dropdown-item" href="?customize=main"><i class="fas fa-fw fa-home"></i> Theme, redirect and sidebar</a>
                      <a class="dropdown-item" href="?customize=layout"><i class="fas fa-fw fa-columns"></i> Work Efficiency Settings</a>
                      <a class="dropdown-item" href="?customize=dashboard"><i class="fas fa-fw fa-tachometer-alt"></i> SMART Dashboard</a>
                      <a class="dropdown-item" href="?customize=profile"><i class="fas fa-fw fa-user-circle"></i> Your Public Profile</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="?customize=picture"><i class="fas fa-fw fa-camera"></i> Your Profile Picture</a>
                    </div>
                  </div>
                </div>

                <div class="card-body">

                  <?php if ($_GET['customize'] == "main") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck1 = "SELECT user_theme, redirect_url, side_trash, side_teams, side_contacts, side_support, side_settings, side_notes_tasks, side_notes, side_tasks, side_guide, side_suite, side_labels FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult1 = mysql_query($customcheck1) or die(mysql_error());
                      $arr1 =  mysql_fetch_array($customresult1);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can choose a theme for your dashboard, the page you will be redirected to after login and which pages will be visible in the sidebar.</p>
                      <table>
                        <tr>
                          <td><b>Dashboard theme</b></td>
                          <td><select class="form-control" name="theme">
                              <option value="primary" <?php if ($arr1[0] == "primary"){ echo 'selected'; } ?>>Blue</option>
                              <option value="secondary" <?php if ($arr1[0] == "secondary"){ echo 'selected'; } ?>>Gray</option>
                              <option value="success" <?php if ($arr1[0] == "success"){ echo 'selected'; } ?>>Green</option>
                              <option value="danger" <?php if ($arr1[0] == "danger"){ echo 'selected'; } ?>>Red</option>
                              <option value="warning" <?php if ($arr1[0] == "warning"){ echo 'selected'; } ?>>Yellow</option>
                              <option value="info" <?php if ($arr1[0] == "info"){ echo 'selected'; } ?>>Lightblue</option>
                              <option value="dark" <?php if ($arr1[0] == "dark"){ echo 'selected'; } ?>>Black</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Login redirect page &nbsp;</b></td>
                          <td><select class="form-control" name="redirect">
                              <option value="" <?php if ($arr1[1] == ""){ echo 'selected'; } ?>>Dashboard (default)</option>
                              <option value="items" <?php if ($arr1[1] == "items?view=all"){ echo 'selected'; } ?>>Notes/Tasks</option>
                              <option value="labels" <?php if ($arr1[1] == "labels"){ echo 'selected'; } ?>>Labels</option>
                              <option value="trash" <?php if ($arr1[1] == "trash"){ echo 'selected'; } ?>>Trash</option>
                              <option value="teams" <?php if ($arr1[1] == "teams"){ echo 'selected'; } ?>>Teams</option>
                              <option value="contacts" <?php if ($arr1[1] == "contacts"){ echo 'selected'; } ?>>Contacts</option>
                              <option value="support" <?php if ($arr1[1] == "support"){ echo 'selected'; } ?>>Support</option>
                              <option value="profile" <?php if ($arr1[1] == "profile"){ echo 'selected'; } ?>>Your Profile</option>
                              <option value="settings" <?php if ($arr1[1] == "settings"){ echo 'selected'; } ?>>Settings</option>
                              <option value="guide" <?php if ($arr1[1] == "guide"){ echo 'selected'; } ?>>Guide</option>
                            </select>
                          </td>
                        </tr>
                      </table><br>
                      <table>
                        <tr><td><b>Show these sidebar links: &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="cside_suite" <?php if ($arr1[11] == "1"){ echo 'checked'; } ?>> UKeep Suite</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_notes_tasks" <?php if ($arr1[7] == "1"){ echo 'checked'; } ?>> Notes/Tasks</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_notes" <?php if ($arr1[8] == "1"){ echo 'checked'; } ?>> Notes</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_tasks" <?php if ($arr1[9] == "1"){ echo 'checked'; } ?>> Tasks</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_labels" <?php if ($arr1[12] == "1"){ echo 'checked'; } ?>> Labels</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_trash" <?php if ($arr1[2] == "1"){ echo 'checked'; } ?>> Trash</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_teams" <?php if ($arr1[3] == "1"){ echo 'checked'; } ?>> Teams</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_contacts" <?php if ($arr1[4] == "1"){ echo 'checked'; } ?>> Contacts</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_support" <?php if ($arr1[5] == "1"){ echo 'checked'; } ?>> Support</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_settings" <?php if ($arr1[6] == "1"){ echo 'checked'; } ?>> Settings</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cside_guide" <?php if ($arr1[10] == "1"){ echo 'checked'; } ?>> Guide</td>
                        </tr>
                      </table><br>

                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="customize_main">
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Update Settings</span>
                      </button>

                    </form><br>
                    <div class='alert alert-info'>
                      <i class='fas fa-info-circle'></i> You can still visit hidden pages, but you will need to use links on other pages or the URL bar to access them.
                    </div>

                  <?php } elseif ($_GET['customize'] == "layout") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck2 = "SELECT items_layout FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult2 = mysql_query($customcheck2) or die(mysql_error());
                      $arr2 =  mysql_fetch_array($customresult2);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can choose a layout for how your items will be displayed.</p>
                      <table>
                        <tr><td><b>Items Layout &nbsp;</b></td>
                          <td>
                            <select class="form-control" name="citems_layout">
                              <option value="compact" <?php if ($arr2[0] == "compact"){ echo 'selected'; } ?>>Compact Mode</option>
                              <option value="bigpicture" <?php if ($arr2[0] == "bigpicture"){ echo 'selected'; } ?>>Big Picture Mode</option>
                            </select>
                          </td>
                        </tr>
                      </table><br>

                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="customize_layout">
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Update Dashboard Settings</span>
                      </button>
                    </form>

                  <?php } elseif ($_GET['customize'] == "dashboard") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck3 = "SELECT dashw_show_week, dashw_show_deadlines, dashw_show_active, dashw_show_ratio, dash_show_start, dash_show_chart1, dash_show_chart2, dash_show_labels, dash_show_book FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult3 = mysql_query($customcheck3) or die(mysql_error());
                      $arr3 =  mysql_fetch_array($customresult3);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can choose which widgets and cards you want to display on your dashboard.</p>
                      <table>
                        <tr><td><b>Widgets &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="cdash_week" <?php if ($arr3[0] == "1"){ echo 'checked'; } ?>> Todo this week</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_deadlines" <?php if ($arr3[1] == "1"){ echo 'checked'; } ?>> Deadlines missed</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_active" <?php if ($arr3[2] == "1"){ echo 'checked'; } ?>> Active/total</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_ratio" <?php if ($arr3[3] == "1"){ echo 'checked'; } ?>> Notes/Tasks ratio</td>
                        </tr>
                      </table><br>
                      <table>
                        <tr><td><b>Cards &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="cdash_start" <?php if ($arr3[4] == "1"){ echo 'checked'; } ?>> Introduction (disable this card after your first login)</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_chart1" <?php if ($arr3[5] == "1"){ echo 'checked'; } ?>> Item Activity Flow Chart</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_chart2" <?php if ($arr3[6] == "1"){ echo 'checked'; } ?>> Item Type Pie Chart</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_labels" <?php if ($arr3[7] == "1"){ echo 'checked'; } ?>> Label Analytics</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_bookmarked" <?php if ($arr3[8] == "1"){ echo 'checked'; } ?>> Bookmarked Items</td>
                        </tr>
                      </table><br>

                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="customize_dashboard">
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Update Dashboard Settings</span>
                      </button>
                    </form>

                  <?php } elseif ($_GET['customize'] == "profile") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck4 = "SELECT account_show_pic, account_show_status, account_show_fullname, account_show_email, account_show_dob, account_show_gender FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult4 = mysql_query($customcheck4) or die(mysql_error());
                      $arr4 =  mysql_fetch_array($customresult4);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can specify what information users can see on your public profile.</p>
                      <table>
                        <tr><td><b>Show your &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="prof_pic" <?php if ($arr4[0] == "1"){ echo 'checked'; } ?>> Profile picture</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="prof_status" <?php if ($arr4[1] == "1"){ echo 'checked'; } ?>> Status 
                            (<span class="badge badge-success">Online</span> / <span class="badge badge-secondary">Offline</span> or disable to set to <span class="badge badge-dark"><i>Private</i></span>)</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="prof_fullname" <?php if ($arr4[2] == "1"){ echo 'checked'; } ?>> Full Name</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="prof_email" <?php if ($arr4[3] == "1"){ echo 'checked'; } ?>> Email Address</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="prof_dob" <?php if ($arr4[4] == "1"){ echo 'checked'; } ?>> Date of Birth</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="prof_gender" <?php if ($arr4[5] == "1"){ echo 'checked'; } ?>> Gender</td>
                        </tr>
                      </table><br>

                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="customize_profile">
                        <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Update Profile Settings</span>
                      </button>

                    </form><br>
                    <div class='alert alert-info'>
                      <i class='fas fa-info-circle'></i> You cannot hide your username, last login and account type.
                    </div>

                  <?php } elseif ($_GET['customize'] == "picture") { ?>
                    <div class="alert alert-warning">
                      <i class="fas fa-exclamation-triangle"></i> This feature is not yet available.
                    </div>
                    
                    <p>This is your picture at the moment: &nbsp; <img class="img-thumbnail rounded-circle" width="100px" src="../usericons/<?php echo $user_code; ?>.png">

                    </p>
                  <?php } else { ?>
                    <p>Click on the <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i> of this card to select a feature to customize.</p> You can customize the following:
                    <ul>
                      <li>
                        Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-palette"></i> Dashboard Theme</span>, <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-map-signs"></i> Login Redirect</span> and <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-external-link-alt"></i> Sidebar items</span>.
                      </li>
                      <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-columns"></i> Work Efficiency Settings</span>.</li>
                      <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-tachometer-alt"></i> SMART Dashboard</span>.</li>
                      <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-user-circle"></i> Public profile</span>.</li>
                    </ul>

                  <?php } ?>

                </div>
              </div>
            </div>

            <!-- Account settings -->
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <?php
                    if ($_GET['action'] == "password"){
                      $account_header = '<i class="fas fa-key"></i> Change your Password';
                    } elseif ($_GET['action'] == "deactivate"){
                      $account_header = '<i class="fas fa-archive"></i> Deactivate account';
                    } elseif ($_GET['action'] == "delete"){
                      $account_header = '<i class="fas fa-trash-alt"></i> Delete account <u>permanently</u>';
                    } else {
                      $account_header = '<i class="fas fa-cogs"></i> Account settings';
                    }

                  ?>
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><?php echo $account_header; ?></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Select an action to perform:</div>
                      <a class="dropdown-item" href="?action=password"><i class="fas fa-fw fa-key"></i> Change password</a>
                      <div class="dropdown-divider"></div>
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Danger Area:</div>
                      <a class="dropdown-item" href="?action=deactivate"><i class="fas fa-fw fa-archive"></i> Deactivate account</a>
                      <a class="dropdown-item" href="?action=delete"><i class="fas fa-fw fa-trash-alt"></i> Delete account</a>
                    </div>
                  </div>
                </div>

                <div class="card-body">
                  <?php if ($_GET['action'] == "password") { ?>
                    <form action="settings" method="POST">
                      <p>Enter your current password and then two times your new password.</p>
                      <table>
                        <tr>
                          <td><b>Current password:</b></td>
                          <td><input type="password" class="form-control" name="old_password" required=""/></td>
                        </tr>
                        <tr>
                          <td><b>New password:</b></td>
                          <td><input type="password" class="form-control" name="new_password" required=""/></td>
                        </tr>
                        <tr>
                          <td><b>New password again:</b> &nbsp;</td>
                          <td><input type="password" class="form-control" name="again_password" required=""/></td>
                        </tr>
                      </table><br>

                      <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="change_password">
                        <span class="icon text-white-50">
                          <i class="fas fa-pencil-alt"></i>
                        </span>
                        <span class="text">Change Password</span>
                      </button>
                    </form>

                  <?php } elseif ($_GET['action'] == "deactivate") { ?>
                    <div class="alert alert-warning">
                      <i class="fas fa-exclamation-triangle"></i> This feature is not yet available.
                    </div>
                    <form action="settings" method="POST">
                    <?php if ($user_acctype == "admin"){ // normal users ?>
                      <p>Hi <b>admin</b>, you cannot deactivate your account.</p>

                    <?php } else { // if admin asks to delete his account ?>
                      <p>When you deactivate your account, you keep your notes/tasks and labels, but you won't be able to login again. You will need to contact support to reactivate your account.<br><br>
                        <input type="checkbox" id="deactivate1Check" required> I am sure I want to deactivate my UKeep account.<br>
                        <input type="checkbox" id="deactivate2Check" required> I acknowledge the fact that I can reactivate my account by contacting support.<br><br>

                        <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="deactivate_account">
                          <span class="icon text-white-50">
                            <i class="fas fa-archive"></i>
                          </span>
                          <span class="text">Deactivate my account</span>
                        </button>
                      </p>

                    <?php } ?>
                    </form>

                  <?php } elseif ($_GET['action'] == "delete") { ?>
                    <div class="alert alert-warning">
                      <i class="fas fa-exclamation-triangle"></i> This feature is not yet available.
                    </div>
                    <form action="settings" method="POST">
                    <?php if ($user_acctype == "admin"){ // admin user requests account removal ?>
                      <p>Hi <b>admin</b>, if you want to stop working at UKeep, please contact someone with a higher position and hand in your resignation.</p>

                    <?php } else { // normal user requests account removal ?>
                      <p>Hi <?php echo $user_name; ?>, we are sad to see you close your UKeep account! Please enter your reason below to inform us why you want to close your account.<br><br>
                        <textarea class="form-control" name="deleteReason" rows="1" placeholder="Reason why I am leaving..." required></textarea><br>
                        <input type="checkbox" id="delete1Check" required> I am sure I want to permanently delete my UKeep account.<br>
                        <input type="checkbox" id="delete2Check" required> I am sure I want to <b>delete all of my notes/tasks and labels</b>.<br><br>
                        Please confirm by writing <span class="font-weight-bold text-<?php echo $theme_color; ?>">I am sure</span> in the textbox below.
                        <textarea class="form-control" name="delete3Check" rows="1" placeholder="I am sure" required></textarea><br>

                        <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="delete_account">
                          <span class="icon text-white-50">
                            <i class="fas fa-exclamation-triangle"></i>
                          </span>
                          <span class="text">Permanently delete my Account</span>
                        </button>
                      </p>

                    <?php } ?>
                    </form>

                  <?php } else { ?>
                    <p>Click on the <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i> of this card to perform actions on this account.</p> You can perform these actions:
                    <ul>
                      <li>Change your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-key"></i> password</span>.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-archive"></i> Deactivate</span> your account.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-trash-alt"></i> Delete</span> your account <u>permanently</u>.</li>
                    </ul>

                  <?php } ?>

                </div>
              </div>
            </div>

          </div> <!-- / row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'site-footer.php'; ?>

</body>
</html>