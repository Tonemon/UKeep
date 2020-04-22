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

          <?php if ($c_dash_start == "1"){ include 'cards/dash_start.php'; } // Start info card ?>


          <!-- Widgets Row -->
          <div class="row">
            <?php if ($c_dash_week == "1"){ include 'cards/dash_widget_week.php'; } // 'Items to do this week' card ?>


            <?php if ($c_dash_dead == "1"){ include 'cards/dash_widget_passed.php'; } // 'Task deadlines passed' card ?>


            <?php if ($c_dash_active == "1"){ include 'cards/dash_widget_active.php'; } // 'Active / Total tasks ratio' card ?>


            <?php if ($c_dash_ratio == "1"){ include 'cards/dash_widget_ratio.php'; } // 'Notes / Tasks ratio' card ?>

          </div>

          <div class="row">

            <?php if ($c_dash_chart1 == "1"){ include 'cards/dash_activity.php'; } // Activity Overview card (Chart 1) ?>


            <?php if ($c_dash_chart2 == "1"){ include 'cards/dash_type.php'; } // Item Type card (Chart 2) ?>

          </div>

          <div class="row">
            <div class="col-lg-6 mb-4">

              <?php if ($c_dash_labels == "1"){ include 'cards/dash_labels.php'; } // 'Label Usage' card ?>

            </div>

            <div class="col-xl-6 col-lg-7">
              <?php if ($c_dash_book == "1"){ include 'cards/dash_book.php'; } // 'Bookmarked Items' card ?>

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