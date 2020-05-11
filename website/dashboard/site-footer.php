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
          <a href="logout.php" class="btn btn-<?php echo $theme_color; ?> btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-sign-out-alt"></i>
            </span>
            <span class="text">Logout</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Create note Modal (1/3) -->
  <div class="modal fade" id="newNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="edit" method="POST">
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
                <input type="text" class="form-control" name="new_note_title" placeholder="Example: Lasagna Recipe" required>
              </div>
              <div class="col-xl-5 form-group">
                <small id="taskHelp" class="form-text">Add label</small>
                <select class="form-control" name="new_note_label">
                  <option value="" selected>None</option>
                  <?php 
                    $labels_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                    $labels_result = mysql_query($labels_sql) or die(mysql_error());

                    while ($labels_items = mysql_fetch_array($labels_result)){ // displaying labels ?>
                      <option class="bg-<?php echo $labels_items[2]; ?> text-white" value="<?php echo $labels_items[0]; ?>"><?php echo $labels_items[1]; ?></option>
                  <?php } ?> 
                </select>
              </div>
            </div>
            <small class="form-text">Description</small>
            <textarea class="form-control" name="new_note_description" rows="4" placeholder="You start by collecting all of the ingredients..." required></textarea><br>
            <small class="form-text"><input type="checkbox" name="new_note_bookmark" value="1"> Bookmark Note? (This will place it on your dashboard)</small>
            <small class="form-text"><i class="fas fa-info-circle"></i> You can add more information after saving the note.</small>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="note_create">
              <span class="icon text-white-50">
                <i class="fas fa-plus-square"></i>
              </span>
              <span class="text">Create Note</span>
            </button>
          </div>
        </div>
     </form>
    </div>
  </div>

  <!-- Create task Modal (2/3) -->
  <div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="edit" method="POST">
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
                <input type="text" class="form-control" name="new_task_title" placeholder="Example: Send presentation" required>
              </div>
              <div class="col-xl-5 form-group">
                <small id="taskHelp" class="form-text">Task label</small>
                <select class="form-control" name="new_task_label">
                  <option value="" selected>None</option>
                  <?php 
                    $labels_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                    $labels_result = mysql_query($labels_sql) or die(mysql_error());

                    while ($labels_items = mysql_fetch_array($labels_result)){ // displaying labels ?>
                      <option class="bg-<?php echo $labels_items[2]; ?> text-white" value="<?php echo $labels_items[0]; ?>"><?php echo $labels_items[1]; ?></option>
                  <?php } ?> 
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-8 form-group">
                <small id="taskHelp" class="form-text">Due Date</small>
                <div class="row">
                  <div class="col-sm-7">
                    <input type="date" class="form-control" name="new_task_duedate" required>
                  </div>
                  <div class="col-sm-5">
                    <input type="time" class="form-control" name="new_task_duetime" required>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 form-group">
                <small id="taskHelp" class="form-text">Priority</small>
                <select class="form-control" name="new_task_priority">
                  <option value="0" selected>None</option>
                  <option value="1">Low</option>
                  <option value="2">Medium</option>
                  <option value="3">High</option>
                </select>
              </div>
            </div>
            <small class="form-text">Task description</small>
            <textarea class="form-control" name="new_task_description" rows="2" placeholder="Send presentation to boss by 5:00 pm. Items to complete: ..." required></textarea><br>
            <small class="form-text"><input type="checkbox" name="new_task_bookmark" value="1"> Bookmark Task? (This will pin your task at the top of the tasks page.)</small>
            <small class="form-text"><i class="fas fa-info-circle"></i> More information can be added after creating the task.</small>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Discard</button>
            <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="task_create">
              <span class="icon text-white-50">
                <i class="fas fa-calendar-plus"></i>
              </span>
              <span class="text">Create task</span>
            </button>
          </div>
        </div>
     </form>
    </div>
  </div>

  <!-- Create label Modal (3/3) -->
    <div class="modal fade" id="newLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="labels" method="POST">
            <div class="modal-header">
              <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-folder"></i> New Label</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-xl-7 form-group">
                    <small id="taskHelp" class="form-text">Label Title</small>
                    <input type="text" class="form-control" name="label_title" placeholder="Example: Really Important" required>
                  </div>
                  <div class="col-xl-5 form-group">
                    <small id="taskHelp" class="form-text">Label Color</small>
                    <select class="form-control" name="label_color">
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
                    <textarea class="form-control" name="label_description" rows="1" placeholder="Example: This label is for business only..." required></textarea>
                  </div>
                </div>

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
              <button type="submit" class="btn btn-<?php echo $theme_color; ?> btn-icon-split" name="label_create">
                <span class="icon text-white-50">
                  <i class="fas fa-folder-plus"></i>
                </span>
                <span class="text">Create Label</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../vendor/js/sb-admin-2.min.js"></script>

  <!-- js-scroll-trigger: animated scroll (not using at the moment, but could be usefull in the future) -->
  <script src="../vendor/js/sb-admin-2.min.js"></script>

  <link href="../vendor/css/custom-label-chooser.css" rel="stylesheet">
  <script src="../vendor/js/custom-label-chooser.js"></script>

  <!-- Right click support script -->
  <script type="text/javascript" src="addons/right-click-support.js"></script>