<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
// $user_code variable from essentials.php

  if (isset($_REQUEST['label_create'])){ // Create label request
    $lab_id = $_POST['label_id'];

    $lab_title =  $_POST['label_title'];
    $lab_color =  $_POST['label_color'];
    $lab_description = $_POST['label_description'];

    // count current amount of labels
    $count_label = "SELECT count(*) FROM UKeepDAT.label_$user_code";
    $result_count=  mysql_query($count_label) or die(mysql_error());
    $label_count = mysql_fetch_array($result_count);

    // Insert new label to table 'label' with user
    $newlabelsql = "INSERT INTO UKeepDAT.label_$user_code values('','$lab_title','$lab_color','$lab_description')";
    mysql_query($newlabelsql) or die(header('location:labels?error=1'));
    header('location:labels?success=1');

  } elseif (isset($_REQUEST['label_delete'])){ // Delete label request
    $lab_id = $_POST['label_id'];

    if ($lab_id == ""){ // No label is selected to delete, but delete button is pressed
      header('location:labels?error=2');
    } else { // Label selected and button pressed, so delete label from db
      $sql_delete2 = "DELETE FROM UKeepDAT.label_$user_code WHERE `label_id` = '$lab_id'";
      mysql_query($sql_delete2) or die(header("location:labels?error=1"));
      header('location:labels?success=2');
    }

  } elseif (isset($_REQUEST['label_edit'])){ // Request to edit an item
    $labelid = $_POST['label_id'];

    if ($labelid == ""){ // No label is selected, but edit button is pressed
      header("Refresh: 0");
      header('location:labels?error=2');
    } else { // Label selected and button pressed, so grab label data from db
      $labelid = $_POST['label_id'];
      $edit_sql = "SELECT * FROM UKeepDAT.label_$user_code WHERE label_id='$labelid'";
      $edit_result = mysql_query($edit_sql) or die(mysql_error());
      $edit_vars = mysql_fetch_array($edit_result);
    }

  } elseif (isset($_REQUEST['label_alter'])){ // Alter label request
    $alterlabel_id =  $_POST['label_alter_id'];
    $alterlabel_title =  $_POST['label_alter_title'];
    $alterlabel_color =  $_POST['label_alter_color'];
    $alterlabel_description =  $_POST['label_alter_description'];

    $alter_sql = "UPDATE UKeepDAT.label_$user_code SET name='$alterlabel_title', color='$alterlabel_color', lab_description='$alterlabel_description' WHERE label_id='$alterlabel_id'";
    $alter_result = mysql_query($alter_sql) or die(mysql_error());
    header('location:labels?success=3');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Labels Overview &bull; UKeep</title>

  <link href="../vendor/css/custom-label-chooser.css" rel="stylesheet">
  <script src="../vendor/js/custom-label-chooser.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <?php
        if ($_GET['success'] == "1") {
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> New label created. </div>";
        } elseif ($_GET['success'] == "2") {
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> Label successfully deleted.</div>";
        } elseif ($_GET['success'] == "3") {
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> Label successfully edited.</div>";
        } elseif ($_GET['error'] == "1") {
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> Oh. Something went wrong. Please try again.</div>";
        } elseif ($_GET['error'] == "2") {
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-times'></i> No label selected to perform action. Please select one first.</div>";
        }
      ?>

      <h1 class="h3 mb-4 text-gray-800">Viewing category: 
        <div class="dropdown no-arrow" style="display:inline-block;">
          <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
            <i class="fas fa-folder fa-sm fa-fw"></i> Labels
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View:</div>
            <a class="dropdown-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> Items</a>
            <div class="dropdown-item"><i class="fas fa-fw fa-folder"></i> Labels</div>
          </div>
        </div>
      </h1>

          <?php include '../_inc/dbconn.php';
            $viewlabel_sql = "SELECT * FROM UKeepDAT.label_$user_code";
            $label_result = mysql_query($viewlabel_sql) or die(mysql_error());
            $label_num_rows = mysql_num_rows($label_result);                    
          ?>

          <div class="row">
            <?php // adjustable card size
              if (isset($_REQUEST['label_edit'])){
                  echo '<div class="col-xl-6 col-lg-7">';
                } else {
                  echo '<div class="col-xl-12 col-lg-7">';
              } 
            ?>
            <form action="labels" method="POST">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">View/Edit Labels &bull;
                    <?php 
                      if ($label_num_rows == "1"){
                        echo $label_num_rows." label total";
                      } else {
                        echo $label_num_rows." labels total";
                      }
                    ?>
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Label Actions:</div>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#newLabelModal"><i class="fas fa-fw fa-plus"></i> New Label</a>
                      <button class="dropdown-item" type="submit" name="label_edit"><i class="fas fa-pencil-alt"></i> Edit Label</button>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteLabelModal"><i class="fas fa-trash-alt"></i> Delete Label</a>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row form-group product-chooser">

                    <?php
                      while ($rws = mysql_fetch_array($label_result)){
                        // color matching for the badges
                        $badgecolor = $rws[2];
                    ?>

                      <?php // resizable div code
                          if (isset($_REQUEST['label_edit'])){
                            echo '<div class="col-lg-6 mb-4">';
                          } else {
                            echo '<div class="col-lg-4 mb-4">';
                          }
                      ?>
                        <div class="card text-dark product-chooser-item shadow-lg">
                          <div class="card-body">
                            <h4><i class="fas fa-folder"></i> <span class='badge badge-<?php echo $badgecolor; ?>'><?php echo $rws[1]; ?></span></h4>
                            <div class="small"><b>Description:</b> <i><?php echo $rws[3]; ?></i></div>
                            <input type="radio" name="label_id" value="<?php echo $rws[0]; ?>">
                          </div>
                        </div>
                      </div> <!-- Stop resizable div -->
                    <?php } ?><br><br>

                  </div><br>
                  <div class="float-right">
                    <a class="btn btn-dark" href="#" data-toggle="modal" data-target="#deleteLabelModal"><i class="fas fa-trash-alt"></i> Delete Label</a>
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="label_edit"><i class="fas fa-pencil-alt"></i> Edit Label</button>
                    <a class="btn btn-<?php echo $theme_color; ?>" href="#" data-toggle="modal" data-target="#newLabelModal"><i class="fas fa-fw fa-plus"></i> New Label</a>
                  </div>

                  <!-- Delete Label Modal-->
                  <div class="modal fade" id="deleteLabelModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title text-<?php echo $theme_color; ?>" id="deleteModalLabel"><i class="fas fa-fw fa-trash-alt"></i> Delete this label?</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="label_delete"><i class="fas fa-trash-alt"></i> Delete Label</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </form>
          </div>

            <?php if (isset($_REQUEST['label_edit'])){ // Edit label request ?>
            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Edit Label</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <form action="labels" method="POST">
                    <div class="row">
                      <div class="col-xl-7 form-group">
                        <input type="hidden" name="label_alter_id" value="<?php echo $labelid; ?>"/>
                        <small id="taskHelp" class="form-text">Label Title</small>
                        <input type="text" class="form-control" name="label_alter_title" value="<?php echo $edit_vars[1]; ?>">
                      </div>
                      <div class="col-xl-5 form-group">
                        <small id="taskHelp" class="form-text">Label Color</small>
                        <select class="form-control" name="label_alter_color">
                          <?php // color mapping for 'at the moment' in dropdown
                            if ($edit_vars[2] == "primary"){
                              $editlabelcolor = "Blue";
                            } elseif ($edit_vars[2] == "secondary"){
                              $editlabelcolor = "Gray";
                            } elseif ($edit_vars[2] == "success") {
                              $editlabelcolor = "Green";
                            } elseif ($edit_vars[2] == "danger"){
                              $editlabelcolor = "Red";
                            } elseif ($edit_vars[2] == "warning") {
                              $editlabelcolor = "Yellow";
                            } elseif ($edit_vars[2] == "info"){
                              $editlabelcolor = "Lightblue";
                            } elseif ($edit_vars[2] == "dark") {
                              $editlabelcolor = "Black";
                            }
                          ?>
                          <option value="<?php echo $edit_vars[2]; ?>" selected disabled><?php echo $editlabelcolor; ?> (at the moment)</option>
                          <option value="" disabled></option>
                          <option value="primary">Blue</option>
                          <option value="secondary">Gray</option>
                          <option value="success">Green</option>
                          <option value="danger">Red</option>
                          <option value="warning">Yellow</option>
                          <option value="info">Lightblue</option>
                          <option value="dark">Black</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl-12 form-group">
                        <small class="form-text">Label Description</small>
                        <textarea class="form-control" name="label_alter_description" rows="2"><?php echo $edit_vars[3]; ?></textarea>
                      </div>
                    </div>

                    <p>The following colors are supported:<br>
                      <span class="badge badge-primary">Blue</span>
                      <span class="badge badge-secondary">Gray</span>
                      <span class="badge badge-success">Green</span>
                      <span class="badge badge-danger">Red</span>
                      <span class="badge badge-warning">Yellow</span>
                      <span class="badge badge-info">Lightblue</span>
                      <span class="badge badge-dark">Black</span><br><br>

                    <a href="labels" class="btn btn-dark">Discard</a>
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="label_alter">Edit Label</button>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'site-footer.php'; ?>

</body>
</html>