<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php'; // $user_code and other variables from essentials.php
?>

<?php    
  if (isset($_REQUEST['item_edit'])){ // View item request (closing racket from addons/edit-process.php)
    $itemid = $_POST['item_id'];

    if ($itemid == ""){ // if button pressed, but no item selected
      header('location:items?view=all&error=3');
    } else { // button pressed and item selected
      $itemsql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id WHERE id='$itemid'";
      $itemresult = mysql_query($itemsql) or die(mysql_error());
      $itemres = mysql_fetch_array($itemresult);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Editing: '<?php echo $itemres[3]; ?>' &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

      <!-- Begin Page Content -->
      <div class="container-fluid">
      <form action="edit" method="POST">
        <h1 class="h3 mb-4 text-gray-800">Editing
          <?php if ($itemres[2] == "task"){ echo 'task: '; }
            else { echo 'note: '; } 

            echo '<span class="text-'.$theme_color.'">';
                // Icon support
                if ($itemres[10] == "1"){ // bookmarked
                  echo '<i class="fas fa-star fa-sm fa-fw"></i> ';
                } elseif ($itemres[2] == "task" AND $itemres[12] == "ACTIVE"){ // task and active
                  echo '<i class="fas fa-calendar-alt fa-sm fa-fw"></i> ';
                } elseif ($itemres[2] == "note"){ // note
                  echo '<i class="fas fa-sticky-note fa-sm fa-fw"></i> ';
                } else { // means it is a note/task, but archived
                  echo '<i class="fas fa-archive fa-sm fa-fw"></i> ';
                }

                // Title support
                echo $itemres[3];
              ?>
            </span>
        </h1>

        <div class="row">
        <?php if ($itemres[2] == "task"){ ?>

          <!-- Task editor -->
          <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Task Editor
                  <?php 
                    // echo ' <span class="text-dark">('.$itemres[13].'x visited)</span>'; // task visit count

                    // setting date format for last modified
                    $editdate = strtotime($itemres[6]);
                    $new_editdate = date('l, F d Y \a\t h:i', $editdate);
                  ?>
                </h6>
                <p class="dropdown-header float-right text-dark"><i><span class="text-<?php echo $theme_color; ?>">Last modified:</span> <?php echo $new_editdate; ?></i></p>            
              </div>

              <!-- Card Body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-6 form-group">
                    <input type="hidden" name="item_id" value="<?php echo $itemres[0];?>">
                    <input type="hidden" name="alt_type" value="<?php echo $itemres[2];?>">
                    <small id="taskHelp" class="form-text">Task Title</small>
                    <input type="text" class="form-control" name="task_alt_title" value="<?php echo $itemres[3];?>">
                  </div>
                  <div class="col-xl-6 form-group">
                    <small id="taskHelp" class="form-text">Task label</small>
                    <select class="form-control" name="task_alt_label">
                        <?php 
                          $labels_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                          $labels_result = mysql_query($labels_sql) or die(mysql_error());

                          while($labels_items = mysql_fetch_array($labels_result)){ // displaying labels ?>
                            <option class="bg-<?php echo $labels_items[2]; ?> text-white" value="<?php echo $labels_items[0]; ?>" <?php if ($itemres[7] == $labels_items[0]){ echo " selected"; } ?>><?php echo $labels_items[1]; ?></option>
                        <?php } ?> 
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-6 form-group">
                    <small id="taskHelp" class="form-text">Due Date &bull; <i>Date (DD-MM-YY) + Time (HH:MM)</i></small>
                    <?php 
                      $duedate = strtotime($itemres[5]);
                      $new_duedate = date('d-m-Y h:i:s', $duedate);
                      
                    ?>
                    <input type="text" class="form-control" name="task_alt_duedate" value="<?php echo $new_duedate; ?>">
                  </div>
                  <div class="col-xl-6 form-group">
                    <small id="taskHelp" class="form-text">Priority</small>
                    <?php
                      $prior_color = array("secondary", "info", "warning", "danger");
                      $prior_text = array("None", "Low", "Medium", "High");

                    ?>
                    <select class="form-control" name="task_alt_priority">
                      <option class="bg-<?php echo $prior_color[0]; ?> text-white" value="0" <?php if ($itemres[11] == "0"){ echo "selected"; } ?>>None</option>
                      <option class="bg-<?php echo $prior_color[1]; ?> text-white" value="1" <?php if ($itemres[11] == "1"){ echo "selected"; } ?>>Low</option>
                      <option class="bg-<?php echo $prior_color[2]; ?> text-white" value="2" <?php if ($itemres[11] == "2"){ echo "selected"; } ?>>Medium</option>
                      <option class="bg-<?php echo $prior_color[3]; ?> text-white" value="3" <?php if ($itemres[11] == "3"){ echo "selected"; } ?>>High</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-4 form-group">
                    <small id="taskHelp" class="form-text">Location</small>
                    <input type="text" class="form-control" name="task_alt_location" value="<?php echo $itemres[8]; ?>">
                  </div>
                  <div class="col-xl-4 form-group">
                    <small id="taskHelp" class="form-text">People</small>
                    <input type="text" class="form-control" name="task_alt_people" value="<?php echo $itemres[9]; ?>">
                  </div>
                  <div class="col-xl-4 form-group">
                    <small id="taskHelp" class="form-text">Status</small>
                    <select class="form-control" name="task_alt_status">
                      <option value="ACTIVE" <?php if ($itemres[12] == "ACTIVE"){ echo 'selected'; } ?>>Active</option>
                      <option value="ARCHIVED" <?php if ($itemres[12] == "ARCHIVED"){ echo 'selected'; } ?>>Archived</option>
                    </select>
                  </div>
                </div>
                <small class="form-text">Task description</small>
                <textarea class="form-control" name="task_alt_description" rows="2"><?php echo $itemres[4]; ?></textarea><br>

                <?php if ($itemres[10] == "1"){ $bookmark_set = "checked"; } // set bookmark tick or leave empty ?>
                <small class="form-text"><input type="checkbox" name="task_alt_bookmark" value="1" <?php echo $bookmark_set; ?>> Bookmark Task? (This will pin your task at the top of the tasks page.)</small><br>

                <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_transform"><i class="fas fa-random"></i> Transform Task to a Note</button>
                <div class="float-right">
                  <a class="btn btn-secondary" href="items?view=all">Discard</a>
                  <a class="btn btn-<?php echo $theme_color; ?>" href="#" data-toggle="modal" data-target="#deleteTaskModal"><i class="fas fa-trash-alt"></i> Delete Task</a>
                  <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="task_alter"><i class="fas fa-save"></i> Save Task</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Task Modal-->
          <div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTask" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title text-<?php echo $theme_color; ?>" id="deleteModalTask"><i class="fas fa-fw fa-trash-alt"></i> Delete this task?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">Deleting this task will move it to the trash.</div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_delete"><i class="fas fa-trash-alt"></i> Delete Task</button>
                </div>
              </div>
            </div>
          </div>

        <?php } else { ?>
          <!-- Note editor -->
          <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>">Note Editor
                  <?php 
                    // echo ' <span class="text-dark">('.$itemres[13].'x visited)</span>'; // note visit count

                    // setting date format for last modified
                    $editdate = strtotime($itemres[6]);
                    $new_editdate = date('l, F d Y \a\t h:i', $editdate);
                  ?>
                </h6>
                <p class="dropdown-header float-right text-dark"><i><span class="text-<?php echo $theme_color; ?>">Last modified:</span> <?php echo $new_editdate; ?></i></p>            
              </div>

              <!-- Card Body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-5 form-group">
                    <input type="hidden" name="item_id" value="<?php echo $itemres[0];?>">
                    <input type="hidden" name="alt_type" value="<?php echo $itemres[2];?>">
                    <small id="noteHelp" class="form-text">Note Title</small>
                    <input type="text" class="form-control" name="note_alt_title" value="<?php echo $itemres[3];?>">
                  </div>
                  <div class="col-xl-5 form-group">
                    <small id="noteHelp" class="form-text">Note label</small>
                    <select class="form-control" name="note_alt_label">
                        <?php 
                          $labels_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                          $labels_result = mysql_query($labels_sql) or die(mysql_error());

                          while($labels_items = mysql_fetch_array($labels_result)){ // displaying labels ?>
                            <option class="bg-<?php echo $labels_items[2]; ?> text-white" value="<?php echo $labels_items[0]; ?>" <?php if ($itemres[7] == $labels_items[0]){ echo " selected"; } ?>><?php echo $labels_items[1]; ?></option>
                        <?php } ?> 
                    </select>
                  </div>
                  <div class="col-xl-2 form-group">
                    <small id="noteHelp" class="form-text">Status</small>
                    <select class="form-control" name="note_alt_status">
                      <option value="ACTIVE" <?php if ($itemres[12] == "ACTIVE"){ echo 'selected'; } ?>>Active</option>
                      <option value="ARCHIVED" <?php if ($itemres[12] == "ARCHIVED"){ echo 'selected'; } ?>>Archived</option>
                    </select>
                  </div>
                </div>
                <small class="form-text">Note description</small>
                <textarea class="form-control" name="note_alt_description" rows="2"><?php echo $itemres[4]; ?></textarea><br>

                <?php if ($itemres[10] == "1"){ $bookmark_set = "checked"; } // set bookmark tick or leave empty ?>
                <small class="form-text"><input type="checkbox" name="note_alt_bookmark" value="1" <?php echo $bookmark_set; ?>> Bookmark Note? (This will pin your note at the top of the tasks page.)</small><br>

                <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_transform"><i class="fas fa-random"></i> Transform Note to a Task</button>
                <div class="float-right">
                  <a class="btn btn-secondary" href="items?view=all">Discard</a>
                  <a class="btn btn-<?php echo $theme_color; ?>" href="#" data-toggle="modal" data-target="#deleteNoteModal"><i class="fas fa-trash-alt"></i> Delete Note</a>
                  <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="note_alter"><i class="fas fa-save"></i> Save Note</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Task Modal-->
          <div class="modal fade" id="deleteNoteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalNote" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title text-<?php echo $theme_color; ?>" id="deleteModalNote"><i class="fas fa-fw fa-trash-alt"></i> Delete this note?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">Deleting this note will move it to the trash.</div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="item_delete"><i class="fas fa-trash-alt"></i> Delete Note</button>
                </div>
              </div>
            </div>
          </div>

        <?php } ?>
        </div><!-- /.row -->

      </form>
      </div>
      <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>

</body>
</html>

<?php 
    } // close else tag
 } // close if statement
  include 'addons/item-processing.php';
?>