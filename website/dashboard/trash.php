<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';  // $user_code from essentials.php

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Trashed Items &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <?php
        if ($_GET['success'] == "1") { // permanently deleted item
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-alt'></i> Item permanently removed. </div>";
        } elseif ($_GET['error'] == "1") { // error: something wrong
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
        } elseif ($_GET['error'] == "2") { // error: something wrong
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> You need to select an item first to perform an action.</div>";
        } elseif ($_GET['error'] == "3") { // error: no access
          echo "<div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> You dont have access to this feature.</div>";
        }
      ?>

      <h1 class="h3 mb-4 text-gray-800">Viewing category: 
        <div class="dropdown no-arrow" style="display:inline-block;">
          <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
            <i class="fas fa-trash-alt fa-sm fa-fw"></i> Trashed Items
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View Items by Type:</div>
            <a class="dropdown-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> All Items</a>
            <a class="dropdown-item" href="#"><i class="fas fa-fw fa-trash-alt"></i> Trash</a>
          </div>
        </div>
      </h1>

      <!-- Content Row -->
          <?php
            $final_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id WHERE status='TRASH'";
            $result = mysql_query($final_sql) or die(mysql_error());
            $num_rows = mysql_num_rows($result);

            $counttotal_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`='TRASH'";
            $counttotal_result = mysql_query($counttotal_sql) or die(mysql_error());
            $counttotal = mysql_num_rows($counttotal_result);
          ?>

          <div class="row">
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">
                    <?php 
                      $total_results = $num_rows."/".$counttotal." items";
                      echo "Notes and Tasks in the trash &bull; ".$total_results; // first variable in search-engine.php
                    ?>
                  </h6>
                  <div class="dropdown dropdown-lg no-arrow">
                    <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="items?view=all" style="text-decoration:none">
                      <i class="fas fa-clipboard fa-sm fa-fw"></i> All Items
                    </a>
                  </div>
                  
                </div>

              <!-- Card Body -->
              <div class="card-body right-click-support-items">
              <form action="edit" method="POST">
                  <div class="row form-group product-chooser">
                    <?php 
                      $layout_sql = "SELECT items_layout FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
                      $layout_result = mysql_query($layout_sql) or die(mysql_error());
                      $layout = mysql_fetch_array($layout_result);

                      if ($layout[0] == "0"){
                        include 'addons/items_layout_compact.php'; 
                      } else {
                        include 'addons/items_layout_big.php';
                      }

                    ?>
                  </div>

                  <!-- Right click support -->
                  <div class="dropdown-menu dropdown-menu-sm" id="context-menu">
                    <div class="dropdown-header text-<?php echo $theme_color; ?>">Perform an action:</div>
                    <button type="submit" class="dropdown-item" name="item_undelete"><i class="fas fa-recycle"></i> Recover Item</button>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#perDelModal"><i class="fas fa-dumpster"></i> Permanently delete item</a>
                  </div>

                  <div class="float-right">
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_undelete"><i class="fas fa-recycle"></i> Recover Item</button>
                    <a class="btn btn-<?php echo $theme_color; ?>" href="#" data-toggle="modal" data-target="#perDelModal"><i class="fas fa-dumpster"></i> Permanently delete item</a>
                  </div>

                  <!-- Permanently remove item Modal-->
                  <div class="modal fade" id="perDelModal" tabindex="-1" role="dialog" aria-labelledby="delModalPerm" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title text-<?php echo $theme_color; ?>" id="delModalPerm"><i class="fas fa-recycle"></i> Permanently delete this item?</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body"><b>You cannot undo this action.</b></div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_perm_delete"><i class="fas fa-recycle"></i> Permamently delete Item</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Right click support script -->
      <script type="text/javascript" src="addons/right-click-support.js"></script>

      <?php include 'site-footer.php'; ?>

</body>
</html>