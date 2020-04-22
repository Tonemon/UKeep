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

          <div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <i class="fas fa-exclamation-triangle"></i> This feature is not fully implemented yet.
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manage your Teams</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" disabled><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>


          <div class="row">

            <!-- Introduction card -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-info-circle"></i> Introduction</h6>
                </div>
                <div class="card-body">
                  <p>Welcome to the teams function in UKeep! This feature enables you and your team to collaborate and share notes and labels between eachother. As the team leader, you have the ability to add/remove team members and create new teams.</p>
                  <p class="mb-0">All of your teams are listed on the right and you can access your team notes/tasks/labels in <a href="items?view=all" class="text-<?php echo $theme_color; ?>">your own environment</a> by clicking on the <span class="font-weight-bold text-<?php echo $theme_color; ?>">View category</span> dropdown and selecting your team.</p>
                </div>
              </div>
            </div>

            <!-- User Teams section -->
            <div class="col-xl-4 col-lg-5">
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