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
  <title>SMART Dashboard &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SMART Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-<?php echo $theme_color; ?> shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- 'Items to do this week' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_week_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `dateon` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY) AND `type`='task'";
                $widget_week_result = mysql_query($widget_week_sql) or die(mysql_error());
                $widget_week_total = mysql_num_rows($widget_week_result);
              ?>
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks todo this week</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_week_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 'Deadlines passed' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_passed_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `dateon` < CURRENT_DATE() AND `type`='task'";
                $widget_passed_result = mysql_query($widget_passed_sql) or die(mysql_error());
                $widget_passed_total = mysql_num_rows($widget_passed_result);
              ?>
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Task Deadlines missed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_passed_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 'Active / Total' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_active_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE status='ACTIVE' AND type='task' AND `status`!='TRASH'";
                $widget_active_result = mysql_query($widget_active_sql) or die(mysql_error());
                $widget_active_total = mysql_num_rows($widget_active_result);

                $widget_count_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`!='TRASH'";
                $widget_count_result = mysql_query($widget_count_sql) or die(mysql_error());
                $widget_count_total = mysql_num_rows($widget_count_result);

                $wiget_active_percentage = ($widget_active_total/$widget_count_total)*100;
              ?>
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><b>Active / total</b> Tasks</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $widget_active_total; ?>/<?php echo $widget_count_total; ?></div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $wiget_active_percentage; ?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 'Bookmarked / Total' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_bookmarked_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE bookmark='1' AND `status`!='TRASH'";
                $widget_bookmarked_result = mysql_query($widget_bookmarked_sql) or die(mysql_error());
                $widget_bookmarked_total = mysql_num_rows($widget_bookmarked_result);

                $wiget_bookmarked_percentage = ($widget_bookmarked_total/$widget_count_total)*100;
              ?>
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><b>Bookmarked / Total</b> Items</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $widget_bookmarked_total; ?>/<?php echo $widget_count_total; ?></div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $wiget_bookmarked_percentage; ?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Item Activity Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Item Type Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Tasks
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Notes
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Other
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Important Items</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-scroll"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-scroll"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-scroll"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-scroll"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Bookmarked Items</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-bookmark"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-bookmark"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-bookmark"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card bg-<?php echo $theme_color; ?> text-white shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-bookmark"></i> Note title
                          <div class="small">Note content</div>
                          <div class="text-white-50 small"><i>Label:</i> asdf <span class="float-right"><i>Priority:</i> asdf</span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Projects</h6>
                </div>
                <div class="card-body">
                  <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-lg-6 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Illustrations</h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../vendor/img/loginbackground.jpg" alt="">
                  </div>
                  <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" href="#">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
                  <a target="_blank" href="#">Browse Illustrations on unDraw &rarr;</a>
                </div>
              </div>

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Development Approach</h6>
                </div>
                <div class="card-body">
                  <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>
                  <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>
  

  <!-- Page level plugins / custom scripts for charts -->
  <script src="../vendor/js/chart.js/Chart.min.js"></script>
  <script src="../vendor/js/demo/chart-area-demo.js"></script>
  <script src="../vendor/js/demo/chart-pie-demo.js"></script>

</body>
</html>