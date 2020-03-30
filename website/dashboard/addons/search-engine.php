<?php
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
      $addon_sql = " WHERE `dateon` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY) AND `type`='task'";

    } elseif ($func_view == "passed"){
      $addon_sql = " WHERE `dateon` < CURRENT_DATE() AND `type`='task'";
      $final_sql = $startsql.$addon_sql;

    } elseif ($func_view == "future"){
      $addon_sql = " WHERE `dateon` > DATE_ADD(NOW(), INTERVAL 7 DAY) AND `type`='task'";
      $final_sql = $startsql.$addon_sql;

    } elseif ($func_view == "notes"){
      $addon_sql = " WHERE type='note'";
      $final_sql = $startsql.$addon_sql;

    } elseif ($func_view == "tasks"){
      $addon_sql = " WHERE type='task'";
      $final_sql = $startsql.$addon_sql;

    } elseif ($func_view == "bookmarked"){
      $addon_sql = " WHERE bookmark='1'";
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

  } else { // no search yet, display all items (url: items?view=all)
    $final_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id";
    $search_text = "All Items (Notes and Tasks)";
  }

  if ($_GET['view'] == "all"){
    $search_text_output = 'All Items (Notes and Tasks) &bull; ';
  } elseif ($_GET['view'] == "notes"){
    $search_text_output = 'All Notes (Notes only) &bull; ';
  } elseif ($_GET['view'] == "tasks"){
    $search_text_output = 'All Tasks (Tasks only) &bull; ';
  } else {
    $search_text_output = $search_text.' &bull; ';
  }
?>