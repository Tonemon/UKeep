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

          <!-- Widgets Row -->
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
                      <a href="items?view=week&advanced_search">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks todo this week (View)</div>
                      </a>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_week_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 'Task deadlines passed' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_passed_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `dateon` < CURRENT_DATE() AND `type`='task' AND `status`!='TRASH'";
                $widget_passed_result = mysql_query($widget_passed_sql) or die(mysql_error());
                $widget_passed_total = mysql_num_rows($widget_passed_result);
              ?>
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=passed&advanced_search">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Task Deadlines missed (View)</div>
                      </a>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_passed_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 'Active / Total tasks ratio' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_active_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE status='ACTIVE' AND type='task' AND `status`!='TRASH'";
                $widget_active_result = mysql_query($widget_active_sql) or die(mysql_error());
                $widget_active_total = mysql_num_rows($widget_active_result);

                $widget_count_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`!='TRASH' AND type='task'";
                $widget_count_result = mysql_query($widget_count_sql) or die(mysql_error());
                $widget_count_total = mysql_num_rows($widget_count_result);

                $wiget_active_percentage = ($widget_active_total/$widget_count_total)*100;
              ?>
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=tasks&advanced_search">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><b>Active / total</b> Tasks</div>
                      </a>
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

            <!-- 'Notes / Tasks ratio' card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <?php
                $widget_ratio_note_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE type='note' AND `status`!='TRASH'";
                $widget_ratio_note_result = mysql_query($widget_ratio_note_sql) or die(mysql_error());
                $widget_ratio_note_total = mysql_num_rows($widget_ratio_note_result);

                $widget_ratio_task_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE type='task' AND `status`!='TRASH'";
                $widget_ratio_task_result = mysql_query($widget_ratio_task_sql) or die(mysql_error());
                $widget_ratio_task_total = mysql_num_rows($widget_ratio_task_result);

                $widget_ratio_total = $widget_ratio_note_total + $widget_ratio_task_total;
                $widget_ratio_percentage = ($widget_ratio_note_total/$widget_ratio_total)*100;
              ?>
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=all">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><b>Notes / Tasks</b> Ratio (<?php echo $widget_ratio_total; ?> items total)</div>
                      </a>
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <h4 class="small font-weight-bold"><span class="text-primary"><?php echo $widget_ratio_note_total; ?> Notes</span> <span class="float-right"><?php echo $widget_ratio_task_total; ?> Tasks</span></h4>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $widget_ratio_percentage; ?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-columns fa-2x text-gray-300"></i>
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
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-chart-pie"></i> Item Type Overview</h6>
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
                      <i class="fas fa-circle text-info"></i> Trash
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 mb-4">

              <!-- 'Label Usage' card -->
              <div class="card shadow mb-4">
                <?php
                  $viewlabel_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                  $label_result = mysql_query($viewlabel_sql) or die(mysql_error());
                  $label_num_rows = mysql_num_rows($label_result);                    
                ?>
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-folder"></i> Label Analytics</h6>
                </div>
                <div class="card-body">
                  All your Labels (<?php echo $label_num_rows; ?> total)<span class="small font-weight-bold float-right">% of items has the label</span>
                    <div class="dropdown-divider"></div><br>


                  <?php // display each label
                    while ($rws = mysql_fetch_array($label_result)) {
                      // color matching for the badges and progress bars
                      $badgecolor = $rws[2];
                      $per_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE label='$rws[0]' AND `status`!='TRASH'";
                      $per_result = mysql_query($per_sql) or die(mysql_error());
                      $per_numrows = mysql_num_rows($per_result);

                      $per_current = ($per_numrows/$widget_ratio_total)*100;
                    ?>

                    <span class="font-weight-bold float-right">&nbsp; <?php echo $per_current; ?>%</span>

                    <div class="progress progress-bar-striped mb-4">
                      <div class="progress-bar bg-<?php echo $badgecolor; ?>" role="progressbar" style="width: <?php echo $per_current; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="d-flex position-absolute w-100">
                          <span class='badge badge-<?php echo $badgecolor; ?>'><?php echo $rws[1]; ?></span>
                        </span>
                        <span class="justify-content-center d-flex position-absolute w-100 text-dark">
                          <?php echo $per_numrows."/".$widget_ratio_total." items"; ?>
                        </span>
                      </div>
                    </div>
                  <?php } ?>

                  <?php // progress bar for 'No Labels'
                      $nolabel_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE label='' AND `status`!='TRASH'";
                      $nolabel_result = mysql_query($nolabel_sql) or die(mysql_error());
                      $nolabel_numrows = mysql_num_rows($nolabel_result);

                      $nolabel_current = ($nolabel_numrows/$widget_ratio_total)*100;
                  ?>
                  
                  <div class="dropdown-divider"></div><br>
                  <span class="font-weight-bold float-right">&nbsp; <?php echo $nolabel_current; ?>%</span>

                    <div class="progress progress-bar-striped mb-4">
                      <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $nolabel_current; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="d-flex position-absolute w-100"><b><i>&nbsp; <u>No label</u></i></b></span>
                        <span class="justify-content-center d-flex position-absolute w-100 text-dark">
                          <?php echo $nolabel_numrows."/".$widget_ratio_total." items"; ?>
                        </span>
                      </div>
                    </div>
                    

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

            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-bookmark"></i> Bookmarked Items</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Bookmarked Actions:</div>
                      <a class="dropdown-item" href="items?view=bookmarked&advanced_search"><i class="fa fa-fw fa-bookmark"></i> View all bookmarked items</a>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row">
                    <?php 
                      $bookmark_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id WHERE bookmark='1' AND `status`!='TRASH'";
                      $bookmark_result = mysql_query($bookmark_sql) or die(mysql_error());
                      $bookmark_numrows = mysql_num_rows($result);

                      while ($bres = mysql_fetch_array($bookmark_result)){
                        // color matching the badges
                        $badgecolor = $bres[16];

                        if ($bres[11] == "0"){
                          $priority = "None";
                          $priority_color = "secondary";
                        } elseif ($bres[11] == "1"){
                          $priority = "Low";
                          $priority_color = "info";
                        } elseif ($bres[11] == "2"){
                          $priority = "Medium";
                          $priority_color = "warning";
                        } elseif ($bres[11] == "3"){
                          $priority = "High";
                          $priority_color = "danger";
                        }

                        if ($bres[2] == "task" AND $bres[12] == "ACTIVE"){ // task and active
                          $icon = "fas fa-calendar-alt";
                        } elseif ($bres[2] == "note" AND $bres[12] == "ACTIVE"){ // note
                          $icon = "fas fa-sticky-note";
                        } else { // means it is a note/task, but archived
                          $icon = "fas fa-archive";
                        }

                        $Date = date_format(date_create($rws[5]),"l, d F Y, H:i");
                        $search_query = str_replace(' ', '+', $bres[3]);

                      // Item output while loop
                      ?>
                      <div class="col-lg-6 mb-4">
                        <div class="card text-dark shadow-lg">
                          <div class="card-body" onclick="location.href='items?search=<?php echo $search_query; ?>&normal_search'">
                            <h4><i class="<?php echo $icon; ?>"></i> <?php echo $bres[3]; ?></h4>
                            <div class="small"><?php echo substr($bres[4], 0, 100); ?> ...</div>
                              <div class="small">
                                <?php if ($bres[15] != ""){ ?>
                                <i>Label:</i> <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $bres[15]; ?></span>
                                <?php } if ($bres[2] == "task"){ ?>
                                <i>Priority:</i> <span class="badge badge-<?php echo $priority_color; ?>"><?php echo $priority; ?></span>
                                <?php } ?>
                              </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

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