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
  <title>Guide &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> The information on this page is incomplete at the moment.
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Guide on how to use the UKeep Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" disabled><i class="fas fa-download fa-sm text-white-50"></i> Print this page</a>
          </div>


          <div class="row">
            <div class="col-xl-12">

            <!-- Introduction card -->  
              <div class="card shadow mb-4">
                <a href="#collapseCardIntro" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardIntro">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-info-circle"></i> Introduction</h6>
                </a>
                <div class="collapse show" id="collapseCardIntro">
                  <div class="card-body">
                    <p>Thank you for choosing our UKeep service. UKeep is an advanced online note/task managing service to keep you productive and organized. This guide will introduce you to all of UKeeps functionalities, so you can start right away.</p>
                    <p class="mb-0">More information coming soon..</p>
                  </div>
                </div>
              </div>
            
            <!-- Basic functionality card --> 
              <div class="card shadow mb-4">
                <a href="#collapseCardBasic" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardBasic">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Basic Functionality</h6>
                </a>
                <div class="collapse" id="collapseCardBasic">
                  <div class="card-body">
                    <p>To create your first note/task/label, click the <span class="font-weight-bold text-<?php echo $theme_color; ?>">New Item</span> link in your sidebar or click the plus icon below on the right side. To view them all, click on the <span class="font-weight-bold text-<?php echo $theme_color; ?>">Notes/Tasks</span> or <span class="font-weight-bold text-<?php echo $theme_color; ?>">Labels</span> link in the sidebar. Removed items can be found in the <span class="font-weight-bold text-<?php echo $theme_color; ?>">Trash</span> where they can be permanently deleted or restored.</p>

                    <p class="mb-0">More information coming soon..</p>
                  </div>
                </div>
              </div>

            <!-- Pages card -->  
              <div class="card shadow mb-4">
                <a href="#collapseCardPages" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardPages">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-globe"></i> Pages and their Features</h6>
                </a>
                <div class="collapse" id="collapseCardPages">
                  <div class="card-body">
                    <p>
                      <a href="../dashboard/">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> SMART Dashboard</span>
                      </a><br> This is your automatically updating SMART dashboard with information about your notes, tasks and labels.

                    </p>
                    <p class="mb-0">More information coming soon..</p>
                  </div>
                </div>
              </div>

            <!-- Customization card --> 
              <div class="card shadow mb-4">
                <a href="#collapseCardCustom" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardCustom">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-palette"></i> Customization</h6>
                </a>
                <div class="collapse" id="collapseCardCustom">
                  <div class="card-body">
                    <p>Info here</p>
                    <p class="mb-0">More information coming soon..</p><br>
                    <div class="text-white">
                      <a href="settings?customize=dashboard" class="btn btn-<?php echo $theme_color; ?> btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-wrench"></i>
                        </span>
                        <span class="text">Customize my dashboard</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            <!-- Free vs Premium account card -->
              <div class="card shadow mb-4">
                <a href="#collapseCardFreePrem" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardFreePrem">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-gem"></i> Free vs. Premium</h6>
                </a>
                <div class="collapse" id="collapseCardFreePrem">
                  <div class="card-body">
                    <p>As a premium member you can enjoy more features, like <span class="font-weight-bold text-<?php echo $theme_color; ?>">Teams</span> and <span class="font-weight-bold text-<?php echo $theme_color; ?>">Contacts</span>. These can also be found in the sidebar.</p>
                    <p class="mb-0">More information coming soon..</p>

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