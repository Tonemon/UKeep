<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';  // $user_code from essentials.php
include 'addons/search-engine.php'; // Custom made search engine for items + advanced search

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
            <a class="dropdown-item" href="items?view=bookmarked&advanced_search"><i class="fas fa-fw fa-star"></i> Bookmarked</a>
            <a class="dropdown-item" href="items?status=archived&advanced_search"><i class="fas fa-fw fa-archive"></i> Archived</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View Advanced:</div>
            <a class="dropdown-item" href="items?view=week&advanced_search"><i class="fas fa-fw fa-calendar-alt"></i> This week</a>
            <a class="dropdown-item" href="items?view=passed&advanced_search"><i class="fas fa-fw fa-calendar-times"></i> Passed Deadlines</a>
            <a class="dropdown-item" href="items?view=future&advanced_search"><i class="fas fa-fw fa-plane-departure"></i> Future</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View:</div>
            <a class="dropdown-item" href="labels"><i class="fas fa-fw fa-folder"></i> Labels</a>
          </div>
        </div>
      </h1>

      <!-- Content Row -->
          <?php include '../_inc/dbconn.php';
            $result = mysql_query($final_sql) or die(mysql_error());
            $num_rows = mysql_num_rows($result);

            $counttotal_sql = "SELECT title FROM UKeepDAT.items_$user_code";
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

                      if ($_GET['view'] == "all"){
                        echo 'All Items (Notes and Tasks) &bull; '.$total_results;
                      } elseif ($_GET['view'] == "notes"){
                        echo 'All Notes (Notes only) &bull; '.$total_results;
                      } elseif ($_GET['view'] == "tasks"){
                        echo 'All Tasks (Tasks only) &bull; '.$total_results;
                      } else {
                        echo $search_text.' &bull; '.$total_results;
                      }
                    ?>
                  </h6>
                  <div class="dropdown dropdown-lg no-arrow">
                    <a class="dropdown-toggle text-<?php echo $theme_color; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none">
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
                                    <option value="high">High Priority</option>
                                    <option value="medium">Medium Priority</option>
                                    <option value="low">Low Priority</option>
                                    <option value="none">None</option>
                                </select>
                              </div>
                              <div class="col-sm-4">
                                <label for="filter" class="text-<?php echo $theme_color; ?>">Label</label>
                                <select class="form-control" name="label">
                                  <option value="" selected>...</option>
                                  <?php include '../_inc/dbconn.php';
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
                          </div><br>
                          <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="advanced_search"><i class="fas fa-search"></i> Filtered Search</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row">
                    <?php 
                      while ($rws = mysql_fetch_array($result)){
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
                          if ($rws[12] == "ACTIVE"){
                            $icon = "fas fa-calendar-check";
                          } else {
                            $icon = "fas fa-archive";
                          }
                          
                        } else { // means it is set to 'note'
                          if ($rws[12] == "ACTIVE"){
                            $icon = "fas fa-sticky-note";
                          } else {
                            $icon = "fas fa-archive";
                          }
                        }

                        // making date readable
                        $createdate = date_create($rws[5]);
                        $Date = date_format($createdate,"l, d F Y, H:i");

                      // Item output while loop
                      ?>

                        <div class="col-lg-6 mb-4">
                          <a href="edit?task=<?php echo $rws[0]; ?>" style="text-decoration:none">
                          <div class="card text-dark shadow-lg">
                            <div class="card-body">
                              <h4><i class="<?php echo $icon; ?>"></i> 
                                <?php

                                  if ($rws[10] == "1"){
                                    echo '<i class="fas fa-star"></i> ';
                                  }

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

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'site-footer.php'; ?>

</body>
</html>