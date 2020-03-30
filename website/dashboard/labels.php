<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
// $user_code from essentials.php

  // Use selected label to perform actions on
  $labelid = $_POST['label_id'];

  if (isset($_REQUEST['label_create'])){ // Create label request
    $title =  $_POST['label_title'];
    $color =  $_POST['label_color'];

    // count current amount of labels
    $count_label = "SELECT count(*) FROM UKeepDAT.label_$user_code";
    $result_count=  mysql_query($count_label) or die(mysql_error());
    $label_count = mysql_fetch_array($result_count);

    if ($userdat_acctype == "normal" AND $label_count[0] >= "3"){ // normal users can only have 3 labels
      header('location:labels?error=2');
    } else {
      // Insert new label to table 'label' with user
      $sql = "INSERT INTO UKeepDAT.label_$user_code values('','$title','$color')";
      mysql_query($sql) or die(header('location:labels?error=1'));
      header('location:labels?success=1');
    }   
  } elseif (isset($_REQUEST['label_delete'])){ // Delete label request
    if ($labelid == ""){
      header('location:labels?error=3');
    } else {
      $sql_delete2 = "DELETE FROM UKeepDAT.label_$user_code WHERE `label_id` = '$labelid'";
      mysql_query($sql_delete2) or die(header("location:labels?error=1"));
      header('location:labels?success=2');
    }
  } elseif (isset($_REQUEST['label_alter'])){ // Alter label request
    $alterlabelid =  $_POST['label_alter_id'];
    $edit_title =  $_POST['label_alter_title'];
    $edit_color =  $_POST['label_alter_color'];
    
    $sql2 = "UPDATE UKeepDAT.label_$user_code SET name='$edit_title', color='$edit_color' WHERE label_id='$alterlabelid'";
    $result2 = mysql_query($sql2) or die(mysql_error());
    header('location:labels?success=3');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'extra/metadata.php'; ?>
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
      <h1 class="h3 mb-4 text-gray-800">Viewing category: 
        <div class="dropdown no-arrow" style="display:inline-block;">
          <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
            <i class="fas fa-folder fa-sm fa-fw"></i> Labels
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View Items by Type:</div>
            <a class="dropdown-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> Items</a>
            <div class="dropdown-item"><i class="fas fa-fw fa-folder"></i> Labels</div>
          </div>
        </div>
      </h1>

      <!-- Content Row -->
          <?php include '../_inc/dbconn.php';
            $viewlabel_sql = "SELECT * FROM UKeepDAT.label_$user_code";
            $label_result = mysql_query($viewlabel_sql) or die(mysql_error());
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
                        echo $label_num_rows." label total";
                      } else {
                        echo $label_num_rows." labels total";
                      }
                    ?>
                  </h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <form  action="labels">
                    <div class="row form-group product-chooser">
                      <?php
                        while ($rws = mysql_fetch_array($label_result)){
                          // color matching for the badges
                          $badgecolor = $rws[2];
                          # $rws[0] is the id of the label
                      ?>
                          <div class="col-lg-6 mb-4">
                              <div class="card text-dark product-chooser-item shadow-lg">
                                <div class="card-body">
                                  <h4><i class="fas fa-folder"></i> <span class='badge badge-<?php echo $badgecolor; ?>'><?php echo $rws[1]; ?></span></h4>
                                  <div class="small"><b>Description:</b> <i><?php echo $rws[3]; ?></i></div>
                                  <input type="radio" name="product" value="<?php echo $rws[0]; ?>">
                                </div>
                            </div>
                          </div>
                      <?php } ?><br><br>

                    </div><br>
                    <div class="float-right">
                      <button type="submit" class="btn btn-dark" name="label_delete"><i class="fas fa-trash-alt"></i> Delete Label</button>
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="label_edit"><i class="fas fa-pencil-alt"></i> Edit Label</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">New Label</h6>
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
                      <tbody>
                        <?php
                        while ($rws = mysql_fetch_array($label_result)){
                          // color matching for the badges
                          $badgecolor = $rws[2];
                          
                          // Displaying table items
                          echo "<tr>";
                          echo "<td><i class='far fa-folder-open'></i> <span class='badge badge-".$badgecolor."'>".$rws[1]."</span></td>";
                          echo "<td><input type='radio' name='label_id' value=".$rws[0]." /></td>";
                          echo "</tr>";
                        } ?>
                      </tbody>
                    </table>
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

</body>
</html>