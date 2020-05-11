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
          <a href="/dashboard/logout.php" class="btn btn-<?php echo $theme_color; ?> btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-sign-out-alt"></i>
            </span>
            <span class="text">Logout</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Create new user Modal (1/2) -->
  <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="edit" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Create New Account</h5>
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

  <!-- Create new Registration Code Modal (2/2) -->
  <div class="modal fade" id="newCodeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="edit" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-<?php echo $theme_color; ?>" id="exampleModalLabel"><i class="fas fa-id-card-alt"></i> New Registration Code</h5>
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
  <script src="../vendor/js/right-click-support.js"></script>