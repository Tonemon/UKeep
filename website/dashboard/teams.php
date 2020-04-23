<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Manage your Teams &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> This feature is not yet available.
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manage your Teams</h1>
          </div>


          <div class="row">

          <?php
            $dash_sql = "SELECT teams_show_start FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
            $dash_result = mysql_query($dash_sql) or die(mysql_error());
            $dash = mysql_fetch_array($dash_result);
            $teams_start = $dash[0];
          ?>
            
            <div class="col-xl-8">

            <!-- Introduction card -->  
            <?php if ($teams_start == "1") { ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-info-circle"></i> Introduction</h6>
                </div>
                <div class="card-body">
                  <p>Welcome to the teams function in UKeep! This feature enables you and your team to collaborate and share notes and labels between eachother. As the team leader, you have the ability to add/remove team members and create new teams.</p>
                  <p class="mb-0">All of your teams are listed on the right and you can access your team notes/tasks/labels in <a href="items?view=all" class="text-<?php echo $theme_color; ?>">your own environment</a> by clicking on the <span class="font-weight-bold text-<?php echo $theme_color; ?>">View category</span> dropdown and by selecting your team.</p>
                </div>
              </div>
            <?php } ?>

              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-cog"></i> Team Actions</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Select an action to perform:</div>
                      <a class="dropdown-item" href="?action=create"><i class="fas fa-fw fa-plus-square"></i> Create new team</a>
                      <a class="dropdown-item" href="?action=join"><i class="fas fa-fw fa-users"></i> Join a team</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="?action=overview"><i class="fas fa-fw fa-pencil-alt"></i> Edit a team</a>
                      <a class="dropdown-item" href="?action=overview"><i class="fas fa-fw fa-trash-alt"></i> Delete a team</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <p>Click on the <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i> of this card to perform an action.</p> You can do the following:
                  <ul>
                    <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-plus-square"></i> Create</span> a new team.</li>
                    <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-users"></i> Join</span> an existing team.</li>
                    <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-pencil-alt"></i> Edit</span> a team.</li>
                    <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-trash-alt"></i> Delete</span> a team.</li>
                  </ul>
                </div>
              </div>

            </div>

            <!-- User Teams section -->
            <div class="col-xl-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-users"></i> Your Teams</h6>
                </div>
                <div class="card-body">
                  <div class="row">

                      <div class="col-lg-12 mb-4">
                        <div class="card text-dark shadow-lg">
                          <div class="card-body" onclick="location.href='teams?view=team&team=5'">
                            <h4><i class="<?php echo $icon; ?>"></i> Team Name</h4>
                            <div class="small">Team Description</div>
                            <div class="small">More info</div>
                          </div>
                        </div>
                      </div>

                  </div>
                  <div class="mt-4 text-center small font-weight-bold text-<?php echo $theme_color; ?>">Team Colors</div>
                  <div class="text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Color 1</span>
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Color 2</span>
                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Color 3</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>
  

  <!-- Custom scripts for charts -->
  <script src="../vendor/js/chart.js/Chart.min.js"></script>
  <script src="addons/chart-area-demo.js"></script>
  <script src="addons/chart-pie-demo.js"></script>

</body>
</html>