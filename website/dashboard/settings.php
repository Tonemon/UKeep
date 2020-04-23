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

    $custom_sql = "UPDATE UKeepMAIN.preferences SET user_theme='$custom_theme', redirect_url='$custom_redirect', side_trash='$side_trash', side_teams='$side_teams', side_contacts='$side_contacts', side_support='$side_support', side_settings='$side_settings' WHERE account_usercode='$user_code'";
    mysql_query($custom_sql) or die(header('location:settings?customize=main&error=1'));
    header('location:settings?customize=main&success=1');

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

    $custom2_sql = "UPDATE UKeepMAIN.preferences SET dashw_show_week='$cdashw_week', dashw_show_deadlines='$cdashw_deadlines', dashw_show_active='$cdashw_active', dashw_show_ratio='$cdashw_ratio', dash_show_start='$cdash_start', dash_show_chart1='$cdash_chart1', dash_show_chart2='$cdash_chart2', dash_show_labels='$cdash_labels', dash_show_book='$cdash_bookmarked' WHERE account_usercode='$user_code'";
    mysql_query($custom2_sql) or die(mysql_error());
    header('location:settings?customize=dashboard&success=1');

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
  <title>Settings &bull; UKeep</title>

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
        <h1 class="h3 mb-4 text-gray-800">Your <span class="text-<?php echo $theme_color; ?>">Settings</span> (customize your profile and dashboard)</h1>
          <div class="row">

            <!-- View personal information -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-palette"></i> Customize your dashboard</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Select a feature to customize:</div>
                      <a class="dropdown-item" href="?customize=main"><i class="fas fa-fw fa-home"></i> Theme, redirect and sidebar</a>
                      <a class="dropdown-item" href="?customize=dashboard"><i class="fas fa-fw fa-tachometer-alt"></i> SMART Dashboard</a>
                      <a class="dropdown-item" href="?customize=profile"><i class="fas fa-fw fa-user-circle"></i> Your Public profile</a>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body">

                  <?php if ($_GET['customize'] == "main") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck1 = "SELECT user_theme, redirect_url, side_trash, side_teams, side_contacts, side_support, side_settings FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult1 = mysql_query($customcheck1) or die(mysql_error());
                      $arr1 =  mysql_fetch_array($customresult1);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can choose a theme for your dashboard, the page you will be redirected to after login and which pages will be visible in the sidebar.</p>
                      <input type="hidden" name="c_usercode" value="<?php echo $user_code; ?>" />
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
                            </select>
                          </td>
                        </tr>
                      </table><br>
                      <table>
                        <tr><td><b>Show/Hide Pages &nbsp;</b></td>
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
                      </table><br>
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="customize_main"><i class="fas fa-check"></i> Update settings</button>
                    </form><br>
                    <div class='alert alert-info'>
                      <i class='fas fa-info-circle'></i> You can still visit hidden pages, but you will need to use links on other pages or the URL bar to access them.
                    </div>

                  <?php } elseif ($_GET['customize'] == "dashboard") { ?>
                    <?php
                      // The code below gets the custom user settings from UKeepMAIN.preferences. These values will be used to display checked options.
                      $customcheck2 = "SELECT dashw_show_week, dashw_show_deadlines, dashw_show_active, dashw_show_ratio, dash_show_start, dash_show_chart1, dash_show_chart2, dash_show_labels, dash_show_book FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $customresult2 = mysql_query($customcheck2) or die(mysql_error());
                      $arr2 =  mysql_fetch_array($customresult2);
                    ?>

                    <form action="settings" method="POST">
                      <p>Here you can choose which widgets and cards you want to display on your dashboard.</p>
                      <input type="hidden" name="c_usercode" value="<?php echo $user_code; ?>" />
                      <table>
                        <tr><td><b>Widgets &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="cdash_week" <?php if ($arr2[0] == "1"){ echo 'checked'; } ?>> Todo this week</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_deadlines" <?php if ($arr2[1] == "1"){ echo 'checked'; } ?>> Deadlines missed</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_active" <?php if ($arr2[2] == "1"){ echo 'checked'; } ?>> Active/total</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_ratio" <?php if ($arr2[3] == "1"){ echo 'checked'; } ?>> Notes/Tasks ratio</td>
                        </tr>
                      </table><br>
                      <table>
                        <tr><td><b>Cards &nbsp;</b></td>
                          <td><input type="checkbox" value="1" name="cdash_start" <?php if ($arr2[4] == "1"){ echo 'checked'; } ?>> Introduction (disable this card after your first login)</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_chart1" <?php if ($arr2[5] == "1"){ echo 'checked'; } ?>> Item Activity Flow Chart</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_chart2" <?php if ($arr2[6] == "1"){ echo 'checked'; } ?>> Item Type Pie Chart</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_labels" <?php if ($arr2[7] == "1"){ echo 'checked'; } ?>> Label Analytics</td>
                        </tr>
                        <tr><td></td>
                          <td><input type="checkbox" value="1" name="cdash_bookmarked" <?php if ($arr2[8] == "1"){ echo 'checked'; } ?>> Bookmarked Items</td>
                        </tr>
                      </table><br>
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="customize_dashboard"><i class="fas fa-check"></i> Update settings</button>
                    </form>

                  <?php } else { ?>
                    <p>Click on the <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i> of this card to select a feature to customize.</p>
                  <?php } ?>

                </div>
              </div>
            </div>

            <!-- Edit Account information -->
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-cogs"></i> Account settings</h6>
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
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="change_persinfo"><i class="fas fa-check"></i> Submit my new information</button>
                  </form>
                </div>
              </div>
            </div>

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