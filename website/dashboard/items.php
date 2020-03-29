<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';


$final_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id";
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'extra/metadata.php'; ?>
  <title>Items Overview &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <h1 class="h3 mb-4 text-gray-800">View Items</h1>

      <!-- Content Row -->
        <?php if ($_GET['view'] == "labels"){ ?>
          <?php include '../_inc/dbconn.php';
            $showlabel_sql = "SELECT * FROM UKeepDAT.label_$user_code";
            $label_result = mysql_query($showlabel_sql) or die(mysql_error());
            $label_num_rows = mysql_num_rows($label_result);                    
          ?>

          <div class="row">
            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">View/Edit Labels &bull;
                    <?php 
                      if ($label_num_rows == "1"){
                        echo $label_num_rows." label";
                      } else {
                        echo $label_num_rows." labels";
                      }
                    ?>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
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
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Label</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Label</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <tr>
                          <td>Serge Baldwin</td>
                          <td>Data Coordinator</td>
                        </tr>
                        <tr>
                          <td>Zenaida Frank</td>
                          <td>Software Engineer</td>
                        </tr>
                        <tr>
                          <td>Zorita Serrano</td>
                          <td>Software Engineer</td>
                        </tr>
                        <tr>
                          <td>Jennifer Acosta</td>
                          <td>Junior Javascript Developer</td>
                        </tr>
                        <tr>
                          <td>Michael Bruce</td>
                          <td>Javascript Developer</td>
                        </tr>
                        <tr>
                          <td>Donna Snider</td>
                          <td>Customer Support</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <?php } else { // no request to view labels --> view notes/tasks ?>
          <?php include '../_inc/dbconn.php';
            $result = mysql_query($final_sql) or die(mysql_error());
            $num_rows = mysql_num_rows($result);
          ?>

          <div class="row">
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">
                    <?php 
                      if ($num_rows == "1"){
                        $total_results = $num_rows." result";
                      } else {
                        $total_results = $num_rows." results";
                      }

                      if ($_GET['view'] == "all"){
                        echo 'All Items (Notes and Tasks) &bull; '.$total_results;
                      } elseif ($_GET['view'] == "notes"){
                        echo 'All Notes &bull; '.$total_results;
                      } elseif ($_GET['view'] == "tasks"){
                        echo 'All Tasks &bull; '.$total_results;
                      }
                    ?>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
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
                    <?php while ($rws = mysql_fetch_array($result)){
                      // color matching the badges
                      $badgecolor = $rws[15];

                      if ($rws[11] == "0"){
                        $priority = "None";
                        $priority_color = "secondary";
                      } elseif ($rws[11] == "1"){
                        $priority = "Low";
                        $priority_color = "info";
                      } elseif ($rws[11] == "2"){
                        $priority = "Medium";
                        $priority_color = "warning";
                      } elseif ($rws[11] == "3"){
                        $priority = "High";
                        $priority_color = "danger";
                      }

                      if ($rws[2] == "task"){
                        $icon = "fas fa-calendar-check";
                      } elseif ($rws[2] == "note"){
                        $icon = "fas fa-sticky-note";
                      } else {
                        $icon = "";
                      }

                      // making date readable
                      $createdate = date_create($rws[5]);
                      $Date = date_format($createdate,"l, d F Y, H:i");
                      // Item output
                      ?>

                        <div class="col-lg-6 mb-4">
                          <a href="edit?task=<?php echo $rws[0]; ?>" style="text-decoration:none">
                          <div class="card text-dark shadow-lg">
                            <div class="card-body">
                              <h4><i class="<?php echo $icon; ?>"></i> <?php echo $rws[3]; ?>
                                <?php if ($rws[2] == "task"){ ?>
                                  <span class="float-right">
                                    <small><small><small><i>Todo before:</i> <b><?php echo $Date; ?></b></small></small></small>
                                  </span>
                                <?php } ?>
                              </h4>
                              <div class="small"><?php echo substr($rws[4], 0, 100); ?> ...</div>
                              <div class="small">
                                <i>Label:</i> <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $rws[14]; ?></span> 
                                <i>Priority:</i> <span class="badge badge-<?php echo $priority_color; ?>"><?php echo $priority; ?></span>
                              </div>
                            </div>
                          </div>
                          </a>
                        </div>
                      <?php }  ?>
                  </div>
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