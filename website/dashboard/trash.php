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
              <div class="card-body">
              <form action="edit" method="POST">
                  <div class="row form-group product-chooser">
                    <?php 
                      while ($rws = mysql_fetch_array($result)){
                        // color matching the badges
                        $badgecolor = $rws[16];

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

                        if ($rws[12] == "TRASH"){ // task and active
                          $icon = "fas fa-trash-alt";
                        } else { // means it is a note/task, but archived
                          $icon = "fas fa-question";
                        }

                        // making date readable
                        $Date = date_format(date_create($rws[5]),"l, d F Y, H:i");

                      // Item output while loop
                      ?>

                        <div class="col-lg-6 mb-4">
                          <?php if ($rws[10] == "1"){ ?>
                          <div class="card text-<?php echo $theme_color; ?> shadow-lg">
                          <?php } else { ?>
                          <div class="card text-dark product-chooser-item shadow-lg">
                          <?php } ?>
                            <div class="card-body">
                              <h4><i class="<?php echo $icon; ?>"></i> 
                                <?php
                                  echo $rws[3];

                                  if ($rws[12] == "ARCHIVED"){ // add '[archived]' text if item is archived
                                    echo ' <small><small><small>[ARCHIVED]</small></small></small>';
                                  }

                                  if ($rws[2] == "task"){ // adding a todo before if it is a task ?>
                                  <span class="float-right">
                                    <small><small><small><i>Todo before:</i> <b><?php echo $Date; ?></b></small></small></small>
                                  </span>
                                <?php } ?>
                              </h4>
                              <div class="small"><?php echo substr($rws[4], 0, 100); ?> ...</div>
                                <div class="small">
                                  <i>Label:</i> <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $rws[15]; ?></span>
                                  <?php if ($rws[2] == "task"){ ?>
                                  <i>Priority:</i> <span class="badge badge-<?php echo $priority_color; ?>"><?php echo $priority; ?></span>
                                  <?php } ?>
                                </div>
                              <input type="radio" name="item_id" value="<?php echo $rws[0]; ?>">
                            </div>
                          </div>
                        </div>
                      <?php }  ?>
                  </div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_undelete"><i class="fas fa-trash-restore-alt"></i> Recover Item</button>
                    <a class="btn btn-<?php echo $theme_color; ?>" href="#" data-toggle="modal" data-target="#perDelModal"><i class="fas fa-recycle"></i> Permanently delete item</a>
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

      <?php include 'site-footer.php'; ?>

</body>
</html>