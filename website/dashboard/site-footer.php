<!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span class="text-<?php echo $theme_color; ?>">Copyright &copy; UKeep <?php echo date("Y"); ?>. Online planner and advanced note taking software.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded bg-<?php echo $theme_color; ?>" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div class="btn-group dropleft">
    <a href="#" class="btn btn-<?php echo $theme_color; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: fixed;right:0rem; bottom: 10rem; box-shadow: 0 4px 8px rgba(0,0,0,.05);border-radius: 10px 0px 0px 10px; font-size: 12px;padding: 0.8rem 0.5rem;" class="bg-<?php echo $theme_color; ?> shadow-lg">
        <i class="fas fa-fw fa-3x fa-plus-square text-white"></i>
    </a>
    <div class="dropdown-menu">
      <div class="dropdown-header text-<?php echo $theme_color; ?>"><b>Create new...</b></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#newNoteModal"><i class="fas fa-fw fa-sticky-note"></i> Note</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#newTaskModal"><i class="fas fa-fw fa-calendar-check"></i> Task</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#newLabelModal"><i class="fas fa-fw fa-folder"></i> Label</a>
    </div>
  </div>

  </div>
  <!-- End of Page Wrapper -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-fw fa-sign-out-alt"></i> Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-<?php echo $theme_color; ?>" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Create note Modal (1/3) -->
    <div class="modal fade" id="newNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
     <form action="edit.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-sticky-note"></i> New Note</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
      <div class="row">
        <div class="col-xl-7 form-group">
          <small id="taskHelp" class="form-text">Note Title</small>
          <input type="text" class="form-control" name="note_title" placeholder="Example: Lasagna Recipe">
        </div>
        <div class="col-xl-5 form-group">
          <small id="taskHelp" class="form-text">Add label</small>
          <select class="form-control" name="note_label">
            <option value="" selected>None</option>
              <?php 
                include '../_inc/dbconn.php';
                include 'essentials.php';
                $sql_note = "SELECT * FROM UKeepDAT.label_$user_code";
                $result = mysql_query($sql_note) or die(mysql_error());
                $num_rows = mysql_num_rows($result);

                while($rws = mysql_fetch_array($result)){
                  // displaying labels
                  echo "<option value='".$rws[0]."'>".$rws[1]." (".strtolower($rws[2]).")</option>";
                } 
              ?>
          </select>
        </div>
      </div>
      <small class="form-text">Description</small>
      <textarea class="form-control" name="note_description" rows="4" placeholder="You start by collecting all of the ingredients..."></textarea>
      <small class="form-text"><input type="checkbox" name="note_bookmark" value="1"> Bookmark Note? (This will place it on your dashboard)</small><br>
      <small class="form-text"><i class="fas fa-info-circle"></i> You can add more information after saving the note.</small>
      </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-<?php echo $theme_color; ?> icon save" name="note_create"><i class="fas fa-save"></i> Save Note</button>
          </div>
        </div>
     </form>
      </div>
    </div>

  <!-- Create task Modal (2/3) -->
    <div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
     <form action="edit.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-plus"></i> New Task</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
      <div class="row">
        <div class="col-xl-7 form-group">
          <small id="taskHelp" class="form-text">Task Title</small>
          <input type="text" class="form-control" name="task_title" placeholder="Example: Send presentation">
        </div>
        <div class="col-xl-5 form-group">
          <small id="taskHelp" class="form-text">Task label</small>
          <select class="form-control" name="task_label">
            <option value="" selected>None</option>
              <?php 
                /*include '../_inc/dbconn.php';
                $sql = "SELECT * FROM UKeepDAT.label".$user_id;
                $result = mysql_query($sql) or die(mysql_error());
                $num_rows = mysql_num_rows($result);

                while($rws = mysql_fetch_array($result)){
                  // displaying labels
                  echo "<option value='".$rws[0]."'>".$rws[1]." (".strtolower($rws[2]).")</option>";
                } 
              */?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-8 form-group">
          <small id="taskHelp" class="form-text">Due Date (date + time + AM/PM!)</small>
          <div class="row">
            <div class="col-sm-7">
              <input type="date" class="form-control" name="task_duedate">
            </div>
            <div class="col-sm-5">
              <input type="time" class="form-control" name="task_duetime">
            </div>
          </div>
        </div>
        <div class="col-xl-4 form-group">
          <small id="taskHelp" class="form-text">Priority</small>
          <select class="form-control" name="task_priority">
            <option value="0" selected>None</option>
            <option value="1">Low</option>
            <option value="2">Medium</option>
            <option value="3">High</option>
          </select>
        </div>
      </div>
      <small class="form-text">Task description</small>
      <textarea class="form-control" name="task_description" rows="2" placeholder="Send presentation to boss by 5:00 pm. Items to complete: ..."></textarea>
      <small class="form-text"><input type="checkbox" name="task_bookmark" value="1"> Bookmark Task? (This will pin your task at the top of the tasks page.)</small><br>
      <small class="form-text"><i class="fas fa-info-circle"></i> Want to add more information to this task? After creation you can add more on the edit task page.</small>
      </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-<?php echo $theme_color; ?> icon save" name="task_create"><i class="fas fa-save"></i> Save task</button>
          </div>
        </div>
     </form>
      </div>
    </div>

  <!-- Create label Modal (3/3) -->
    <div class="modal fade" id="newLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-folder"></i> New Label</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="edit.php" method="POST">
              <div class="row">
                <div class="col-xl-7 form-group">
                  <small id="taskHelp" class="form-text">Label Name</small>
                  <input type="text" class="form-control" name="label_name" placeholder="Example: Really Important">
                </div>
                <div class="col-xl-5 form-group">
                  <small id="taskHelp" class="form-text">Label Color</small>
                  <select class="form-control" name="task_label">
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
            </form>

            <p>The following colors are supported:<br>
              <span class="badge badge-primary">Blue</span>
              <span class="badge badge-secondary">Gray</span>
              <span class="badge badge-success">Green</span>
              <span class="badge badge-danger">Red</span>
              <span class="badge badge-warning">Yellow</span>
              <span class="badge badge-info">Lightblue</span>
              <span class="badge badge-dark">Black</span>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-<?php echo $theme_color; ?> icon save" name="task_create"><i class="fas fa-save"></i> Save Label</button>
          </div>
        </div>
      </div>
    </div>