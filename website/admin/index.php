<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include '../dashboard/essentials.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include '../dashboard/addons/metadata.php'; ?>
  <title>Administration Panel &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid right-click-support-dashboard">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Administration Panel</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-<?php echo $theme_color; ?> shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          <!-- Widgets Row -->
          <div class="row">

            <!-- Online Users / Total Users card -->
            <?php
              // count total user accounts
              $card_totalsql = "SELECT count(*) FROM UKeepMAIN.users"; 
              $card_counttotal = mysql_query($card_totalsql) or die(mysql_error());
              $card_total = mysql_fetch_array($card_counttotal);
              
              // count all online users
              $card_onlinesql = "SELECT count(*) FROM UKeepMAIN.users WHERE status='online'";
              $card_countonline = mysql_query($card_onlinesql) or die(mysql_error());
              $card_online = mysql_fetch_array($card_countonline);

              $card_users_result = $card_total[0]." / ".$card_online[0];
            ?>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Users Online / Total Users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $card_users_result; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-globe fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Premium Requests card -->
            <?php
              // This feature needs to be implemented in the future
            ?>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Premium Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">NaN</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-crown fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- New Account requests card -->
            <?php
              $card_newaccountssql = "SELECT count(*) FROM UKeepMAIN.usersnew";
              $card_countnewaccounts = mysql_query($card_newaccountssql) or die(mysql_error());
              $card_newaccounts = mysql_fetch_array($card_countnewaccounts);
              $card_requests_result = $card_newaccounts[0];
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">New Account Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $card_requests_result; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Unreviewed Support Questions card -->
            <?php
              $card_reviewsql = "SELECT count(id) FROM UKeepMAIN.questions WHERE status='TO REVIEW'";
              $card_countreview = mysql_query($card_reviewsql) or die(mysql_error());
              $card_review = mysql_fetch_array($card_countreview);
              $card_review_total = $card_review[0];
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unreviewed Support Questions</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $card_requests_result; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Alerts card -->
            <?php
              $card_alertssql = "SELECT count(id) FROM UKeepMAIN.security WHERE status='PENDING'";
              $card_countalerts = mysql_query($card_alertssql) or die(mysql_error());
              $card_alerts = mysql_fetch_array($card_countalerts);
              $card_alerts_total = $card_alerts[0];
            ?>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Alerts</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $card_alerts_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <!-- User Accounts Overview Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-users"></i> User Accounts Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="UsersChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> <a class="text-<?php echo $theme_color; ?>" href="users?view=normal">Normal Accounts</a>
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> <a class="text-<?php echo $theme_color; ?>" href="users?view=premium">Premium Accounts</a>
                    </span><br>
                    <span class="mr-2">
                      <i class="fas fa-circle text-secondary"></i> <a class="text-<?php echo $theme_color; ?>" href="users?view=removed">Removed Accounts</a>
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-danger"></i> <a class="text-<?php echo $theme_color; ?>" href="users?view=admin">Administrator Accounts</a>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Activity Overview Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-chart-line"></i> Item Activity Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="AreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Right click support -->
        <div class="dropdown-menu dropdown-menu-sm" id="context-menu-dashboard">
          <div class="dropdown-header text-<?php echo $theme_color; ?>">Perform an action:</div>
          <a class="dropdown-item" href="settings?customize=dashboard"><i class="fas fa-palette"></i> Customize SMART Dashboard</a>
        </div>

      </div>
      <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>
  

  <!-- Custom scripts for charts -->
  <script src="../vendor/js/chart.js/Chart.min.js"></script>
  <script src="addons/chart-area-demo.js"></script>
  <script src="addons/chart-pie-demo.js"></script>

</body>
</html>