<?php
  // This file is an extension of the edit.php file. 

  if (isset($_REQUEST['note_create'])){ // Create note request from the modal
    // variables from create note box
    $ins_title =  $_POST['new_note_title'];
    $ins_label =  $_POST['new_note_label'];
    $ins_content =  $_POST['new_note_description'];
    $ins_bookmark = $_POST['new_note_bookmark'];
    $ins_date = date("Y-m-d H:i:s");

    // Insert new task to table 'tasks' with userid
    $inssql = "INSERT INTO UKeepDAT.items_$user_code values('','$user_code','note','$ins_title','$ins_content','','$ins_date','$ins_label','','','$ins_bookmark','','ACTIVE','')";
    mysql_query($inssql) or die(mysql_error());
    header('location:items?view=notes&advanced_search&success=2');
    
  } elseif (isset($_REQUEST['task_create'])){ // Create task request from the modal
    // variables from create task box
    $ins_title =  $_POST['new_task_title'];
    $ins_label =  $_POST['new_task_label'];
    $duedate = $_POST['new_task_duedate'];
    $duetime = $_POST['new_task_duetime'];
    $ins_duedate = date('Y-m-d H:i:s', strtotime("$duedate $duetime"));
    $ins_priority = $_POST['new_task_priority'];
    $ins_content =  $_POST['new_task_description'];
    $ins_bookmark = $_POST['new_task_bookmark'];
    $ins_date = date("Y-m-d H:i:s");

    // Insert new task to table 'tasks' with userid
    $inssql = "INSERT INTO UKeepDAT.items_$user_code values('','$user_code','task','$ins_title','$ins_content','$ins_duedate','$ins_date','$ins_label','','','$ins_bookmark','$ins_priority','ACTIVE','')";
    mysql_query($inssql) or die(mysql_error());
    header('location:items?view=tasks&advanced_search&success=1');
    
  //} elseif (isset($_REQUEST['item_visit'])){ // Update item visit counter when someone leaves the item
    // code: request visited note by id, take visits and add one, update sql
    // header('location:home?success=1');
    
  } elseif (isset($_REQUEST['item_delete'])){ // Delete item (set status to TRASH, not actually deleted)
    
    $del_item_id = $_POST['item_id'];

    if ($del_item_id == ""){
      header('location:items?view=all&error=3');
    } else {
      $sql_delete = "UPDATE UKeepDAT.items_$user_code SET status='TRASH' WHERE id='$del_item_id'";
      mysql_query($sql_delete) or die(mysql_error());
      header('location:items?view=all&success=3');
    }

  } elseif (isset($_REQUEST['item_undelete'])){ // Undelete item (set status to ACTIVE)
    
    $rec_item_id = $_POST['item_id'];

    if ($rec_item_id == ""){
      header('location:trash?error=2');
    } else {
      $sql_recover = "UPDATE UKeepDAT.items_$user_code SET status='ACTIVE' WHERE id='$rec_item_id'";
      mysql_query($sql_recover) or die(mysql_error());
      header('location:items?view=all&success=3');
    }

 
  } elseif (isset($_REQUEST['item_perm_delete'])){ // Delete task request
    
    $del_item_id = $_POST['item_id'];

    if ($del_item_id == ""){
      header('location:trash?error=2');
    } else {
      $sql_delete = "DELETE FROM UKeepDAT.items_$user_code WHERE id='$del_item_id'";
      mysql_query($sql_delete) or die(mysql_error());
      header('location:trash?success=1');
    }
  } elseif (isset($_REQUEST['note_alter'])){ // Update task request
    
    $alt_id = $_POST['item_id'];
    $alt_title = mysql_real_escape_string($_REQUEST['note_alt_title']);
    $alt_label = mysql_real_escape_string($_REQUEST['note_alt_label']);
    $alt_priority = mysql_real_escape_string($_REQUEST['note_alt_priority']);
    $alt_status = mysql_real_escape_string($_REQUEST['note_alt_status']);
    $alt_description = mysql_real_escape_string($_REQUEST['note_alt_description']);
    $alt_bookmark = mysql_real_escape_string($_REQUEST['note_alt_bookmark']);
    $currentdate = date("Y-m-d H:i:s");
    
    $alter_note_sql = "UPDATE UKeepDAT.items_$user_code SET title='$alt_title', description='$alt_description', editdate='$currentdate', label='$alt_label', bookmark='$alt_bookmark', status='$alt_status' WHERE id='$alt_id'";
    mysql_query($alter_note_sql) or die(mysql_error());
    header('location:items?view=notes&advanced_search&success=5');

  } elseif (isset($_REQUEST['task_alter'])){ // Update task request
    
    $alt_id = $_POST['item_id'];
    $alt_title = mysql_real_escape_string($_REQUEST['task_alt_title']);
    $alt_label = mysql_real_escape_string($_REQUEST['task_alt_label']);
    $alt_duedate = mysql_real_escape_string($_REQUEST['task_alt_duedate']);
    $alt_priority = mysql_real_escape_string($_REQUEST['task_alt_priority']);
    $alt_location = mysql_real_escape_string($_REQUEST['task_alt_location']);
    $alt_people = mysql_real_escape_string($_REQUEST['task_alt_people']);
    $alt_status = mysql_real_escape_string($_REQUEST['task_alt_status']);
    $alt_description = mysql_real_escape_string($_REQUEST['task_alt_description']);
    $alt_bookmark = mysql_real_escape_string($_REQUEST['task_alt_bookmark']);
    $currentdate = date("Y-m-d H:i:s");
    
    $alter_task_sql = "UPDATE UKeepDAT.items_$user_code SET title='$alt_title', description='$alt_description', dateon='$alt_duedate', editdate='$currentdate', label='$alt_label', location='$alt_location', people='$alt_people', bookmark='$alt_bookmark', priority='$alt_priority', status='$alt_status' WHERE id='$alt_id'";
    mysql_query($alter_task_sql) or die(mysql_error());
    header('location:items?view=tasks&advanced_search&success=5');

  } elseif (isset($_REQUEST['item_transform'])){ // Update task request
    
    $alt_id = $_POST['item_id'];
    $alt_type = $_POST['alt_type'];

    if ($alt_type == "task"){
      $alt_type_set = "note";
    } else {
      $alt_type_set = "task";
    }

    $transform_sql = "UPDATE UKeepDAT.items_$user_code SET type='$alt_type_set' WHERE id='$alt_id'";
    mysql_query($transform_sql) or die(mysql_error());

    if ($alt_type == "task"){
      header('location:items?view=all&success=7');
    } else {
      header('location:items?view=all&success=6');
    }
    
  } else { // user visits page but nothing is selected to edit
    header("location:items?view=all&error=3");
  }

?>