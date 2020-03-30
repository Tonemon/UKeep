<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
// $user_code from essentials.php

if (isset($_REQUEST['normal_search'])){ // user presses the normal search button at the top of the page
  $startsql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_".$user_code.".label_id";

  $searchbar_input = $_GET['search'];
  $continuesql = " WHERE title LIKE '%".$searchbar_input."%' OR description LIKE '%".$searchbar_input."%' OR location LIKE '%".$searchbar_input."%' OR people LIKE '%".$searchbar_input."%' OR name LIKE '%".$searchbar_input."%'";

  $final_sql = $startsql.$continuesql;
  $search_text = "Search results for: '".$searchbar_input."'";

} elseif (isset ($_REQUEST['advanced_search'])){ // user presses the advanced search button
  // add check if normal or premium user

  $startsql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id";
  
  $func_view = $_GET['view'];
  if ($func_view == "all"){
    $addon_sql = "";

  } elseif ($func_view == "week"){
    $addon_sql = " WHERE `dateon` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)";

  } elseif ($func_view == "passed"){
    $addon_sql = " WHERE `dateon` < CURRENT_DATE()";
    $final_sql = $startsql.$addon_sql;

  } elseif ($func_view == "future"){
    $addon_sql = " WHERE `dateon` > CURRENT_DATE()";
    $final_sql = $startsql.$addon_sql;

  } elseif ($func_view == "notes"){
    $addon_sql = " WHERE type='note'";
    $final_sql = $startsql.$addon_sql;

  } elseif ($func_view == "tasks"){
    $addon_sql = " WHERE type='task'";
    $final_sql = $startsql.$addon_sql;

  } else { // (... selected) means 'view' dropdown is not being used, continueing with priority and labels.
    $func_priority = $_GET['priority'];
    if ($func_priority == "high"){
      $addon_sql1 = " WHERE priority=3";
    } elseif ($func_priority == "medium"){
      $addon_sql1 = " WHERE priority=2";
    } elseif ($func_priority == "low") { 
      $addon_sql1 = " WHERE priority=1";
    } elseif ($func_priority == "none"){
      $addon_sql1 = " WHERE priority=0";
    } else { // priority dropdown is not used (...)
      $addon_sql1 = "";
    }
    
    $func_label = $_GET['label'];
    if ($func_priority != "" AND $func_label != ""){ // 'priority' dropdown is being used
      $addon_sql2 = " AND name='".$func_label."'";
    } elseif ($func_priority == "" AND $func_label != ""){ // 'priority' dropdown is not being used
      $addon_sql2 = " WHERE name='".$func_label."'";
    } else { 
      $addon_sql2 = "";
    }

    $func_status = $_GET['status'];
    if ($func_status == "active"){ // priority and label is used, active
      if ($func_label == "" AND $func_priority == ""){
        $addon_sql3 = " WHERE status='ACTIVE'";
      } else {
        $addon_sql3 = " AND status='ACTIVE'";
      }
    } elseif ($func_status == "archived") { // $func_status == "ARCHIVED"
      if ($func_label == "" AND $func_priority == ""){ 
        $addon_sql3 = " WHERE status='ARCHIVED'";
      } else {
        $addon_sql3 = " AND status='ARCHIVED'";
      }
    } else {
      $addon_sql3 = "";
    }
  }

  if ($func_view == "" AND $func_priority == "" AND $func_label == "" AND $func_status == ""){ // no advanced options selected, but advanced search pressed
    $final_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id WHERE id='0'";
  } elseif ($func_view == ""){ // 'view' dropdown empty and 
    $final_sql = $startsql.$addon_sql1.$addon_sql2.$addon_sql3;
  } elseif ($func_view != ""){
    $final_sql = $startsql.$addon_sql;
  }

  $search_text = 'Advanced search results ';

} else { // no search yet, display all tasks (url: tasks?view=all)
  $final_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'extra/metadata.php'; ?>
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
            <div class="dropdown-header text-<?php echo $theme_color; ?>">Filter Items by Type:</div>
            <a class="dropdown-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> All Items</a>
            <a class="dropdown-item" href="items?view=notes&advanced_search"><i class="fas fa-fw fa-sticky-note"></i> Notes only</a>
            <a class="dropdown-item" href="items?view=tasks&advanced_search"><i class="fas fa-fw fa-calendar-check"></i> Tasks only</a>
            <a class="dropdown-item" href="items?status=archived&advanced_search"><i class="fas fa-fw fa-archive"></i> Archived</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header text-<?php echo $theme_color; ?>">Advanced:</div>
            <a class="dropdown-item" href="items?view=week&advanced_search"><i class="fas fa-fw fa-calendar-alt"></i> This week</a>
            <a class="dropdown-item" href="items?view=passed&advanced_search"><i class="fas fa-fw fa-calendar-times"></i> Passed Deadlines</a>
            <a class="dropdown-item" href="items?view=future&advanced_search"><i class="fas fa-fw fa-plane-departure"></i> Future</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header text-<?php echo $theme_color; ?>">View Labels:</div>
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