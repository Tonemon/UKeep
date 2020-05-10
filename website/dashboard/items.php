<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';  // $user_code from essentials.php
include 'addons/search-engine.php'; // Custom made search engine for items + advanced search


// Note/Tasks creation mechanism redirect to: items?view=all&success=1 when successfull (dont forget ?view=all)

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Items Overview &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <?php
        if ($_GET['success'] == "1") { // created new task
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> New task created. </div>";
        } elseif ($_GET['success'] == "2") { // created new note
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> New note created. </div>";
        } elseif ($_GET['success'] == "3") { // deleted item (note/task)
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-alt'></i> Item removed. </div>";
        } elseif ($_GET['success'] == "4") { // item recovered from trash
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-restore-alt'></i> Item recovered. </div>";
        } elseif ($_GET['success'] == "5") { // item content changed
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-restore-alt'></i> Item edited. </div>";
        } elseif ($_GET['success'] == "6") { // item transformed from 'note' to 'task'
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-restore-alt'></i> Item transformed from note to task. </div>";
        } elseif ($_GET['success'] == "7") { // item trnasformed from 'task' to 'note'
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-trash-restore-alt'></i> Item transformed from task to note. </div>";
        } elseif ($_GET['error'] == "1") { // error: something wrong
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
        } elseif ($_GET['error'] == "2") { // error: no access
          echo "<div class='alert alert-danger alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> You dont have access to this feature.</div>";
        } elseif ($_GET['error'] == "3") { // error: accessing edit.php without item selected
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> You need so select an item to perform this action.</div>";
        }
      ?>

      <h1 class="h3 mb-4 text-gray-800">Viewing category: 
        <div class="dropdown no-arrow" style="display:inline-block;">
          <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
            <i class="fas fa-clipboard fa-sm fa-fw"></i> Items
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View Items by Type:</div>
            <a class="dropdown-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> All Items</a>
            <a class="dropdown-item" href="items?view=notes&advanced_search"><i class="fas fa-fw fa-sticky-note"></i> Notes only</a>
            <a class="dropdown-item" href="items?view=tasks&advanced_search"><i class="fas fa-fw fa-calendar-check"></i> Tasks only</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="items?status=active&advanced_search"><i class="fas fa-fw fa-calendar"></i> Active</a>
            <a class="dropdown-item" href="items?view=bookmarked&advanced_search"><i class="fas fa-fw fa-bookmark"></i> Bookmarked</a>
            <a class="dropdown-item" href="items?status=archived&advanced_search"><i class="fas fa-fw fa-archive"></i> Archived</a>
            <a class="dropdown-item" href="trash"><i class="fas fa-fw fa-trash-alt"></i> Trash</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header text-<?php echo $theme_color; ?>">Advanced Search:</div>
            <a class="dropdown-item" href="items?view=week&advanced_search"><i class="fas fa-fw fa-calendar-alt"></i> This week</a>
            <a class="dropdown-item" href="items?view=passed&advanced_search"><i class="fas fa-fw fa-calendar-times"></i> Passed Deadlines</a>
            <a class="dropdown-item" href="items?view=future&advanced_search"><i class="fas fa-fw fa-plane-departure"></i> Future</a>
          </div>
        </div>
      </h1>

      <!-- Content Row -->
          <?php
            $result = mysql_query($final_sql) or die(mysql_error());
            $num_rows = mysql_num_rows($result);

            $counttotal_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`!='TRASH'";
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
                      if ($num_rows == "1"){
                        $total_results = $num_rows." result / ".$counttotal." total items";
                      } else {
                        $total_results = $num_rows." results / ".$counttotal." total items";
                      }

                      echo $search_text_output.$total_results; // first variable in search-engine.php
                    ?>
                  </h6>
                  <div class="dropdown dropdown-lg no-arrow">
                    <a class="dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
                      <i class="fas fa-filter fa-sm fa-fw"></i> Filter
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" style="width: 450px">
                      <form action="items" class="form-horizontal" role="form">
                        <div class="dropdown-header text-<?php echo $theme_color; ?>"><b>Filtered Search:</b></div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header form-horizontal">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-4">
                              <label for="filter" class="text-<?php echo $theme_color; ?>">Priority</label>
                                <select class="form-control" name="priority">
                                    <option value="" selected>...</option>
                                    <option class="text-white bg-danger" value="high">High</option>
                                    <option class="bg-warning" value="medium">Medium</option>
                                    <option class="text-white bg-info" value="low">Low</option>
                                    <option class="text-white bg-secondary" value="none">None</option>
                                </select>
                              </div>
                              <div class="col-sm-4">
                                <label for="filter" class="text-<?php echo $theme_color; ?>">Label</label>
                                <select class="form-control" name="label">
                                  <option value="" selected>...</option>
                                  <?php
                                    $sql3 = "SELECT * FROM UKeepDAT.label_$user_code";
                                    $result3 = mysql_query($sql3) or die(mysql_error());
                                      
                                    while($rws3 = mysql_fetch_array($result3)){
                                      // displaying labels
                                      echo "<option value='".$rws3[1]."'>".$rws3[1]." (".strtolower($rws3[2]).")</option>";
                                    } 
                                  ?>
                                </select>
                              </div>
                              <div class="col-sm-4">
                                <label for="filter" class="text-<?php echo $theme_color; ?>">Status</label>
                                  <select class="form-control" name="status">
                                      <option value="" selected>...</option>
                                      <option value="active">Active</option>
                                      <option value="archived">Archived</option>
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="float-right">
                            <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="advanced_search">
                              <span class="icon text-white-50">
                                <i class="fas fa-search"></i>
                              </span>
                              <span class="text">Filtered Search</span>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
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
                    <button type="submit" class="dropdown-item" name="item_edit"><i class="fas fa-pencil-alt"></i> Edit Item</button>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delItemModal"><i class="fas fa-trash-alt"></i> Delete Item</a>
                  </div>

                  <div class="float-right">
                    <a href="#" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" data-toggle="modal" data-target="#delItemModal">
                      <span class="icon text-white-50">
                        <i class="fas fa-trash-alt"></i>
                      </span>
                      <span class="text">Delete item</span>
                    </a>
                    <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="item_edit">
                      <span class="icon text-white-50">
                        <i class="fas fa-pencil-alt"></i>
                      </span>
                      <span class="text">Edit Item</span>
                    </button>
                  </div>

                  <!-- Delete item Modal-->
                  <div class="modal fade" id="delItemModal" tabindex="-1" role="dialog" aria-labelledby="delModalItem" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title text-<?php echo $theme_color; ?>" id="delModalItem"><i class="fas fa-recycle"></i> Delete this item?</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">This item will be moved to the trash and can be recovered later.</div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_delete"><i class="fas fa-trash-alt"></i> Delete Item</button>
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