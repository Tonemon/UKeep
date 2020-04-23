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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-info-circle"></i> Introduction</h6>
                </div>
                <div class="card-body">
                  <p>Thank you for choosing our UKeep service. UKeep is an advanced online note/task managing service to keep you productive and organized. This guide will introduce you to all of UKeeps functionalities, so you can start right away.</p>
                  <p class="mb-0">More information coming soon..</p>
                </div>
              </div>

            <!-- Basic functionality card -->  
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Basic Functionality</h6>
                </div>
                <div class="card-body">
                  <p>To create your first note/task/label, click the <span class="font-weight-bold text-<?php echo $theme_color; ?>">New Item</span> link in your sidebar or click the plus icon below on the right side. To view them all, click on the <span class="font-weight-bold text-<?php echo $theme_color; ?>">Notes/Tasks</span> or <span class="font-weight-bold text-<?php echo $theme_color; ?>">Labels</span> link in the sidebar. Removed items can be found in the <span class="font-weight-bold text-<?php echo $theme_color; ?>">Trash</span> where they can be permanently deleted or restored.</p>

                  <p class="mb-0">More information coming soon..</p>
                </div>
              </div>

            <!-- Pages card -->  
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-globe"></i> Details of different pages</h6>
                </div>
                <div class="card-body">
                  <p>
                    <a href="../dashboard/">
                      <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> SMART Dashboard</span>
                    </a><br> This is your automatically updating SMART dashboard with information about your notes, tasks and labels.

                  </p>
                  <p class="mb-0">More information coming soon..</p>
                </div>
              </div>

            <!-- Customization card -->  
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-palette"></i> Customization</h6>
                </div>
                <div class="card-body">
                  <p>Info here</p>
                  <p class="mb-0">More information coming soon..</p><br>
                  <div class="text-white"><a class="btn btn-<?php echo $theme_color; ?>" href="settings?customize=dashboard"><i class="fas fa-wrench"></i> Customize my dashboard</a></div>
                </div>
              </div>

            <!-- Free vs Premium account card -->  
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-gem"></i> Free vs. Premium</h6>
                </div>
                <div class="card-body">
                  <p>As a premium member you can enjoy more features, like <span class="font-weight-bold text-<?php echo $theme_color; ?>">Teams</span> and <span class="font-weight-bold text-<?php echo $theme_color; ?>">Contacts</span>. These can also be found in the sidebar.</p>
                  <p class="mb-0">More information coming soon..</p>

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